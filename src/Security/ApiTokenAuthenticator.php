<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\ApiTokenRepository;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * Class ApiTokenAuthenticator
 * @package App\Security
 */
class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
	/**
	 * @var ApiTokenRepository
	 */
	private $apiTokenRepo;

	/**
	 * ApiTokenAuthenticator constructor.
	 * @param ApiTokenRepository $apiTokenRepo
	 */
	public function __construct(ApiTokenRepository $apiTokenRepo)
	{
		$this->apiTokenRepo = $apiTokenRepo;
	}

	/**
	 * @param Request $request
	 * @return bool
	 */
	public function supports(Request $request)
	{
		//Postman don't wont to send the authorization header - suck
//        $request->headers->add(['Authorization' => 'Bearer 7c6313bb1bd6cdcf19f8474c5e93f21de292add3125a9011a512af6b947d7339f37bd1ccdb79e04e214812686c488c1a7ba778bf43119c01fdc2dfc0']);
		return $request->headers->has('Authorization')
			&& 0 === strpos($request->headers->get('Authorization'), 'Bearer ');
	}

	/**
	 * @param Request $request
	 * @return bool|mixed|string
	 */
	public function getCredentials(Request $request)
	{
		$authorizationHeader = $request->headers->get('Authorization');
		// skip beyond "Bearer "
		return substr($authorizationHeader, 7);
	}

	/**
	 * @param mixed $credentials
	 * @param UserProviderInterface $userProvider
	 * @return User|UserInterface|null
	 */
	public function getUser($credentials, UserProviderInterface $userProvider)
	{
		$token = $this->apiTokenRepo->findOneBy([
			'token' => $credentials
		]);

		if (!$token) {
			throw new CustomUserMessageAuthenticationException(
				'Invalid API Token'
			);
		}

		if ($token->isExpired()) {
			throw new CustomUserMessageAuthenticationException(
				'Token expired'
			);
		}

		return $token->getUser();
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
	 * @return JsonResponse|Response|null
	 */
	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		return new JsonResponse([
			'message' => $exception->getMessageKey()
		], 401);
	}

	/**
	 * @param Request $request
	 * @param TokenInterface $token
	 * @param string $providerKey
	 * @return string|Response|null
	 */
	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
	{

	}

	/**
	 * @param Request $request
	 * @param AuthenticationException|null $authException
	 * @return void
	 * @throws Exception
	 */
	public function start(Request $request, AuthenticationException $authException = null)
	{
		throw new Exception('Not used: entry_point from other authentication is used');
	}

	/**
	 * @return bool|void
	 */
	public function supportsRememberMe()
	{
		return false;
	}
}
