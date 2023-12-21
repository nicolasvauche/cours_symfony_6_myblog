<?php

namespace App\Repository\Blog;

use App\Entity\Blog\Featured;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Featured>
 *
 * @method Featured|null find($id, $lockMode = null, $lockVersion = null)
 * @method Featured|null findOneBy(array $criteria, array $orderBy = null)
 * @method Featured[]    findAll()
 * @method Featured[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeaturedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Featured::class);
    }

//    /**
//     * @return Featured[] Returns an array of Featured objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Featured
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
