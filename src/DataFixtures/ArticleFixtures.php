<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private static $articleTitles = [
        'Why Asteroids Taste Like Bacon',
        'Life on Planet Mercury: Tan, Relaxing and Fabulous',
        'Light Speed Travel: Fountain of Youth or Fallacy',
    ];
    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];
    private static $articleAuthors = [
        'Mike Ferengi',
        'Amy Oort',
        'Igor Gurik In'
    ];

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article) use ($manager) {
            $article->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setSlug($this->faker->slug)
                ->setContent(<<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
**turkey** shank eu pork belly meatball non cupim.
Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.
Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF
                );
            // publish most articles
            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }
            $i = $this->faker->numberBetween(0,9);
            if ($this->hasReference(User::class . '_' . $i))
            {
                $article->setAuthor($this->getReference(User::class . '_' . $i));
            } else {
                $article->setAuthor($this->getReference(User::class . '_0'));
            }
            $article->setHeartCount($this->faker->numberBetween(5, 100))
                ->setImageFilename($this->faker->randomElement(self::$articleImages));
            for ($i = 0; $i <= $this->faker->numberBetween(1, 10); $i++) {
                $comment = new Comment();
                $comment->setAuthorName($this->faker->randomElement(self::$articleAuthors))
                    ->setContent('You start about bacon again?!')
                    ->setArticle($article)
                    ->setIsDeleted($this->faker->boolean(20));
                $manager->persist($comment);
            }
            $tag = new Tag();
            $tag->setName($this->faker->realText(20));
            $manager->persist($tag);
            $article->addTag($tag);
            $manager->persist($article);
        });
        $manager->flush();
    }

//  /**
//   * This method must return an array of fixtures classes
//   * on which the implementing class depends on
//   *
//   * @return array
//   */
//  public function getDependencies()
//  {
//    return [TagFixture::class];
//  }
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
//  public function getDependencies()
//  {
//    return [TagFixture::class];
//  }
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [UserFixture::class, TagFixture::class];
    }
}
