<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Store\UserStore;
use App\Store\TokenStore;


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
		]);
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
