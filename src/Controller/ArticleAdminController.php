<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleAdminController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN_ARTICLE")
 */
class ArticleAdminController extends AbstractController
{
  /**
   * @Route("/admin/article/new", name="admin_article_new")
   * @param EntityManagerInterface $em
   * @return string
   */
  public function new(EntityManagerInterface $em)
  {
    $article = $em->find(Article::class,495);
    return new Response(sprintf(
      'Hiya! New Article id: #%d slug: %s',
      $article->getId(),
      $article->getSlug()
    ));
  }
}