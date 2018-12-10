<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Store\SendPaymentStore;
use App\Store\RequestPaymentStore;
use App\Store\UserStore;
use App\Store\TokenStore;


/**
 *  @Route("/user")
 */
class UserController extends AbstractController
{
	/**
	 *  @Route("/sendMoney")
	 */
	public function sendMoney(Request $request)
	{
		$params = $request->request->all();

		return $this->render('sendMoney.html.twig', [
			'userId' => $params['userid'],
			'tokenId' => $params['tokenid'],
		]);
	}

	/**
	 *  @Route("/requestMoney")
	 */
	public function requestMoney(Request $request)
	{
		$params = $request->request->all();

		return $this->render('requestMoney.html.twig', [
			'userId' => $params['userid'],
			'tokenId' => $params['tokenid'],
		]);
	}

	/**
	 *  @Route("/requestAction")
	 */
	public function requestAction(Request $request)
	{
		$params = $request->request->all();
		$requestStore = new RequestPaymentStore();
		$userStore = new UserStore();
		$tokenStore = new TokenStore();

		for($i=0; $i < $params['requestCount']; $i++)
		{
			$email = $params['email'.$i];
			$amount = $params['amount'.$i];

			$toUserId = $tokenStore->getUserIdForEmailPhone($email, $email)['USER_ID'];
			if(!$toUserId)
			{
				//create user
				$toUserId = $userStore->createDummyUser();
				$newToken['userid'] = $toUserId;
				if(strpos($email, "@"))
				{
					$newToken['email'] = $email;
					$newToken['phone'] = "";
				}
				else
				{
					$newToken['email'] = "";
					$newToken['phone'] = $email;
				}
				$newToken['password'] = NULL;
				$token = $tokenStore->createToken($newToken);
			}

			$requestArray['fromUserid'] = $params['fromUserid'];
			$requestArray['toUserid'] = $toUserId;
			$requestArray['amount'] = $amount;
			$requestArray['memo'] = $params['memo'];
			$requestStore->recordRequest($requestArray);
		}

		return $this->redirectToRoute("app_home_user", array('userid' => $params['fromUserid'], 'tokenid' => $params['fromTokenid']));
	}

	/**
	 *  @Route("/transferMoney")
	 */
	public function transferMoney(Request $request)
	{
		$params = $request->request->all();
		$sendPayment = new SendPaymentStore();
		$userStore = new UserStore();
		$tokenStore = new TokenStore();

		$toUser = $tokenStore->getUserIdForEmailPhone($params['email']);

		if(!$toUser)
		{
			//creating new user
			$userId = $userStore->createDummyUser();
			$newToken['userid'] = $userId;
			if(strpos($params['email'], "@"))
				$newToken['email'] = $params['email'];
			else
				$newToken['phone'] = $params['phone'];
			$newToken['password'] = NULL;
			$token = $tokenStore->createToken($newToken);

			$params['userid'] = $userId;
		}
		else
		{
			$userId = $toUser['USER_ID'];
		}

		$userStore->increaseBalanceForUserId($userId, $params['amount']);

		$result = $sendPayment->recordPayment($params);

		$userDetails = $userStore->getDetailsForUserId($params['fromUserid']);
		$amount = $userDetails['BALANCE'];

		if($amount - $params['amount'] < 0)
			$amount = 0;
		else
			$amount =  $amount - $params['amount'];

		$userStore->setBalanceForUserId($userDetails['USER_ID'], $amount);

		return $this->redirectToRoute("app_home_user", array('userid' => $params['fromUserid'], 'tokenid' => $params['fromTokenid']));
	}

}

