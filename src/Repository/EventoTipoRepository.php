<?php


namespace App\Repository;

use App\Entity\AnotacionTipo;
use App\Entity\EventoTipo;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventoTipoRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, EventoTipo::class);
        $this->space = $space;
    }

    public function apiBuscar($nombre)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(EventoTipo::class, 'et')
            ->select('et.codigoEventoTipoPk')
            ->addSelect('et.nombre')
            ->setMaxResults(10);
        if($nombre) {
            $queryBuilder->andWhere("et.nombre like '%{$nombre}%'");
        }
        $arEventosTipos = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'eventosTipos' => $arEventosTipos
        ];
    }
}