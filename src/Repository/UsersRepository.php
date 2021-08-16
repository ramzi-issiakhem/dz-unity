<?php

namespace App\Repository;

use App\Entity\Users;
use App\Entity\UsersSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    // /**
    //  * @return Users[] Returns an array of Users objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllByState(UsersSearch $search) : ?array {

        $query = $this->createQueryBuilder('u');

        $query->andWhere('u.state = 1');

            if ($search->getBesoins()) {
                if ($search->getBesoins() != "Tous") {

                    $besoin = $search->getBesoins();
                    $besoin = '"' . $besoin .'"';
                    $query->andWhere('JSON_CONTAINS (u.besoins, :besoin) = 1')
                        ->setParameter('besoin', $besoin );
                }}

            if ($search->getWilaya()) {

                if ($search->getWilaya() != "Tous") {
                    $query->andWhere("u.wilaya = :wilaya")
                        ->setParameter('wilaya', $search->getWilaya());
                }
            }

             return $query->getQuery()->getResult();
    }

    public function findAllOrdered(): ?array
    {
        return $this->createQueryBuilder('u')

            ->orderBy('u.name','ASC')
            ->getQuery()->getResult()
            ;
    }


}
