<?php

namespace App\Repository;

use App\Entity\Entries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entries|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entries|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entries[]    findAll()
 * @method Entries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entries::class);
    }

    public function transform(Entries $entry)
    {
        return [
            'id' => (int) $entry->getId(),
            'category_id' => (int) $entry->getCategory()->getId(),
            'company_name' => (string) $entry->getCompanyName(),
            'www' => (string) $entry->getWww(),
            'address' => (string) $entry->getAddress(),
            'content' => (string) $entry->getContent(),
            'created' => $entry->getCreated()->format('Y-m-d H:i:s')
        ];
    }

    public function getAll()
    {
        $entries = $this->findAll();
        $entriesArray = [];

        foreach ($entries as $entry) {
            $entriesArray[] = $this->transform($entry);
        }

        return $entriesArray;
    }

    // /**
    //  * @return Entries[] Returns an array of Entries objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entries
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
