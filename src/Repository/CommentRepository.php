<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comment::class);
    }

  public static function createNonDeletedCriteria(): Criteria
  {
    return Criteria::create()
      ->andWhere(Criteria::expr()->eq('isDeleted', false))
      ->orderBy(['createdAt' => 'DESC'])
      ;
  }

  /**
   * @param string|null $term
   * @return Comment[]
   */
  public function findAllWithSearch(?string $term)
  {
    $queryBuilder = $this->createQueryBuilder('c')
    ->innerJoin('c.article', 'a')
    ->addSelect('a');
    if ($term) {
      $queryBuilder->andWhere('c.content LIKE :term OR c.authorName LIKE :term OR a.title LIKE :term')
        ->setParameter('term', '%' . $term . '%');
    }
    return $queryBuilder
      ->orderBy('c.createdAt', 'DESC')
      ->getQuery()
      ->getResult();
  }
}
