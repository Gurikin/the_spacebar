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
			$apiToken1 = new ApiToken($user);
			$apiToken2 = new ApiToken($user);
			$manager->persist($apiToken1);
			$manager->persist($apiToken2);
		});
		$this->createMany(User::class, 1, function (User $user, $i) {
			$user->setEmail(sprintf('admin%d@example.com', $i));
			$user->setFirstName($this->faker->firstName);
			$user->setPassword($this->userPasswordEncoder->encodePassword($user, 'pass'));
			$user->setRoles(['ROLE_ADMIN']);
		});
		$manager->flush();
	}
}
