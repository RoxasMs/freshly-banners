<?php

namespace App\Repository;

use App\Entity\Banner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Banner>
 */
class BannerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Banner::class);
    }

    /**
     * @return Banner[]
     */
    public function findVisibleForLocale(string $locale, \DateTimeInterface $today): array
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.bannerContents', 'bc', 'WITH', 'bc.active_lang = :activeLang')
            ->innerJoin('bc.language', 'l', 'WITH', 'l.locale = :locale')
            ->leftJoin('b.background_color', 'c')
            ->addSelect('bc', 'l', 'c')
            ->andWhere('b.active = :active')
            ->andWhere('b.start_date <= :today')
            ->andWhere('b.end_date >= :today')
            ->setParameter('active', true)
            ->setParameter('activeLang', true)
            ->setParameter('locale', $locale)
            ->setParameter('today', $today->format('Y-m-d'))
            ->orderBy('b.start_date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Banner[] Returns an array of Banner objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Banner
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
