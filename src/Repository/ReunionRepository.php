<?php

namespace App\Repository;

use App\Entity\Caso;
use App\Entity\CasoTipo;
use App\Entity\Celda;
use App\Entity\Panal;
use App\Entity\Reunion;
use App\Entity\ReunionDetalle;
use App\Entity\Usuario;
use App\Entity\Votacion;
use App\Utilidades\Firebase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReunionRepository  extends ServiceEntityRepository
{
    private $firebase;

    public function __construct(ManagerRegistry $registry, Firebase $firebase)
    {
        parent::__construct($registry, Reunion::class);
        $this->firebase = $firebase;
    }

    public function apiAdminLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Reunion::class, 'r')
            ->select('r.codigoReunionPk')
            ->addSelect('r.fecha')
            ->addSelect('r.nombre')
            ->addSelect('r.cantidad')
            ->addSelect('r.cantidadCoeficiente')
            ->addSelect('r.estadoCerrado')
            ->where("r.codigoPanalFk = {$codigoPanal}")
            ->orderBy('r.fecha', 'DESC');
        $arReuniones = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'reuniones' => $arReuniones
        ];

    }

    public function apiAdminNuevo($codigoPanal, $id, $nombre)
    {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if($arPanal) {
            if($id) {
                $arReunion = $em->getRepository(Reunion::class)->find($id);
                if($arReunion) {
                    $arReunion->setNombre($nombre);
                    $em->persist($arReunion);
                    $em->flush();
                    return [
                        'error' => false,
                        'codigoReunion' => $arReunion->getCodigoReunionPk()
                    ];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "el id de reunion no existe"
                    ];
                }
            } else {
                $arReunion = new Reunion();
                $arReunion->setPanalRel($arPanal);
                $arReunion->setFecha(new \DateTime('now'));
                $arReunion->setNombre($nombre);
                $em->persist($arReunion);
                $em->flush();
                return [
                    'error' => false,
                    'codigoReunion' => $arReunion->getCodigoReunionPk()
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el panal"
            ];
        }
    }

    public function apiAdminDetalle($codigoReunion)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Reunion::class, 'r')
            ->select('r.codigoReunionPk')
            ->addSelect('r.fecha')
            ->addSelect('r.nombre')
            ->addSelect('r.cantidad')
            ->addSelect('r.cantidadCoeficiente')
            ->addSelect('r.estadoCerrado')
            ->addSelect('p.coeficiente as panalCoeficiente')
            ->addSelect('p.area as panalArea')
            ->addSelect('p.cantidad as panalCantidad')
            ->leftJoin('r.panalRel', 'p')
            ->where("r.codigoReunionPk = {$codigoReunion}");
        $arReunion = $queryBuilder->getQuery()->getResult();
        if($arReunion) {
            $queryBuilder = $em->createQueryBuilder()->from(ReunionDetalle::class, 'rd')
                ->select('rd.codigoReunionDetallePk')
                ->addSelect('rd.codigoCeldaFk')
                ->addSelect('rd.apoderado')
                ->addSelect('c.celda')
                ->addSelect('c.responsable as celdaResponsable')
                ->leftJoin('rd.celdaRel', 'c')
                ->where("rd.codigoReunionFk = {$codigoReunion}");
            $arReunionDetalles = $queryBuilder->getQuery()->getResult();
            return [
                'error' => false,
                'reunion' => $arReunion[0],
                'reunionDetalles' => $arReunionDetalles
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'No existe la reunion'
            ];
        }
    }

    public function apiAdminDetalleNuevo($id, $celda, $apoderado)
    {
        $em = $this->getEntityManager();
        $arReunion = $em->getRepository(Reunion::class)->find($id);
        if($arReunion) {
            if($arReunion->isEstadoCerrado() == 0) {
                $arCelda = $em->getRepository(Celda::class)->findOneBy(['codigoPanalFk' => $arReunion->getCodigoPanalFk(), 'celda' => $celda]);
                if($arCelda) {
                    $arReunionDetalleValidar = $em->getRepository(ReunionDetalle::class)->findOneBy(['codigoReunionFk' => $id, 'codigoCeldaFk' => $arCelda->getCodigoCeldaPk()]);
                    if(!$arReunionDetalleValidar) {
                        $arReunionDetalle = new ReunionDetalle();
                        $arReunionDetalle->setCeldaRel($arCelda);
                        $arReunionDetalle->setReunionRel($arReunion);
                        $arReunionDetalle->setApoderado($apoderado);
                        $em->persist($arReunionDetalle);
                        $arReunion->setCantidad($arReunion->getCantidad() + 1);
                        $arReunion->setCantidadCoeficiente($arReunion->getCantidadCoeficiente() + $arCelda->getCoeficiente());
                        $em->persist($arReunion);
                        $em->flush();
                        return [
                            'error' => false,
                            'codigoReunionDetalle' => $arReunionDetalle->getCodigoReunionDetallePk()
                        ];
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "La celda ya esta registrada"
                        ];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "No existe la celda"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "La reunion ya esta cerrada"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la reunion"
            ];
        }
    }

    public function apiAdminDetalleEliminar($id)
    {
        $em = $this->getEntityManager();
        $arReunionDetalle = $em->getRepository(ReunionDetalle::class)->find($id);
        if($arReunionDetalle) {
            $arReunion = $em->getRepository(Reunion::class)->find($arReunionDetalle->getCodigoReunionFk());
            $arReunion->setCantidad($arReunion->getCantidad() - 1);
            $arReunion->setCantidadCoeficiente($arReunion->getCantidadCoeficiente() - $arReunionDetalle->getCeldaRel()->getCoeficiente());
            $em->persist($arReunion);
            $em->remove($arReunionDetalle);
            $em->flush();
            return [
                'error' => false
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la reunino detalle"
            ];
        }
    }

    public function apiAdminCerrar($id)
    {
        $em = $this->getEntityManager();
        $arReunion = $em->getRepository(Reunion::class)->find($id);
        if($arReunion) {
            if($arReunion->isEstadoCerrado() == 0) {
                $arReunion->setEstadoCerrado(1);
                $em->persist($arReunion);
                $em->flush();
                return [
                    'error' => false
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "La reunion no puede estar cerrada"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la reunion"
            ];
        }
    }

    public function apiAdminListaCombo($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Reunion::class, 'r')
            ->select('r.codigoReunionPk')
            ->addSelect('r.nombre')
            ->where("r.codigoPanalFk = {$codigoPanal}")
            ->andWhere("r.estadoCerrado = 0")
            ->orderBy('r.fecha', 'DESC');
        $arReuniones = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'reuniones' => $arReuniones
        ];

    }
}