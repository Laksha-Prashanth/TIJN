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
 *  @Route("/bank")
 */
class BankController extends AbstractController
{
	/**
	 *  @Route("/addAccount")
	 */
	public function addAccount(Request $request)
	{
		$params = $request->request->all();

		return $this->render('addAccount.html.twig', [
			'userId' => $params['userid']
		]);
	}

	/**
	 *  @Route("/createAccount")
	 */
	public function createAccount(Request $request)
	{
		$params = $request->request->all();
		$bankStore = new BankStore();

		if(!array_key_exists("primary",$params))
			$params['primary'] = 'N';
		$result = $bankStore->createAccount($params);

		return $this->redirectToRoute("app_home_user", array('userid' => $params['userid'], 'tokenid' => $params['tokenid']));
	}

	/**
	 *  @Route("/setPrimary")
	 */
	public function setPrimary(Request $request)
	{
		$params = $request->request->all();
		$bankStore = new BankStore();

		$result = $bankStore->setPrimary($params);

		return $this->redirectToRoute("app_home_user", array('userid' => $params['userid'], 'tokenid' => $params['tokenid']));
	}


}
