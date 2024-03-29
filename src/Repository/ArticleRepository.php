<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Article::class);
	}

	/**
	 * @return Article[] Returns an array of Article objects
	 * @throws QueryException
	 */
	public function findAllPublishedOrderedByNewest()
	{
		$this->createQueryBuilder('a')
			->addCriteria(CommentRepository::createNonDeletedCriteria());

		return $this->addIsPublishedQueryBuilder()
			->leftJoin('a.tags', 't')
			->addSelect('t')
			->orderBy('a.publishedAt', 'DESC')
			->getQuery()
			->getResult();
	}

	/**
	 * @param QueryBuilder|null $queryBuilder
	 * @return QueryBuilder
	 */
	private function addIsPublishedQueryBuilder(QueryBuilder $queryBuilder = null)
	{
		return $this->getOrCreateQueryBuilder($queryBuilder)
			->andWhere('a.publishedAt is not null');
	}

	/**
	 * @param QueryBuilder|null $queryBuilder
	 * @return QueryBuilder
	 */
	private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null)
	{
		return $queryBuilder ?: $this->createQueryBuilder('a');
	}


	/*
	public function findOneBySomeField($value): ?Article
	{
			return $this->createQueryBuilder('a')
					->andWhere('a.exampleField = :val')
					->setParameter('val', $value)
					->getQuery()
					->getOneOrNullResult()
			;
	}
	*/
}
