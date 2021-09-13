<?php


namespace App\Repository;

use App\Entity\Panal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PanalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panal::class);
    }

    public function apiBuscar($nombre, $codigoCiudad)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Panal::class, 'p')
            ->select('p.codigoPanalPk')
            ->addSelect('p.nombre')
            ->setMaxResults(10);
        if($nombre) {
            $queryBuilder->andWhere("p.nombre like '%{$nombre}%'");
        }
        if($codigoCiudad) {
            $queryBuilder->andWhere("p.codigoCiudadFk =  {$codigoCiudad}");
        }
        $arPanales = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'panales' => $arPanales
        ];
    }
}