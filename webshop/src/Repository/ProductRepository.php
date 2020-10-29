<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function countAllProducts()
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder->select('COUNT(a.id) as value');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function getDiscountedProducts()
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.onDiscount = TRUE')
            ->andWhere('p.product_active = TRUE');

        $query = $queryBuilder->getQuery();
        return $query->execute();
    }

    public function searchProductsByName($str)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                FROM App:Product e
                WHERE e.name LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();

    }
}
