<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\Reserva;
use App\Entity\ReservaDetalle;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservaDetalleRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, ReservaDetalle::class);
        $this->space = $space;
    }

    public function apiLista($codigoCelda)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(ReservaDetalle::class, 'rd')
            ->select('rd.codigoReservaDetallePk')
            ->addSelect('rd.codigoReservaFk')
            ->addSelect('rd.fecha')
            ->addSelect('rd.comentario')
            ->addSelect('r.nombre as reservaNombre')
            ->addSelect('r.descripcion as reservaDescripcion')
            ->leftJoin('rd.reservaRel', 'r')
            ->where("rd.codigoCeldaFk = {$codigoCelda}")
            ->orderBy('rd.fecha', 'DESC');
        $arReservaDetalles = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'reservaDetalles' => $arReservaDetalles
        ];
        return $respuesta;
    }

    public function apiNuevo($codigoCelda, $codigoReserva, $fecha, $comentario)
    {
        $em = $this->getEntityManager();
        $arCelda = $em->getRepository(Celda::class)->find($codigoCelda);
        if($arCelda) {
            $arReserva = $em->getRepository(Reserva::class)->find($codigoReserva);
            if($arReserva) {
                $queryBuilder = $em->createQueryBuilder()->from(ReservaDetalle::class, 'rd')
                    ->select('rd.codigoReservaDetallePk')
                    ->where("rd.codigoReservaFk = {$codigoReserva}")
                    ->andWhere("rd.fecha >= '{$fecha} 00:00:00'")
                    ->andWhere("rd.fecha <= '{$fecha} 23:59:59'");
                $arReservaDetalles = $queryBuilder->getQuery()->getResult();
                if(!$arReservaDetalles) {
                    $arReservaDetalle = new ReservaDetalle();
                    $arReservaDetalle->setCeldaRel($arCelda);
                    $arReservaDetalle->setReservaRel($arReserva);
                    $arReservaDetalle->setFecha(date_create($fecha));
                    $arReservaDetalle->setComentario($comentario);
                    $em->persist($arReservaDetalle);
                    $em->flush();
                    return [
                        'error' => false,
                        'codigoReservaDetalle' => $arReservaDetalle->getCodigoReservaDetallePk()
                    ];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "Ya hay reservas para esta fecha"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe la reserva"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la celda"
            ];
        }
    }

    public function apiReserva($codigoReserva, $anio, $mes)
    {
        $em = $this->getEntityManager();
        $ultimoDia = date("d", (mktime(0, 0, 0, $mes + 1, 1, $anio) - 1));
        $fechaDesde = "{$anio}-{$mes}-01";
        $fechaHasta = "{$anio}-{$mes}-{$ultimoDia}";
        $queryBuilder = $em->createQueryBuilder()->from(ReservaDetalle::class, 'rd')
            ->select('rd.codigoReservaDetallePk')
            ->addSelect('rd.codigoReservaFk')
            ->addSelect('rd.fecha')
            ->addSelect('rd.comentario')
            ->where("rd.codigoReservaFk = {$codigoReserva}")
            ->andWhere("rd.fecha >= '{$fechaDesde}'")
            ->andWhere("rd.fecha <= '{$fechaHasta}'")
            ->setMaxResults(20);
        $arReservasDetalles = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'reservasDetalles' => $arReservasDetalles
        ];
        return $respuesta;
    }

}