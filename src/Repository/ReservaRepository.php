<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\Publicacion;
use App\Entity\Reporte;
use App\Entity\Reserva;
use App\Entity\ReservaItem;
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

    public function apiNuevo($codigoCelda, $codigoItem, $anio, $mes, $dia)
    {
        $em = $this->getEntityManager();
        $fechaDesde = "{$anio}-{$mes}-{$dia}";
        $fechaHasta = "{$anio}-{$mes}-{$dia}";
        $arCelda = $em->getRepository(Celda::class)->find($codigoCelda);
        if($arCelda) {
            $arItem = $em->getRepository(ReservaItem::class)->find($codigoItem);
            if($arItem) {
                $queryBuilder = $em->createQueryBuilder()->from(Reserva::class, 'r')
                    ->select('r.codigoReservaPk')
                    ->where("r.codigoReservaItemFk = {$codigoItem}")
                    ->andWhere("r.fecha >= '{$fechaDesde} 00:00:00'")
                    ->andWhere("r.fecha <= '{$fechaHasta} 23:59:59'");
                $arReservas = $queryBuilder->getQuery()->getResult();
                if(!$arReservas) {
                    $arReserva = new Reserva();
                    $arReserva->setCeldaRel($arCelda);
                    $arReserva->setReservaItemRel($arItem);
                    $arReserva->setFecha(date_create($fechaDesde));
                    $em->persist($arReserva);
                    $em->flush();
                    return [
                        'error' => false,
                        'codigoReserva' => $arReserva->getCodigoReservaPk()
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
                    'errorMensaje' => "No existe el item"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la celda"
            ];
        }
    }

    public function apiReserva($codigoItem, $anio, $mes)
    {
        $em = $this->getEntityManager();
        $ultimoDia = date("d", (mktime(0, 0, 0, $mes + 1, 1, $anio) - 1));
        $fechaDesde = "{$anio}-{$mes}-01";
        $fechaHasta = "{$anio}-{$mes}-{$ultimoDia}";
        $queryBuilder = $em->createQueryBuilder()->from(Reserva::class, 'r')
            ->select('r.codigoReservaPk')
            ->addSelect('r.codigoReservaItemFk')
            ->addSelect('r.fecha')
            ->addSelect('r.comentario')
            ->where("r.codigoReservaItemFk = {$codigoItem}")
            ->andWhere("r.fecha >= '{$fechaDesde}'")
            ->andWhere("r.fecha <= '{$fechaHasta}'")
            ->setMaxResults(20);
        $arReservas = $queryBuilder->getQuery()->getResult();
        $arregloFechas = [];
        foreach ($arReservas as $arReserva) {
            $arregloFechas[] = $arReserva['fecha']->format('Y-m-d');
        }
        $respuesta = [
            'error' => false,
            'reservas' => $arReservas,
            'arregloFechas' => $arregloFechas
        ];
        return $respuesta;
    }

}