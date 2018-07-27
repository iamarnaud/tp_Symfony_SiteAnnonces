<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getSearchByKeywordsAndLocalisationAndCategory(Search $search, EntityManagerInterface $em)
    {
        return $em
            ->getRepository(Product::class)->createQueryBuilder('p')

            ->andWhere('p.title LIKE :name OR p.description LIKE :name')
            ->setParameter('name', '%' . $search->getSearch() . '%')

            ->andwhere('p.category LIKE :category')
            ->setParameter('category', '%' . $search->getSearchbycategory() . '%')

            ->andWhere('p.area LIKE :localisation')
            ->setParameter('localisation', '%' . $search->getSearchbyarea() . '%')

            ->getQuery()
            ->execute();
    }
}
