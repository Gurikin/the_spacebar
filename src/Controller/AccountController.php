<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class AccountController extends BaseController
{
	/**
	 * @Route("/account", name="app_account")
	 * @param LoggerInterface $logger
	 * @return Response
	 */
	public function index(LoggerInterface $logger)
	{
		$logger->debug('Checking account page for ' . $this->getUser()->getEmail());
		return $this->render('account/index.html.twig', [
			'controller_name' => 'AccountController',
		]);
	}

	/**
	 * @Route ("/api/account", name="api_account")
	 */
	public function accountApi()
	{
		$user = $this->getUser();

		return $this->json($user, 200, [], ['groups' => 'main']);
	}
}
