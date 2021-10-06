<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\Panal;
use App\Entity\Usuario;
use App\Entity\Visita;
use App\Utilidades\Firebase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VisitaRepository extends ServiceEntityRepository
{
    private $firebase;
    public function __construct(ManagerRegistry $registry, Firebase $firebase)
    {
        parent::__construct($registry, Visita::class);
        $this->firebase = $firebase;
    }

    public function apiLista($codigoCelda)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Visita::class, 'v')
            ->select('v.codigoVisitaPk')
            ->addSelect('v.fecha')
            ->addSelect('v.numeroIdentificacion')
            ->addSelect('v.nombre')
            ->addSelect('v.placa')
            ->addSelect('v.estadoAutorizado')
            ->addSelect('v.estadoCerrado')
            ->addSelect('v.codigoIngreso')
            ->where("v.codigoCeldaFk = {$codigoCelda}")
            ->orderBy('e.estadoCerrado', 'ASC')
            ->orderBy('v.fecha', 'DESC');
        $arVisitas = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'visitas' => $arVisitas
        ];
    }

    public function apiNuevo($codigoPanal, $codigoCelda, $celda, $numeroIdentificacion, $nombre, $placa)
    {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if($arPanal) {
            if($codigoCelda) {
                $arCelda = $em->getRepository(Celda::class)->find($codigoCelda);
            } else {
                $arCelda = $em->getRepository(Celda::class)->findOneBy(['codigoPanalFk' => $codigoPanal, 'celda' => $celda]);
            }
            if($arCelda) {
                $codigo = rand(10000, 99999);
                $arVisita = new Visita();
                $arVisita->setCeldaRel($arCelda);
                $arVisita->setFecha(new \DateTime('now'));
                $arVisita->setNumeroIdentificacion($numeroIdentificacion);
                $arVisita->setNombre($nombre);
                $arVisita->setPlaca($placa);
                $arVisita->setCodigoIngreso($codigo);
                $em->persist($arVisita);
                $em->flush();
                //Usuarios a los que se debe notificar
                $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['codigoCeldaFk' => $arCelda->getCodigoCeldaPk()]);
                if($arUsuario) {
                    $this->firebase->nuevaVisita($arUsuario->getTokenFirebase(), $arVisita->getCodigoVisitaPk(), $nombre, 0);
                }
                return [
                    'error' => false,
                    'codigoVisita' => $arVisita->getCodigoVisitaPk(),
                    'codigoIngreso' => $codigo
                ];
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

    public function apiPendiente($codigoPanal, $celda, $estadoAutorizado)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Visita::class, 'v')
            ->select('v.codigoVisitaPk')
            ->addSelect('v.fecha')
            ->addSelect('v.numeroIdentificacion')
            ->addSelect('v.nombre')
            ->addSelect('v.placa')
            ->addSelect('v.estadoAutorizado')
            ->addSelect('v.estadoCerrado')
            ->addSelect('c.celda')
            ->leftJoin('v.celdaRel', 'c')
            ->where("c.codigoPanalFk = {$codigoPanal}")
            ->andWhere('v.estadoCerrado = 0');
        if($celda) {
            $queryBuilder->andWhere("c.celda = '{$celda}'");
        }
        if($estadoAutorizado) {
            $queryBuilder->andWhere("v.estadoAutorizado = '{$estadoAutorizado}'");
        }
        $arVisitas = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'visitas' => $arVisitas
        ];
    }

    public function apiAutorizar($codigoVisita, $autorizar, $codigoUsuario)
    {
        $em = $this->getEntityManager();
        $arVisita = $em->getRepository(Visita::class)->find($codigoVisita);
        if($arVisita) {
            if($arVisita->getEstadoAutorizado() == 'P') {
                if($arVisita->getEstadoCerrado() == 0) {
                    $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
                    if($arUsuario) {
                        if($autorizar == 'S' || $autorizar == 'N') {
                            $arVisita->setUsuarioAutorizaRel($arUsuario);
                            $arVisita->setEstadoAutorizado($autorizar);
                            $em->persist($arVisita);
                            $em->flush();
                            return [
                                'error' => false
                            ];
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
                        'errorMensaje' => "La visita fue cerrada"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "La visita no esta pendiente de autorizacion"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la visita"
            ];
        }
    }
}