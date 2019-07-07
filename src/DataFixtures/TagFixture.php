<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixture extends BaseFixtures/* implements DependentFixtureInterface*/
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

  protected function loadData(ObjectManager $manager)
  {
//    $this->createMany(Tag::class, 10, function(Tag $tag) use ($manager) {
//      $tag->setName($this->faker->realText(20));
//      $manager->persist($tag);
//    });
//    $manager->flush();
  }

//  /**
//   * This method must return an array of fixtures classes
//   * on which the implementing class depends on
//   *
//   * @return array
//   */
//  public function getDependencies()
//  {
//    return [ArticleFixtures::class];
//  }
}
