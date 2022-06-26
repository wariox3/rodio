<?php


namespace App\Repository;

use App\Entity\Ubicacion;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UbicacionRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Ubicacion::class);
        $this->space = $space;
    }


}