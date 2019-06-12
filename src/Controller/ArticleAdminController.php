<?php


namespace App\Controller;


use App\Entity\Article;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
  /**
   * @Route("/admin/article/new")
   * @param EntityManagerInterface $em
   * @return Response
   * @throws Exception
   */
  public function new(EntityManagerInterface $em)
  {
    die('todo');
//    return new Response(sprintf(
//      'Hiya! New Article id: #%d slug: %s',
//      $article->getId(),
//      $article->getSlug()
//    ));
  }
}