<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixtures
{
  protected function loadData(ObjectManager $manager)
  {
    $this->createMany(User::class, 10, function(User $user, $i) {
      $user->setEmail(sprintf('spacebar%d@example.com', $i));
      $user->setFirstName($this->faker->firstName);
    });
    $manager->flush();
  }
}
