<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Store\UserStore;
use App\Store\TokenStore;
use App\Store\BankStore;


/**
 *  @Route("/")
 */
class HomeController extends AbstractController
{
	/**
	 *  @Route("/home")
	 */
	public function home()
	{
		return $this->render('home.html.twig', [
			'validateError'=> false
		]);
	}

	/**
	 *  @Route("/user")
	 */
	public function user(Request $request)
	{
		$params = $request->query->all();
		$userStore = new UserStore();
		$bankStore = new BankStore();

		$userDetails = $userStore->getDetailsForUserId($params['userid']);
		$bankDetails = $bankStore->getDetailsforUserId($params['userid']);




		return $this->render('user.html.twig', [
			'userId' => $userDetails['USER_ID'],
			'tokenId' => $params['tokenid'],
			'firstName' => $userDetails['FIRST_NAME'],
			'lastName' => $userDetails['LAST_NAME'],
			'balance' => $userDetails['BALANCE'],
			'ssn' => $userDetails['SSN'],
			'plan' => $userDetails['PLAN_ID'],
			'isConfirmed' => $userDetails['IS_CONFIRMED'],
			'bankAccounts' => $bankDetails,
		]);

	}

	/**
	 *  @Route("/login")
	 */
	public function login(Request $request)
	{
		$params = $request->request->all();
		$tokenStore = new TokenStore();

		$login['email'] = $params['email'];
		$login['password'] = $params['password'];

		$result = $tokenStore->login($login);

		if($tokenStore->login($login))
		{
			return $this->redirectToRoute("app_home_user", array('userid' => $result['USER_ID'], 'tokenid' => $result['TOKEN_ID']));
		}
		else
		{
			return $this->render('home.html.twig', [
				'validateError'=> true
			]);
		}

	}

	/**
	 *  @Route("/signup")
	 */
	public function signup(Request $request)
	{
		$params = $request->request->all();
		$userStore = new UserStore();
		$tokenStore = new TokenStore();


		$user['firstName'] = $params['firstName'];
		$user['email'] = $params['email'];
		$user['phone'] = $params['phone'];
		$user['ssn'] = $params['ssn'];
		$user['lastName'] = $params['lastName'];
		$user['password'] = $params['password'];
		$userId = $userStore->createUser($user);

		$user['userid'] = $userId;
		$tokenStore->createToken($user);


		return $this->render('userSuccess.html.twig', [
		]);
	}
}
