<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Http\Client\Exception;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class ArticleController extends AbstractController
{
  /**
   * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
   * @param $slug
   * @return JsonResponse
   */
  public function toggleArticleHeart($slug, LoggerInterface $logger) {
    // TODO - actually heart/unheart the article!
    $logger->info('Article is being hearted!');
    return $this->json(['hearts' => rand(5, 100)]);
  }

  /**
   * @Route("/", name="app_homepage")
   */
  public function homepage() {
    return $this->render('article/homepage.html.twig');
  }

  /**
   * @Route("/news/{slug}", name="article_show")
   * @param string $slug
   * @param MarkdownHelper $markdownHelper
   * @param bool $isDebug
   * @param SlackClient $slack
   * @param EntityManagerInterface $entityManager
   * @return Response
   * @throws Exception
   */
  public function show($slug,
                       bool $isDebug,
                       SlackClient $slack,
                       EntityManagerInterface $entityManager) : Response {
    if ($slug === 'testSlack') {
      $slack->sendMessage('Kahn', 'Ah, Kirk, my old friend...');
    }
    $repository = $entityManager->getRepository(Article::class);
    /** @var Article $article */
    $article = $repository->findOneBy(['slug'=>$slug]);
    if (!$article) {
      throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
    }

    $comments = [
      'I ate a normal rock once. It did NOT taste like bacon!',
      'Woohoo! I\'m going on an all-asteroid diet!',
      'I like bacon too! Buy some from my site! bakinsomebacon.com',
    ];

    $html = $this->render('article/show.html.twig', [
      'title' => ucwords(str_replace('-', ' ', $slug)),
      'comments' => $comments,
      'slug' => $slug,
      'article' => $article
    ]);
    return new Response($html);
  }
}