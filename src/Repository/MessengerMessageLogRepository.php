<?php

namespace App\Repository;

use App\Entity\MessengerMessageLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MessengerMessageLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessengerMessageLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessengerMessageLog[]    findAll()
 * @method MessengerMessageLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessengerMessageLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessengerMessageLog::class);
    }

    // /**
    //  * @return MessengerMessageLog[] Returns an array of MessengerMessageLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessengerMessageLog
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
