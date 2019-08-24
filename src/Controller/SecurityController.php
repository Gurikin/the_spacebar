<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Model\UserRegistrationFormModel;
use App\Form\UserRegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
	/**
	 * @Route("/login", name="app_login")
	 * @param AuthenticationUtils $authenticationUtils
	 * @return Response
	 */
	public function login(AuthenticationUtils $authenticationUtils)
	{
		$error = $authenticationUtils->getLastAuthenticationError();
		$lastUserName = $authenticationUtils->getLastUsername();
		return $this->render('security/login.html.twig', [
			'error' => $error,
			'last_username' => $lastUserName
		]);
	}

	/**
	 * @Route("/logout", name="app_logout")
	 * @throws Exception
	 */
	public function logout()
	{
		return $this->redirectToRoute('app_login');
	}

	/**
	 * @Route("/register", name="app_register")
	 * @param Request $request
	 * @param UserPasswordEncoderInterface $userPasswordEncoder
	 * @param GuardAuthenticatorHandler $guardAuthenticatorHandler
	 * @param LoginFormAuthenticator $loginFormAuthenticator
	 * @return Response
	 */
	public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, GuardAuthenticatorHandler $guardAuthenticatorHandler, LoginFormAuthenticator $loginFormAuthenticator)
	{
		$form = $this->createForm(UserRegistrationFormType::class);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			/** @var UserRegistrationFormModel $user */
			$userModel = $form->getData();
			$user = new User();
			$user->setEmail($userModel->email);
			$user->setPassword($userPasswordEncoder->encodePassword(
				$user,
				$userModel->plainPassword
			));
			if (true === $userModel->agreeTerms) {
				$user->agreeToTerms();
			}


			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($user);
			$entityManager->flush();

			return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
				$user,
				$request,
				$loginFormAuthenticator,
				'main'
			);
		}

		return $this->render('security/register.html.twig',
			[
				'registrationForm' => $form->createView(),
			]
		);
	}
}
