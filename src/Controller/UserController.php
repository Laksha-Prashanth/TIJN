<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Store\SendPaymentStore;
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
	 *  @Route("/transferMoney")
	 */
	public function transferMoney(Request $request)
	{
		$params = $request->request->all();
		$sendPayment = new SendPaymentStore();
		$userStore = new UserStore();
		$tokenStore = new TokenStore();

		$toUser = $tokenStore->getUserIdForEmailPhone($params['email'], $params['phone']);

		if(!$toUser)
		{
			//creating new user
			$userId = $userStore->createDummyUser($params);
			$newToken['userid'] = $userId;
			$newToken['email'] = $params['email'];
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

