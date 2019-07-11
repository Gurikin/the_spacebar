<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

/**
 * Class LoginFormAuthenticator
 * @package App\Security
 */
class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
  /**
   * @var UserRepository
   */
  private $userRepository;

  /**
   * LoginFormAuthenticator constructor.
   * @param UserRepository $userRepository
   */
  public function __construct(UserRepository $userRepository) {
    $this->userRepository = $userRepository;
  }

  /**
   * @param Request $request
   * @return bool|void
   */
  public function supports(Request $request)
  {
    // do your work when we're POSTing to the login page
    return $request->attributes->get('_route') === 'app_login' &&
      $request->isMethod('POST');
  }

  /**
   * @param Request $request
   * @return array|mixed
   */
  public function getCredentials(Request $request)
  {
    return [
      'email' => $request->request->get('email'),
      'password' => $request->request->get('password'),
    ];
  }

  /**
   * @param mixed $credentials
   * @param UserProviderInterface $userProvider
   * @return UserInterface|void|null
   */
  public function getUser($credentials, UserProviderInterface $userProvider)
  {
    return $this->userRepository->findOneBy(['email' => $credentials['email']]);
  }

  /**
   * @param mixed $credentials
   * @param UserInterface $user
   * @return bool|void
   */
  public function checkCredentials($credentials, UserInterface $user)
  {
    return true;
  }

  /**
   * @param Request $request
   * @param AuthenticationException $exception
   * @return RedirectResponse|void
   */
  public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
  {

  }

  /**
   * @param Request $request
   * @param TokenInterface $token
   * @param string $providerKey
   * @return Response|void|null
   */
  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
  {
    dd('Success');
  }

  /**
   * @param Request $request
   * @param AuthenticationException|null $authException
   * @return RedirectResponse|void
   */
  public function start(Request $request, AuthenticationException $authException = null)
  {
    // todo
  }

  /**
   * @return bool|void
   */
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
