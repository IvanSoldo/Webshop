<?php

namespace App\Repository;

use App\Entity\OrderProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderProduct[]    findAll()
 * @method OrderProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderProduct::class);
    }

    public function totalEarned()
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder
            ->innerJoin('App\Entity\Order', 'o', Join::WITH, 'o = p.orders')
            ->select('SUM(p.priceOnOrderSubmit * p.quantity)')
            ->where('o.status = 9')
        ;

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

}
