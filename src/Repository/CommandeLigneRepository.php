<?php

namespace App\Repository;

use App\Entity\Utilisateurs;
use App\Entity\CommandeLigne;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method CommandeLigne|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeLigne|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeLigne[]    findAll()
 * @method CommandeLigne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeLigneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeLigne::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CommandeLigne $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(CommandeLigne $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

//       public function mesCommandes()
//       {
//            return $this->createQueryBuilder('l')
//                 ->select('l')
//                 ->join('l.commande', 'c')
//                 ->join('c.utilisateur', 'u')
//                 ->join('l.produits', 'p')
//                 ->where('c.utilisateur = :id')
//                 ->setParameter('id','id')
//                 ->getQuery()
//                 ->getResult();


//    }

    // /**
    //  * @return CommandeLigne[] Returns an array of CommandeLigne objects
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
    public function findOneBySomeField($value): ?CommandeLigne
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
