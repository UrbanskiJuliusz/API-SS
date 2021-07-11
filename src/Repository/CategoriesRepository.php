<?php

namespace App\Repository;

use App\Entity\Categories;
use App\Entity\Entries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories[]    findAll()
 * @method Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends ServiceEntityRepository
{
    public $manager;
    private $logger;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, LoggerInterface $logger)
    {
        parent::__construct($registry, Categories::class);
        $this->manager = $manager;
        $this->logger = $logger;
    }

    public function transform(Categories $categories)
    {
        return [
            'id' => (int) $categories->getId(),
            'name' => (string) $categories->getName(),
            'orderView' => (int) $categories->getOrderView()
        ];
    }

    public function getAll()
    {
        $categories = $this->findAll();
        $categoriesArray = [];

        foreach ($categories as $category){
            $categoriesArray[] = $this->transform($category);
        }

        return $categoriesArray;
    }

    public function addNew($categoryName, $orderView)
    {
        $newCategory = new Categories();

        $newCategory->setName($categoryName);
        $newCategory->setOrderView($orderView);

        $this->manager->persist($newCategory);
        $this->manager->flush();
    }

    public function update(Categories $category)
    {
        $this->manager->persist($category);
        $this->manager->flush();
    }

    public function remove(Categories $categories)
    {
        $this->manager->remove($categories);
        $this->manager->flush();
    }

    // /**
    //  * @return Categories[] Returns an array of Categories objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Categories
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
