<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
}