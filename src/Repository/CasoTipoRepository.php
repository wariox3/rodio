<?php


namespace App\Repository;

use App\Entity\CasoTipo;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CasoTipoRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, CasoTipo::class);
        $this->space = $space;
    }

    public function apiBuscar($nombre)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(CasoTipo::class, 'ct')
            ->select('ct.codigoCasoTipoPk')
            ->addSelect('ct.nombre')
            ->setMaxResults(10);
        if($nombre) {
            $queryBuilder->andWhere("ct.nombre like '%{$nombre}%'");
        }
        $arCasosTipos = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'casosTipos' => $arCasosTipos
        ];
    }
}