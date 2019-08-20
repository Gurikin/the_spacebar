<?php

	namespace App\DataFixtures;

	use App\Entity\ApiToken;
	use App\Entity\User;
	use Doctrine\Common\Persistence\ObjectManager;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

	class UserFixture extends BaseFixtures
	{
		/**
		 * @var UserPasswordEncoderInterface
		 */
		private $userPasswordEncoder;

		/**
		 * UserFixture constructor.
		 * @param UserPasswordEncoderInterface $userPasswordEncoder
		 */
		public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
		{
			$this->userPasswordEncoder = $userPasswordEncoder;
		}

		protected function loadData(ObjectManager $manager)
		{
			$this->createMany(User::class, 10, function (User $user, $i) use ($manager) {
				$user->setEmail(sprintf('spacebar%d@example.com', $i));
				$user->setFirstName($this->faker->firstName);
				$user->setPassword($this->userPasswordEncoder->encodePassword($user, 'pass'));
				if ($this->faker->boolean) {
					$user->setTwitterUsername($this->faker->userName);
				}
				$user->agreeToTerms();
				$apiToken1 = new ApiToken($user);
				$apiToken2 = new ApiToken($user);
				$manager->persist($apiToken1);
				$manager->persist($apiToken2);
				$className = User::class;
				$manager->persist($user);
				$manager->flush();
				//store for usage later as App\Entity\ClassName_#COUNT#
				if (!$this->hasReference($className . '_' . $i)) {
					$this->addReference($className . '_' . $i, $user);
				} else {
					$this->addReference($className . '_' . $i . '_', $user);
				}
			});
			$this->createMany(User::class, 1, function (User $user, $i) use ($manager) {
				$user->setEmail(sprintf('admin%d@example.com', $i));
				$user->setFirstName($this->faker->firstName);
				$user->setPassword($this->userPasswordEncoder->encodePassword($user, 'pass'));
				$user->setRoles(['ROLE_ADMIN']);
				$user->agreeToTerms();
				$manager->persist($user);
				$manager->flush();
			});
//		$manager->flush();
		}
	}
