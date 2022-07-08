<?php

namespace App\Repository;

use Doctrine\DBAL\Query\QueryBuilder;

class Test extends QueryBuilder{

    private $produitRepository;
    public function __construct(ProduitsRepository $produitRepository)
    {
        $this->produitRepository = $produitRepository;

    }
   

    public function findCrampon()
    {
        $nom = "Semelle";
        return $this->produitRepository->createQueryBuilder('p')
            ->select(array('p'))
            ->from('produits', 'p')
            ->where($this->expr()->like('p.nom', ':nom'))
            ->setParameter(':nom', '%' . $nom . '%')
            ->getQuery()
            ->getResult();



}
}