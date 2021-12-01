<?php


namespace App\Repository;

use App\Entity\Efecto;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EfectoRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Efecto::class);
        $this->space = $space;
    }

    public function apiBuscar($nombre)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Efecto::class, 'e')
            ->select('e.codigoEfectoPk')
            ->addSelect('e.nombre')
            ->orderBy('e.orden', 'ASC')
            ->setMaxResults(10);
        if($nombre) {
            $queryBuilder->andWhere("e.nombre like '%{$nombre}%'");
        }
        $arEfectos = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'efectos' => $arEfectos
        ];
    }
}