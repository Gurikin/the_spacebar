<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
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
   * @var RouterInterface
   */
  private $router;
  /**
   * @var CsrfTokenManagerInterface
   */
  private $csrfTokenManager;

  /**
   * LoginFormAuthenticator constructor.
   * @param UserRepository $userRepository
   * @param RouterInterface $router
   * @param CsrfTokenManagerInterface $csrfTokenManager
   */
  public function __construct(UserRepository $userRepository, RouterInterface $router, CsrfTokenManagerInterface $csrfTokenManager)
  {
    $this->userRepository = $userRepository;
    $this->router = $router;
    $this->csrfTokenManager = $csrfTokenManager;
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
    $credentials = [
      'email' => $request->request->get('email'),
      'password' => $request->request->get('password'),
      'csrf_token' => $request->request->get('_csrf_token'),
    ];
    $request->getSession()->set(
      Security::LAST_USERNAME,
      $credentials['email']
    );
    return $credentials;
  }

  /**
   * @param mixed $credentials
   * @param UserProviderInterface $userProvider
   * @return UserInterface|void|null
   */
  public function getUser($credentials, UserProviderInterface $userProvider)
  {
    $token = new CsrfToken('authenticate', $credentials['csrf_token']);
    if (!$this->csrfTokenManager->isTokenValid($token)){
      throw new InvalidCsrfTokenException();
    }
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

//  /**
//   * @param Request $request
//   * @param AuthenticationException $exception
//   * @return RedirectResponse|void
//   */
//  public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
//  {
//
//  }

  /**
   * @param Request $request
   * @param TokenInterface $token
   * @param string $providerKey
   * @return Response|void|null
   */
  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
  {
    return new RedirectResponse($this->router->generate('app_homepage'));
  }

//  /**
//   * @param Request $request
//   * @param AuthenticationException|null $authException
//   * @return RedirectResponse|void
//   */
//  public function start(Request $request, AuthenticationException $authException = null)
//  {
//    // todo
//  }
//
//  /**
//   * @return bool|void
//   */
//  public function supportsRememberMe()
//  {
//    // todo
//  }

  /**
   * Return the URL to the login page.
   *
   * @return string
   */
  protected function getLoginUrl()
  {
    return $this->router->generate('app_login');
  }
}