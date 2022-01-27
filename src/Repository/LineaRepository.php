<?php

namespace App\Repository;

use App\Entity\Linea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LineaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Linea::class);
    }

    public function apiLista()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Linea::class, 'l')
            ->select('l.codigoLineaPk')
            ->addSelect('l.nombre');
        $arLineas = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'lineas' => $arLineas
        ];
    }

}