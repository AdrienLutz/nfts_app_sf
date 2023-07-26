<?php

namespace App\Repository;

use App\Entity\ProprietaireNFT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProprietaireNFT>
 *
 * @method ProprietaireNFT|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProprietaireNFT|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProprietaireNFT[]    findAll()
 * @method ProprietaireNFT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProprietaireNFTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProprietaireNFT::class);
    }

//    /**
//     * @return ProprietaireNFT[] Returns an array of ProprietaireNFT objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProprietaireNFT
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
