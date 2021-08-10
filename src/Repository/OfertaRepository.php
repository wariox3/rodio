<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\Oferta;
use App\Entity\Panal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OfertaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oferta::class);
    }

}