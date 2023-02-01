<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Quote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quote>
 *
 * @method Quote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quote[]    findAll()
 * @method Quote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quote::class);
    }

    public function save(Quote $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Quote $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Retourne un tableau d'id de citations.
     */
    public function findQuoteId(?Category $category = null): array
    {
        if ($category) {
            return $this->createQueryBuilder('q')
                ->select('q.id')
                ->where('q.category = :category')
                ->setParameter('category', $category)
                ->getQuery()
                ->getResult();
        }

        return $this->createQueryBuilder('q')
            ->select('q.id')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Quote[] Retourne les 5 dernières citations de l'utilisateur
     */
    public function findLastQuotes($user): array
    {
        return $this->createQueryBuilder('q')
            ->where('q.author = :user')
            ->setParameter('user', $user)
            ->orderBy('q.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Quote Retourne une citation aléatoire
     */
    public function findRandomQuote(?Category $category = null): ?Quote
    {
        $qb = $this->createQueryBuilder('q')
            ->select('q.id');

        if ($category) {
            $qb
                ->where('q.category = :category')
                ->setParameter('category', $category);
        }

        $listOfId = $qb
            ->getQuery()
            ->getResult();

        if (empty($listOfId)) {
            return null;
        }

        $flatRes = array_column($listOfId, 'id');
        $id = $listOfId[array_rand($flatRes, 1)];
        $quote = $this->find($id);

        return $quote;
    }
}
