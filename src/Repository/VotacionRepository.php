<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\CeldaUsuario;
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
                ->addSelect('v.titulo')
                ->addSelect('v.descripcion')
                ->addSelect('v.cantidad')
                ->addSelect('v.estadoCerrado')
                ->where("v.codigoPanalFk = {$arCelda->getCodigoPanalFk()}")
                ->andWhere("v.estadoPublicado = 1")
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
            $arUsuario = null;
            if($codigoUsuario) {
                $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
            }
            $arCelda = $em->getRepository(Celda::class)->find($codigoCelda);
            if ($arCelda) {
                $arVotacionDetalle = $em->getRepository(VotacionDetalle::class)->find($codigoVotacionDetalle);
                if($arVotacionDetalle) {
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
                        $arVotacionCelda->setVotacionDetalleRel($arVotacionDetalle);
                        $em->persist($arVotacionCelda);
                        $em->flush();
                        $em->createQueryBuilder()->update(Votacion::class, 'v')->set('v.cantidad', 'v.cantidad+1')->getQuery()->execute();
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
                        'errorMensaje' => "La opcion no existe"
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
            ->addSelect('v.titulo')
            ->addSelect('v.descripcion')
            ->addSelect('v.cantidad')
            ->addSelect('v.estadoCerrado')
            ->addSelect('v.estadoPublicado')
            ->where("v.codigoPanalFk = {$codigoPanal}")
            ->orderBy('v.fecha', 'DESC');
        $arVotaciones = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'votaciones' => $arVotaciones
        ];

    }

    public function apiAdminNuevo($codigoPanal, $id, $fechaHasta, $titulo, $descripcion)
    {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if($arPanal) {
            if($id) {
                $arVotacion = $em->getRepository(Votacion::class)->find($id);
                if($arVotacion) {
                    $arVotacion->setFechaHasta(date_create($fechaHasta));
                    $arVotacion->setDescripcion($descripcion);
                    $arVotacion->setTitulo($titulo);
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
                $arVotacion->setTitulo($titulo);
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
            ->addSelect('v.titulo')
            ->addSelect('v.cantidad')
            ->addSelect('v.estadoPublicado')
            ->where("v.codigoVotacionPk = {$codigoVotacion}");
        $arVotacion = $queryBuilder->getQuery()->getResult();
        if($arVotacion) {
            $queryBuilder = $em->createQueryBuilder()->from(VotacionDetalle::class, 'vd')
                ->select('vd.codigoVotacionDetallePk')
                ->addSelect('vd.descripcion')
                ->where("vd.codigoVotacionFk = {$codigoVotacion}");
            $arVotacionDetalles = $queryBuilder->getQuery()->getResult();
            $queryBuilder = $em->createQueryBuilder()->from(VotacionCelda::class, 'vc')
                ->select('vc.codigoVotacionCeldaPk')
                ->addSelect('c.celda')
                ->addSelect('vd.descripcion as votacionDetalleDescripcion')
                ->leftJoin('vc.celdaRel', 'c')
                ->leftJoin('vc.votacionDetalleRel', 'vd')
                ->where("vc.codigoVotacionFk = {$codigoVotacion}");
            $arVotacionCeldas = $queryBuilder->getQuery()->getResult();
            $queryBuilder = $em->createQueryBuilder()->from(VotacionCelda::class, 'vc')
                ->select('COUNT(vc.codigoVotacionCeldaPk) as cantidad')
                ->addSelect('vd.descripcion as votacionDetalleDescripcion')
                ->leftJoin('vc.votacionDetalleRel', 'vd')
                ->where("vc.codigoVotacionFk = {$codigoVotacion}")
                ->groupBy('vc.codigoVotacionDetalleFk');
            $arVotacionResumen = $queryBuilder->getQuery()->getResult();
            return [
                'error' => false,
                'votacion' => $arVotacion[0],
                'votacionDetalles' => $arVotacionDetalles,
                'votacionCeldas' => $arVotacionCeldas,
                'votacionResumen' => $arVotacionResumen
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

    public function apiAdminPublicar($id)
    {
        $em = $this->getEntityManager();
        $arVotacion = $em->getRepository(Votacion::class)->find($id);
        if($arVotacion) {
            if($arVotacion->isEstadoPublicado() == 0) {
                $arVotacionDetalles = $em->getRepository(VotacionDetalle::class)->findBy(['codigoVotacionFk' => $id]);
                if($arVotacionDetalles) {
                    if(count($arVotacionDetalles) >= 2) {
                        $arVotacion->setEstadoPublicado(1);
                        $em->persist($arVotacion);
                        $em->flush();

                        $queryBuilder = $em->createQueryBuilder()->from(CeldaUsuario::class, 'cu')
                            ->select('cu.codigoCeldaUaurioPk')
                            ->addSelect('u.tokenFirebase')
                            ->leftJoin('cu.celdaRel', 'c')
                            ->leftJoin('cu.usuarioRel', 'u')
                            ->where("c.codigoPanalFk = {$arVotacion->getCodigoPanalFk()}");
                        $arUsuarios = $queryBuilder->getQuery()->getResult();
                        foreach ($arUsuarios as $arUsuario) {
                            $this->firebase->publicarVotacion($arUsuario['tokenFirebase']);
                        }
                        return [
                            'error' => false
                        ];
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "La votacion debe tener mas de 1 opcion"
                        ];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "La votacion no tiene opciones"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "La votacion ya fue publicada"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la votacion"
            ];
        }
    }
}