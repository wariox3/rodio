<?php


namespace App\Repository;

use App\Entity\Publicacion;
use App\Entity\Reporte;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservaRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Reserva::class);
        $this->space = $space;
    }

    public function apiLista($codigoCelda)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Reserva::class, 'r')
            ->select('r.codigoReservaPk')
            ->addSelect('r.codigoReservaItemFk')
            ->addSelect('r.fecha')
            ->addSelect('r.comentario')
            ->addSelect('ir.nombre as reservaItemNombre')
            ->leftJoin('r.reservaItemRel', 'ir')
            ->where("r.codigoCeldaFk = {$codigoCelda}")
            ->setMaxResults(20);
        $arReservas = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'reservas' => $arReservas
        ];
        return $respuesta;
    }

}