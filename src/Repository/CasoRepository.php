<?php

namespace App\Repository;

use App\Entity\Caso;
use App\Entity\CasoComentario;
use App\Entity\CasoTipo;
use App\Entity\Usuario;
use App\Utilidades\Firebase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CasoRepository  extends ServiceEntityRepository
{
    private $firebase;

    public function __construct(ManagerRegistry $registry, Firebase $firebase)
    {
        parent::__construct($registry, Caso::class);
        $this->firebase = $firebase;
    }

    public function apiNuevo($tipo, $codigoUsuario, $comentario)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arCasoTipo = $em->getRepository(CasoTipo::class)->find($tipo);
            if($arCasoTipo) {
                $arCaso = new Caso();
                $arCaso->setUsuarioRel($arUsuario);
                $arCaso->setCasoTipoRel($arCasoTipo);
                $arCaso->setComentario($comentario);
                $arCaso->setFecha(new \DateTime('now'));
                $arCaso->setPanalRel($arUsuario->getPanalRel());
                $em->persist($arCaso);
                $em->flush();
                return [
                    'error' => false,
                    'codigoCaso' => $arCaso->getCodigoCasoPk(),
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe el tipo de caso"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }

    public function apiLista($codigoPanal, $codigoUsuario)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Caso::class, 'c')
            ->select('c.codigoCasoPk')
            ->addSelect('c.fecha')
            ->addSelect('c.fechaAtendido')
            ->addSelect('c.codigoCasoTipoFk')
            ->addSelect('c.comentario')
            ->addSelect('c.codigoUsuarioFk')
            ->addSelect('c.estadoAtendido')
            ->addSelect('c.estadoCerrado')
            ->where("c.codigoPanalFk = {$codigoPanal}")
            ->andWhere("c.codigoUsuarioFk = {$codigoUsuario}");
        $arCasos = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'casos' => $arCasos
        ];

    }

    public function apiDetalle($codigoCaso)
    {
        $em = $this->getEntityManager();
        $arCaso = $em->getRepository(Caso::class)->find($codigoCaso);
        if($arCaso) {
            $queryBuilder = $em->createQueryBuilder()->from(CasoComentario::class, 'cc')
                ->select('cc.codigoCasoComentarioPk')
                ->addSelect('cc.fecha')
                ->addSelect('cc.codigoUsuarioFk')
                ->addSelect('cc.comentario')
                ->where("cc.codigoCasoFk = {$codigoCaso}");
            $arCasoComentarios = $queryBuilder->getQuery()->getResult();
            return [
                'error' => false,
                'comentarios' => $arCasoComentarios
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El caso no existe"
            ];
        }
    }

    public function apiDetalleNuevo($codigoCaso, $codigoUsuario, $comentario)
    {
        $em = $this->getEntityManager();
        $arCaso = $em->getRepository(Caso::class)->find($codigoCaso);
        if($arCaso) {
            $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
            if($arUsuario) {
                $arCasoComentario = new CasoComentario();
                $arCasoComentario->setFecha(new \DateTime('now'));
                $arCasoComentario->setCasoRel($arCaso);
                $arCasoComentario->setUsuarioRel($arUsuario);
                $arCasoComentario->setComentario($comentario);
                $em->persist($arCasoComentario);
                $em->flush();
                return [
                    'error' => false,
                    'codigoCasoComentario' => $arCasoComentario->getCodigoCasoComentarioPk(),
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe el usuario"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El caso no existe"
            ];
        }
    }

    public function apiAdminLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Caso::class, 'c')
            ->select('c.codigoCasoPk')
            ->addSelect('c.fecha')
            ->addSelect('c.fechaAtendido')
            ->addSelect('c.codigoCasoTipoFk')
            ->addSelect('c.comentario')
            ->addSelect('c.codigoUsuarioFk')
            ->addSelect('c.estadoAtendido')
            ->addSelect('c.estadoCerrado')
            ->where("c.codigoPanalFk = {$codigoPanal}");
        $arCasos = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'casos' => $arCasos
        ];

    }

    public function apiAdminDetalle($codigoCaso)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Caso::class, 'c')
            ->select('c.codigoCasoPk')
            ->addSelect('c.codigoCasoTipoFk')
            ->addSelect('c.codigoUsuarioFk')
            ->addSelect('c.fecha')
            ->addSelect('c.fechaAtendido')
            ->addSelect('c.comentario')
            ->addSelect('c.estadoAtendido')
            ->addSelect('c.estadoCerrado')
            ->where("c.codigoCasoPk = {$codigoCaso}");
        $arCaso = $queryBuilder->getQuery()->getResult();
        $queryBuilder = $em->createQueryBuilder()->from(CasoComentario::class, 'cc')
            ->select('cc.codigoCasoComentarioPk')
            ->addSelect('cc.fecha')
            ->addSelect('cc.comentario')
            ->addSelect('cc.codigoUsuarioFk')
            ->where("cc.codigoCasoFk = {$codigoCaso}");
        $arCasoComentarios = $queryBuilder->getQuery()->getResult();
        if($arCaso) {
            return [
                'error' => false,
                'caso' => $arCaso[0],
                'comentarios' => $arCasoComentarios
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'No existe la caso'
            ];
        }


    }

    public function apiAdminAtender($id)
    {
        $em = $this->getEntityManager();
        $arCaso = $em->getRepository(Caso::class)->find($id);
        if($arCaso) {
            if($arCaso->isEstadoAtendido() == 0) {
                $arCaso->setEstadoAtendido(1);
                $arCaso->setFechaAtendido(new \DateTime('now'));
                $em->persist($arCaso);
                $em->flush();
                return [
                    'error' => false
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "El caso ya fue atendido"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el caso"
            ];
        }
    }

    public function apiAdminCerrar($id)
    {
        $em = $this->getEntityManager();
        $arCaso = $em->getRepository(Caso::class)->find($id);
        if($arCaso) {
            if($arCaso->isEstadoAtendido() == 1) {
                if($arCaso->isEstadoCerrado() == 0) {
                    $arCaso->setEstadoCerrado(1);
                    $arCaso->setFechaCerrado(new \DateTime('now'));
                    $em->persist($arCaso);
                    $em->flush();
                    return [
                        'error' => false
                    ];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "El caso no puede estar cerrado"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "El caso debe estar atendido"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el caso"
            ];
        }
    }

    public function apiAdminRespuestaNuevo($id, $respuesta)
    {
        $em = $this->getEntityManager();
        $arCaso = $em->getRepository(Caso::class)->find($id);
        if($arCaso) {
            if($arCaso->isEstadoCerrado() == 0) {
                $arCasoComentario = new CasoComentario();
                $arCasoComentario->setFecha(new \DateTime('now'));
                $arCasoComentario->setComentario($respuesta);
                $arCasoComentario->setCasoRel($arCaso);
                $em->persist($arCasoComentario);
                $em->flush();
                return [
                    'error' => false
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No se pueden comentar casos cerrados"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el caso"
            ];
        }
    }
}