<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Store\SendPaymentStore;


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

		$result = $sendPayment->transferMoney($params);

		return $this->redirectToRoute("app_home_user", array('userid' => $params['userid'], 'tokenid' => $params['tokenid']));
	}

}
