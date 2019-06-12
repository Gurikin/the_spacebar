<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Http\Client\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
  /**
   * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
   * @param Article $article
   * @param LoggerInterface $logger
   * @param EntityManagerInterface $entityManager
   * @return JsonResponse
   */
  public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $entityManager)
  {
    $article->incrementHeartCount();
    $entityManager->persist($article);
    $entityManager->flush();
    $logger->info('Article is being hearted!');
    return $this->json(['hearts' => $article->getHeartCount()]);
  }

  /**
   * @Route("/", name="app_homepage")
   * @param ArticleRepository $articleRepository
   * @return Response
   */
  public function homepage(ArticleRepository $articleRepository)
  {
    $articles = $articleRepository->findAllPublishedOrderedByNewest();
    return $this->render('article/homepage.html.twig', [
      'articles' => $articles
    ]);
  }

  /**
   * @Route("/news/{slug}", name="article_show")
   * @param Article $article
   * @param SlackClient $slack
   * @return Response
   * @throws Exception
   */
  public function show(Article $article,
                       SlackClient $slack): Response
  {
    if ($article->getSlug() === 'testSlack') {
      $slack->sendMessage('Kahn', 'Ah, Kirk, my old friend...');
    }

    $comments = [
      'I ate a normal rock once. It did NOT taste like bacon!',
      'Woohoo! I\'m going on an all-asteroid diet!',
      'I like bacon too! Buy some from my site! bakinsomebacon.com',
    ];

    $html = $this->render('article/show.html.twig', [
      'title' => ucwords(str_replace('-', ' ', $article->getSlug())),
      'comments' => $comments,
      'slug' => $article->getSlug(),
      'article' => $article
    ]);
    return new Response($html);
  }
}