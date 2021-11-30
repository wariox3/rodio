<?php


namespace App\Repository;

use App\Entity\AnotacionTipo;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AnotacionTipoRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, AnotacionTipo::class);
        $this->space = $space;
    }

    public function apiBuscar($nombre)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(AnotacionTipo::class, 'at')
            ->select('at.codigoAnotacionTipoPk')
            ->addSelect('at.nombre')
            ->setMaxResults(10);
        if($nombre) {
            $queryBuilder->andWhere("at.nombre like '%{$nombre}%'");
        }
        $arAnotacionesTipos = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'anotacionesTipos' => $arAnotacionesTipos
        ];
    }
}