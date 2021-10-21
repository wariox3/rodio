<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\CeldaUsuario;
use App\Entity\Panal;
use App\Entity\Usuario;
use App\Entity\Visita;
use App\Utilidades\Firebase;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VisitaRepository extends ServiceEntityRepository
{
    private $firebase;
    private $space;

    public function __construct(ManagerRegistry $registry, Firebase $firebase, SpaceDO $space)
    {
        parent::__construct($registry, Visita::class);
        $this->firebase = $firebase;
        $this->space = $space;
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
            ->addSelect('v.urlImagen')
            ->where("v.codigoCeldaFk = {$codigoCelda}")
            ->orderBy('e.estadoCerrado', 'ASC')
            ->orderBy('v.fecha', 'DESC');
        $arVisitas = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'visitas' => $arVisitas
        ];
    }

    public function apiNuevo($codigoPanal, $codigoCelda, $celda, $numeroIdentificacion, $nombre, $placa, $imagen)
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
                if($imagen) {
                    if($imagen['nombre'] && $imagen['base64']) {
                        $arVisita->setUrlImagen($this->space->subir('visita', $imagen['nombre'], $imagen['base64']));
                    }
                }
                $em->persist($arVisita);
                $em->flush();
                //Usuarios a los que se debe notificar
                $arCeldaUsuarios = $em->getRepository(CeldaUsuario::class)->findBy(['codigoCeldaFk' => $arCelda->getCodigoCeldaPk()]);
                foreach ($arCeldaUsuarios as $arCeldaUsuario) {
                    $this->firebase->nuevaVisita($arCeldaUsuario->getUsuarioRel()->getTokenFirebase(), $arVisita->getCodigoVisitaPk(), $nombre, 0);
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

    public function apiPendiente($codigoPanal, $celda, $estadoAutorizado, $codigoIngreso)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Visita::class, 'v')
            ->select('v.codigoVisitaPk')
            ->addSelect('v.fecha')
            ->addSelect('v.numeroIdentificacion')
            ->addSelect('v.nombre')
            ->addSelect('v.placa')
            ->addSelect('v.codigoIngreso')
            ->addSelect('v.estadoAutorizado')
            ->addSelect('v.estadoCerrado')
            ->addSelect('v.urlImagen')
            ->addSelect('c.celda')
            ->addSelect('c.celular')
            ->addSelect('c.correo')
            ->leftJoin('v.celdaRel', 'c')
            ->where("c.codigoPanalFk = {$codigoPanal}")
            ->andWhere('v.estadoCerrado = 0');
        if($celda) {
            $queryBuilder->andWhere("c.celda = '{$celda}'");
        }
        if($estadoAutorizado) {
            $queryBuilder->andWhere("v.estadoAutorizado = '{$estadoAutorizado}'");
        }
        if($codigoIngreso) {
            $queryBuilder->andWhere("v.codigoIngreso = '{$codigoIngreso}'");
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

    public function apiCerrar($codigoVisita, $codigoUsuario)
    {
        $em = $this->getEntityManager();
        $arVisita = $em->getRepository(Visita::class)->find($codigoVisita);
        if($arVisita) {
            if($arVisita->getEstadoCerrado() == 0) {
                $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
                if($arUsuario) {
                    $arVisita->setEstadoCerrado(1);
                    $em->persist($arVisita);
                    $em->flush();
                    return [
                        'error' => false
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
                    'errorMensaje' => "La visita fue cerrada"
                ];
            }

        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe la visita"
            ];
        }
    }

    public function apiInformeEstados($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Visita::class, 'v')
            ->select('v.estadoAutorizado')
            ->addSelect('count(v.estadoAutorizado) as cantidad' )
            ->groupBy('v.estadoAutorizado')
            ->leftJoin('v.celdaRel', 'c')
            ->Where("c.codigoPanalFk  = '{$codigoPanal}' ");

        $arVisitas = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'visitas' => $arVisitas
        ];
    }
}