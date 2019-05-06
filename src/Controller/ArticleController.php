<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class ArticleController extends AbstractController
{
  /**
   * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
   * @param $slug
   */
  public function toggleArticleHeart($slug, LoggerInterface $logger)
  {
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
   * @param $slug
   * @return Response
   */
  public function show($slug, Environment $twigEnvironment)
  {
    $comments = [
      'I ate a normal rock once. It did NOT taste like bacon!',
      'Woohoo! I\'m going on an all-asteroid diet!',
      'I like bacon too! Buy some from my site! bakinsomebacon.com',
    ];

    /*return $this->render('article/show.html.twig', [
      'title' => ucwords(str_replace('-', ' ', $slug)),
      'comments' => $comments,
      'slug' => $slug
    ]);*/
    $html = $twigEnvironment->render('article/show.html.twig', [
      'title' => ucwords(str_replace('-', ' ', $slug)),
      'comments' => $comments,
      'slug' => $slug
    ]);
    return new Response($html);
  }
}