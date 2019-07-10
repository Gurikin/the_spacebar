<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixtures extends BaseFixtures/* implements DependentFixtureInterface*/
{
  protected function loadData(ObjectManager $manager)
  {
//    $this->createMany(Comment::class, 100, function (Comment $comment, $i) use ($manager) {
//      $comment->setContent(
//        $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
//      );
//      $comment->setAuthorName($this->faker->name);
//      $comment->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
//      $comment->setArticle($this->getRandomReference(Article::class));
//      $manager->persist($comment);
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
