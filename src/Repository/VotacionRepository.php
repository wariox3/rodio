<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\Panal;
use App\Entity\Usuario;
use App\Entity\Votacion;
use App\Entity\VotacionCelda;
use App\Entity\VotacionDetalle;
use App\Utilidades\Firebase;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VotacionRepository extends ServiceEntityRepository
{
    private $firebase;
    private $space;

    public function __construct(ManagerRegistry $registry, Firebase $firebase, SpaceDO $space)
    {
        parent::__construct($registry, Votacion::class);
        $this->firebase = $firebase;
        $this->space = $space;
    }

    public function apiLista($codigoCelda)
    {
        $em = $this->getEntityManager();
        $arCelda = $em->getRepository(Celda::class)->find($codigoCelda);
        if ($arCelda) {
            $queryBuilder = $em->createQueryBuilder()->from(Votacion::class, 'v')
                ->select('v.codigoVotacionPk')
                ->addSelect('v.fecha')
                ->addSelect('v.fechaHasta')
                ->addSelect('v.descripcion')
                ->addSelect('v.cantidad')
                ->addSelect('v.estadoCerrado')
                ->where("v.codigoPanalFk = {$arCelda->getCodigoPanalFk()}")
                ->orderBy('v.fecha', 'DESC');
            $arVotaciones = $queryBuilder->getQuery()->getResult();
            $indice = 0;
            foreach ($arVotaciones as $arVotacion) {
                //Saber si ya voto
                $voto = false;
                $codigoVotacionDetalle = null;
                $queryBuilder = $em->createQueryBuilder()->from(VotacionCelda::class, 'vc')
                    ->select('vc.codigoVotacionCeldaPk')
                    ->addSelect('vc.codigoVotacionDetalleFk')
                    ->where("vc.codigoVotacionFk = {$arVotacion['codigoVotacionPk']}")
                    ->andWhere("vc.codigoCeldaFk = {$codigoCelda}");
                $arVotacionCelda = $queryBuilder->getQuery()->getResult();
                if($arVotacionCelda) {
                    $voto = true;
                    $codigoVotacionDetalle = $arVotacionCelda[0]['codigoVotacionDetalleFk'];

                }
                $arVotaciones[$indice]['voto'] = $voto;
                $arVotaciones[$indice]['codigoVotacionDetalle'] = $codigoVotacionDetalle;
                $queryBuilder = $em->createQueryBuilder()->from(VotacionDetalle::class, 'vd')
                    ->select('vd.codigoVotacionDetallePk')
                    ->addSelect('vd.descripcion')
                    ->where("vd.codigoVotacionFk = {$arVotacion['codigoVotacionPk']}");
                $arVotacionesDetalles = $queryBuilder->getQuery()->getResult();
                $arVotaciones[$indice]['detalles'] = $arVotacionesDetalles;
                $indice++;
            }
            return [
                'error' => false,
                'votaciones' => $arVotaciones
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "La celda no existe"
            ];
        }
    }

    public function apiVotar($codigoVotacion, $codigoCelda, $codigoUsuario, $codigoVotacionDetalle)
    {
        $em = $this->getEntityManager();
        $arVotacion = $em->getRepository(Votacion::class)->find($codigoVotacion);
        if($arVotacion) {
            $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
            if($arUsuario) {
                $arCelda = $em->getRepository(Celda::class)->find($codigoCelda);
                if ($arCelda) {
                    $queryBuilder = $em->createQueryBuilder()->from(VotacionCelda::class, 'vc')
                        ->select('vc.codigoVotacionCeldaPk')
                        ->addSelect('vc.codigoVotacionDetalleFk')
                        ->where("vc.codigoVotacionFk = {$codigoVotacion}")
                        ->andWhere("vc.codigoCeldaFk = {$codigoCelda}");
                    $arVotacionesCelda = $queryBuilder->getQuery()->getResult();
                    if(!$arVotacionesCelda) {
                        $arVotacionCelda = new VotacionCelda();
                        $arVotacionCelda->setCeldaRel($arCelda);
                        $arVotacionCelda->setVotacionRel($arVotacion);
                        $arVotacionCelda->setUsuarioRel($arUsuario);
                        $arVotacionCelda->setCodigoVotacionDetalleFk($codigoVotacionDetalle);
                        $em->persist($arVotacionCelda);
                        $em->flush();
                        return [
                            'error' => false
                        ];
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "La celda ya voto"
                        ];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "La celda no existe"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "El usuario no existe"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "La votacion no existe"
            ];
        }
    }

    public function apiAdminLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Votacion::class, 'v')
            ->select('v.codigoVotacionPk')
            ->addSelect('v.fecha')
            ->addSelect('v.fechaHasta')
            ->addSelect('v.descripcion')
            ->addSelect('v.cantidad')
            ->addSelect('v.estadoCerrado')
            ->where("v.codigoPanalFk = {$codigoPanal}")
            ->orderBy('v.fecha', 'DESC');
        $arVotaciones = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'votaciones' => $arVotaciones
        ];

    }

    public function apiAdminNuevo($codigoPanal, $id, $fechaHasta, $descripcion)
    {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if($arPanal) {
            if($id) {
                $arVotacion = $em->getRepository(Votacion::class)->find($id);
                if($arVotacion) {
                    $arVotacion->setFechaHasta(date_create($fechaHasta));
                    $arVotacion->setDescripcion($descripcion);
                    $em->persist($arVotacion);
                    $em->flush();
                    return [
                        'error' => false,
                        'codigoVotacion' => $arVotacion->getCodigoVotacionPk()
                    ];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "el id de votacion no existe"
                    ];
                }
            } else {
                $arVotacion = new Votacion();
                $arVotacion->setPanalRel($arPanal);
                $arVotacion->setFecha(new \DateTime('now'));
                $arVotacion->setFechaHasta(date_create($fechaHasta));
                $arVotacion->setDescripcion($descripcion);
                $em->persist($arVotacion);
                $em->flush();
                return [
                    'error' => false,
                    'codigoVotacion' => $arVotacion->getCodigoVotacionPk()
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el panal"
            ];
        }
    }

    public function apiAdminDetalle($codigoVotacion)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Votacion::class, 'v')
            ->select('v.codigoVotacionPk')
            ->addSelect('v.fecha')
            ->addSelect('v.fechaHasta')
            ->addSelect('v.descripcion')
            ->addSelect('v.cantidad')
            ->where("v.codigoVotacionPk = {$codigoVotacion}");
        $arVotacion = $queryBuilder->getQuery()->getResult();
        if($arVotacion) {
            $queryBuilder = $em->createQueryBuilder()->from(VotacionDetalle::class, 'vd')
                ->select('vd.codigoVotacionDetallePk')
                ->addSelect('vd.descripcion')
                ->where("vd.codigoVotacionFk = {$codigoVotacion}");
            $arVotacionDetalles = $queryBuilder->getQuery()->getResult();
            return [
                'error' => false,
                'votacion' => $arVotacion[0],
                'votacionDetalles' => $arVotacionDetalles
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'No existe la votacion'
            ];
        }
    }

    public function apiAdminDetalleNuevo($id, $descripcion)
    {
        $em = $this->getEntityManager();
        $arVotacion = $em->getRepository(Votacion::class)->find($id);
        if($arVotacion) {
            $arVotacionDetalle = new VotacionDetalle();
            $arVotacionDetalle->setVotacionRel($arVotacion);
            $arVotacionDetalle->setDescripcion($descripcion);
            $em->persist($arVotacionDetalle);
            $em->flush();
            return [
                'error' => false,
                'codigoVotacionDetalle' => $arVotacionDetalle->getCodigoVotacionDetallePk()
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la votacion"
            ];
        }
    }

    public function apiAdminDetalleEliminar($id)
    {
        $em = $this->getEntityManager();
        $arVotacionDetalle = $em->getRepository(VotacionDetalle::class)->find($id);
        if($arVotacionDetalle) {
            $em->remove($arVotacionDetalle);
            $em->flush();
            return [
                'error' => false
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la votacion detalle"
            ];
        }
    }
}