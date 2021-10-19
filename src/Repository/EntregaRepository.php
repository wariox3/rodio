<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\CeldaUsuario;
use App\Entity\Entrega;
use App\Entity\Panal;
use App\Entity\Usuario;
use App\Utilidades\Firebase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EntregaRepository extends ServiceEntityRepository
{
    private $firebase;

    public function __construct(ManagerRegistry $registry, Firebase $firebase)
    {
        parent::__construct($registry, Entrega::class);
        $this->firebase = $firebase;
    }

    public function apiLista($codigoCelda)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Entrega::class, 'e')
            ->select('e.codigoEntregaPk')
            ->addSelect('e.fechaIngreso')
            ->addSelect('e.descripcion')
            ->addSelect('e.codigoEntregaTipoFk')
            ->addSelect('e.estadoAutorizado')
            ->addSelect('e.estadoCerrado')
            ->addSelect('e.urlImagen')
            ->where("e.codigoCeldaFk = {$codigoCelda}")
            ->orderBy('e.estadoCerrado', 'ASC')
            ->orderBy('e.estadoAutorizado', 'ASC')
            ->setMaxResults(20);
        $arEntregas = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'entregas' => $arEntregas
        ];
        return $respuesta;
    }

    public function apiNuevo($codigoPanal, $celda, $tipo, $entrega)
    {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if($arPanal) {
            $arCelda = $em->getRepository(Celda::class)->findOneBy(['codigoPanalFk' => $codigoPanal, 'celda' => $celda]);
            if($arCelda) {
                $arEntrega = new Entrega();
                $arEntrega->setCeldaRel($arCelda);
                $arEntrega->setFechaIngreso(new \DateTime('now'));
                $arEntrega->setCodigoEntregaTipoFk($tipo);
                $em->persist($arEntrega);
                $em->flush();
                //Usuarios a los que se debe notificar
                $arCeldaUsuarios = $em->getRepository(CeldaUsuario::class)->findBy(['codigoCeldaFk' => $arCelda->getCodigoCeldaPk()]);
                foreach ($arCeldaUsuarios as $arCeldaUsuario) {
                    $this->firebase->nuevaEntrega($arCeldaUsuario->getUsuarioRel()->getTokenFirebase(), $arEntrega->getCodigoEntregaPk(), $tipo, 0);
                }

                return ['error' => false];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe la celda"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el panal"
            ];
        }
    }

    public function apiDetalle($codigoEntrega)
    {
        $em = $this->getEntityManager();
        $arEntrega = $em->getRepository(Entrega::class)->find($codigoEntrega);
        if($arEntrega) {
            return [
                'error' => false,
                'codigoEntrega' => $arEntrega->getCodigoEntregaPk(),
                'fechaIngreso' => $arEntrega->getFechaIngreso(),
                'urlImagen' => $arEntrega->getUrlImagen()
                ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la entrega"
            ];
        }
    }

    public function apiAutorizar($codigoEntrega, $autorizar, $codigoUsuario)
    {
        $em = $this->getEntityManager();
        $arEntrega = $em->getRepository(Entrega::class)->find($codigoEntrega);
        if($arEntrega) {
            if($arEntrega->getEstadoAutorizado() == 'P') {
                if($arEntrega->isEstadoCerrado() == 0) {
                    $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
                    if($arUsuario) {
                        if($autorizar == 'S' || $autorizar == 'N') {
                            if($autorizar == 'S') {
                                $arEntrega->setEstadoAutorizado($autorizar);
                            }
                            if($autorizar == 'N') {
                                $arEntrega->setEstadoAutorizado($autorizar);
                            }
                            $em->persist($arEntrega);
                            $em->flush();
                            return ['error' => false];
                        } else {
                            return [
                                'error' => true,
                                'errorMensaje' => "Solo se permiten valores S o N en el parametro autorizar"
                            ];
                        }
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "No existe el usuario"
                        ];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "La entrega esta cerrada"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "La entrega no esta pendiente de autorizacion"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la entrega"
            ];
        }
    }

    public function apiCerrar($codigoEntrega, $codigoUsuario, $imagenBase64)
    {
        $em = $this->getEntityManager();
        $arEntrega = $em->getRepository(Entrega::class)->find($codigoEntrega);
        if($arEntrega) {
            if($arEntrega->isEstadoCerrado() == 0) {
                $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
                if($arUsuario) {
                    $arEntrega->setEstadoCerrado(1);
                    if($imagenBase64) {
                        $arEntrega->setUrlImagen($this->space->subir('entrega', $imagenBase64['nombre'], $imagenBase64['base64']));
                    }
                    $em->persist($arEntrega);
                    $em->flush();
                    return ['error' => false];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "No existe el usuario"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "La entrega esta cerrada"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la entrega"
            ];
        }
    }

    public function apiPendiente($codigoPanal, $celda, $estadoAutorizado)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Entrega::class, 'e')
            ->select('e.codigoEntregaPk')
            ->addSelect('e.fechaIngreso')
            ->addSelect('e.codigoEntregaTipoFk')
            ->addSelect('e.estadoAutorizado')
            ->addSelect('e.descripcion')
            ->addSelect('c.celda')
            ->leftJoin('e.celdaRel', 'c')
            ->where("c.codigoPanalFk = {$codigoPanal}")
            ->andWhere("e.estadoCerrado = 0")
            ->orderBy("e.estadoAutorizado", "DESC")
            ->addOrderBy("e.fechaIngreso", "ASC");
        if($celda) {
            $queryBuilder->andWhere("c.celda = '{$celda}'");
        }
        if($estadoAutorizado) {
            $queryBuilder->andWhere("e.estadoAutorizado = '{$estadoAutorizado}'");
        }
        $arEntregas = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'entregas' => $arEntregas
        ];
    }

    public function apiInformeEstados($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Entrega::class, 'e')
            ->select('e.codigoEntregaTipoFk')
            ->addSelect('count(e.codigoEntregaTipoFk) as cantidad' )
            ->groupBy('e.codigoEntregaTipoFk')
            ->leftJoin('e.celdaRel', 'c')
            ->Where("c.codigoPanalFk  = '{$codigoPanal}' ");

        $arEntregas = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'entregas' => $arEntregas
        ];
    }

}