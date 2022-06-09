<?php

namespace App\Repository;

use App\Entity\Conference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @extends ServiceEntityRepository<Conference>
 *
 * @method Conference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conference[]    findAll()
 * @method Conference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conference::class);
    }

    public function add(Conference $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Conference $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Conference[] Returns an array of Conference objects
    */
   public function findByYear($value): array
   {
       return $this->createQueryBuilder('c')
           ->andWhere('c.year = :annee')
           ->setParameter('annee', $value)
           ->orderBy('c.year', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }
    public const PAGINATOR_PER_PAGE = 2;
    public function getConferencePaginator( int $offset, string $city, string $year,  $searchcity): Paginator
    {
        $query = $this->createQueryBuilder('c');
        if ($city){
            $query = $query->andWhere('c.city =:city')
                ->setParameter('city',$city);
        }
        if ($year){
            $query = $query->andWhere('c.year =:year')
                ->setParameter('year',$year);
        }
        if ($searchcity){
            $query =$query->andWhere('c.city LIKE :city')
                ->setParameter('city','%'.$searchcity.'%');
        }
        $query = $query
            ->orderBy('c.year', 'DESC')
            ->addOrderBy('c.city')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();
        return new Paginator($query);
    }

    public function getListYear(): array
    {
        $years = [];
        foreach ($this->createQueryBuilder('c')
        ->select('c.year')
        ->distinct(true)
        ->orderBy('c.year','ASC')
        ->getQuery()
        ->getResult() as $cols) {
            $years[] = $cols['year'];
        }
        return $years;
    }
    public function getListCity(): array
    {
        $city = [];
        foreach ($this->createQueryBuilder('c')
                     ->select('c.city')
                     ->distinct(true)
                     ->orderBy('c.city','ASC')
                     ->getQuery()
                     ->getResult() as $cols) {
            $city[] = $cols['city'];
        }
        return $city;

    }
//    public function findOneBySomeField($value): ?Conference
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
