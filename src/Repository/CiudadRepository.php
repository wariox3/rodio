<?php


namespace App\Repository;

use App\Entity\Ciudad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CiudadRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ciudad::class);
    }

    public function apiBuscar($nombre)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Ciudad::class, 'c')
            ->select('c.codigoCiudadPk')
            ->addSelect('c.nombre')
            ->setMaxResults(10);
        if($nombre) {
            $queryBuilder->andWhere("c.nombre like '%{$nombre}%'");
        }
        $arCiudades = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'ciudades' => $arCiudades
        ];
    }
}