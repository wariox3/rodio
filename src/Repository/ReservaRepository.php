<?php


namespace App\Repository;

use App\Entity\Panal;
use App\Entity\Reserva;
use App\Entity\ReservaDetalle;
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

    public function apiLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Reserva::class, 'r')
            ->select('r.codigoReservaPk')
            ->addSelect('r.nombre')
            ->addSelect('r.descripcion')
            ->where("r.codigoPanalFk = {$codigoPanal}")
            ->setMaxResults(20);
        $arReservas = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'reservas' => $arReservas
        ];
        return $respuesta;
    }

    public function apiAdminLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Reserva::class, 'r')
            ->select('r.codigoReservaPk')
            ->addSelect('r.nombre')
            ->addSelect('r.descripcion')
            ->where("r.codigoPanalFk = {$codigoPanal}")
            ->setMaxResults(20);
        $arReservas = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'reservas' => $arReservas
        ];
        return $respuesta;
    }

    public function apiAdminNuevo($codigoPanal, $id, $nombre, $descripcion)
    {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if($arPanal) {
            if($id) {
                $arReserva = $em->getRepository(Reserva::class)->find($id);
                if($arReserva) {
                    $arReserva->setNombre($nombre);
                    $arReserva->setDescripcion($descripcion);
                    $em->persist($arReserva);
                    $em->flush();
                    return [
                        'error' => false,
                        'codigoReserva' => $arReserva->getCodigoReservaPk()
                    ];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "El id de reserva no existe"
                    ];
                }
            } else {
                $arReserva = new Reserva();
                $arReserva->setPanalRel($arPanal);
                $arReserva->setNombre($nombre);
                $arReserva->setDescripcion($descripcion);
                $em->persist($arReserva);
                $em->flush();
                return [
                    'error' => false,
                    'codigoReserva' => $arReserva->getCodigoReservaPk()
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el panal"
            ];
        }
    }

    public function apiAdminDetalle($codigoReserva)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Reserva::class, 'r')
            ->select('r.codigoReservaPk')
            ->addSelect('r.nombre')
            ->addSelect('r.descripcion')
            ->where("r.codigoReservaPk = {$codigoReserva}");
        $arReserva = $queryBuilder->getQuery()->getResult();
        if($arReserva) {
            $queryBuilder = $em->createQueryBuilder()->from(ReservaDetalle::class, 'rd')
                ->select('rd.codigoReservaDetallePk')
                ->addSelect('rd.codigoCeldaFk')
                ->addSelect('rd.fecha')
                ->addSelect('rd.comentario')
                ->addSelect('c.celda')
                ->leftJoin('rd.celdaRel', 'c')
                ->where("rd.codigoReservaFk = {$codigoReserva}");
            $arReservaDetalles = $queryBuilder->getQuery()->getResult();
            return [
                'error' => false,
                'reserva' => $arReserva[0],
                'reservaDetalles' => $arReservaDetalles
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'No existe la reserva'
            ];
        }
    }
}