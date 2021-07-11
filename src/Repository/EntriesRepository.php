<?php

namespace App\Repository;

use App\Entity\Entries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Entries|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entries|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entries[]    findAll()
 * @method Entries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntriesRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Entries::class);
        $this->manager = $manager;
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

    public function addNew($category, $companyName, $www, $address, $content, $created)
    {
        $newEntry = new Entries();

        $newEntry->setCategory($category);
        $newEntry->setCompanyName($companyName);
        $newEntry->setWww($www);
        $newEntry->setAddress($address);
        $newEntry->setContent($content);
        $newEntry->setCreated(\DateTime::createFromFormat('Y-m-d H:i:s', $created));

        $this->manager->persist($newEntry);
        $this->manager->flush();
    }

    public function update(Entries $entries)
    {
        $this->manager->persist($entries);
        $this->manager->flush();
    }

    public function remove(Entries $entries)
    {
        $this->manager->remove($entries);
        $this->manager->flush();
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
