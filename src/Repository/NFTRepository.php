<?php

namespace App\Repository;

use App\Entity\NFT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NFT>
 *
 * @method NFT|null find($id, $lockMode = null, $lockVersion = null)
 * @method NFT|null findOneBy(array $criteria, array $orderBy = null)
 * @method NFT[]    findAll()
 * @method NFT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NFTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NFT::class);
    }

    public function searchEngine($filters){

        $query =
            $this->createQueryBuilder('n')
                ->leftJoin("n.category", "category")
                ->leftJoin("n.useradd", "user");

        if(!is_null($filters["searchBar"])){
// pour avoir les résultats correspondant au nom du nft concerné
            $query->andWhere("n.nom LIKE :search")
                ->orWhere("user.firstname = :prenom")
                ->orWhere("user.lastname = :nom")
// pour avoir les résultats correspondant au prénom ou nom concerné
                ->setParameter(":nom", $filters["searchBar"])
                ->setParameter(":prenom", $filters["searchBar"])
                ->setParameter(":search", "%".$filters["searchBar"]."%");
        }

        if(!is_null($filters["userAjout"])){
            $query->andWhere("user = :user")
                ->setParameter(":user", $filters["userAjout"]);
        }

        if(!is_null($filters["category"])){

            $query->andWhere("n.category = :category")
                ->setParameter(":category", $filters["category"]->getId());
        }

        if(!is_null($filters["categoryChild"])){

            $query->andWhere("category = :categoryChild")
                ->setParameter(":categoryChild", $filters["categoryChild"]->getId());
        }



        if(!is_null($filters["valueMin"])){
            $query->andWhere("n.valeur > :valueMin")
                ->setParameter(":valueMin", $filters["valueMin"]);
        }

        if(!is_null($filters["valueMax"])){
            $query->andWhere("n.valeur < :valueMax")
                ->setParameter(":valueMax", $filters["valueMax"]);
        }


        return  $query->getQuery()
            ->getResult();
    }

//    /**
//     * @return NFT[] Returns an array of NFT objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NFT
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    }
