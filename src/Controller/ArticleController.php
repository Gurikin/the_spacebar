<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends Controller
{
  /**
   * @Route("/")
   */
  public function homepage() {
    return new Response('OMG! My first page already! WOOO!');
  }

  /**
   * @Route("/news/{slug}")
   * @param $slug
   * @return Response
   */
  public function show($slug)
  {
    return new Response(sprintf(
      'Future page to show the article: "%s"',
      $slug
    ));
  }
}