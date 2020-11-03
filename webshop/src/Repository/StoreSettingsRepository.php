<?php

namespace App\Repository;

use App\Entity\StoreSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StoreSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoreSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoreSettings[]    findAll()
 * @method StoreSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoreSettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoreSettings::class);
    }

    public function getStoreName($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s.storeName
                FROM App:StoreSettings s
                WHERE s.id = :id'
            )
            ->setParameter('id', $id)
            ->getSingleScalarResult();
    }

    public function getNewProductDate($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s.newProductsDate
                FROM App:StoreSettings s
                WHERE s.id = :id'
            )
            ->setParameter('id', $id)
            ->getSingleScalarResult();
    }


}
