<?php

	namespace App\Controller;


	use App\Repository\UserRepository;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;

	/**
	 * Class AdminUtilityController
	 * @package App\Controller
	 */
	class AdminUtilityController extends AbstractController
	{
		/**
		 * @param UserRepository $userRepository
		 * @Route("/admin/utility/users", methods="GET")
		 * @return mixed
		 * @IsGranted("ROLE_ADMIN_ARTICLE")
		 */
		public function getUsersApi(UserRepository $userRepository)
		{
			$users = $userRepository->findAllEmailAlphabetical();

			return $this->json(
				['users' => $users],
				200,
				[],
				[
					'groups' => ['main']
				]
			);
		}
	}