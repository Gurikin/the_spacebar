<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
  /**
   * @param Request $request
   * @return bool|void
   */
  public function supports(Request $request)
  {
    die('Our authenticator is alive!');
  }

  public function getCredentials(Request $request)
  {
    // todo
  }

  public function getUser($credentials, UserProviderInterface $userProvider)
  {
    // todo
  }

  public function checkCredentials($credentials, UserInterface $user)
  {
    // todo
  }

  public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
  {
    // todo
  }

  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
  {
    // todo
  }

  public function start(Request $request, AuthenticationException $authException = null)
  {
    // todo
  }

  public function supportsRememberMe()
  {
    // todo
  }

  /**
   * Return the URL to the login page.
   *
   * @return string
   */
  protected function getLoginUrl()
  {
    // TODO: Implement getLoginUrl() method.
  }
}
