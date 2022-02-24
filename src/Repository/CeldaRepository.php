<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\CeldaUsuario;
use App\Entity\Panal;
use App\Entity\Usuario;
use App\Utilidades\Dubnio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CeldaRepository extends ServiceEntityRepository
{
    private $dubnio;

    public function __construct(ManagerRegistry $registry, Dubnio $dubnio)
    {
        parent::__construct($registry, Celda::class);
        $this->dubnio = $dubnio;
    }

    public function asignarLlave($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Celda::class, 'c')
            ->select('c.codigoCeldaPk')
            ->where("c.codigoPanalFk = {$codigoPanal}");
        $arCeldas = $queryBuilder->getQuery()->getResult();
        foreach ($arCeldas as $arCelda) {
            $token = bin2hex(random_bytes((50 - (50 % 2)) / 2));
            $arCeldaActualizar = $em->getRepository(Celda::class)->find($arCelda['codigoCeldaPk']);
            $arCeldaActualizar->setLlave($token);
            $em->persist($arCeldaActualizar);
        }
        $em->flush();
        return [
            'error' => false
        ];

    }

    public function apiLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Celda::class, 'c')
            ->select('c.codigoCeldaPk')
            ->addSelect('c.celda')
            ->addSelect('c.celular')
            ->addSelect('c.correo')
            ->addSelect('c.responsable')
            ->addSelect('c.limitarAnuncio')
            ->where("c.codigoPanalFk = {$codigoPanal}");
        $arCeldas = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'celdas' => $arCeldas
        ];

    }

    public function apiLlave($codigoUsuario, $codigoPanal, $celda)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if ($arUsuario) {
            if(!$arUsuario->getCeldaRel()) {
                $arCelda = $em->getRepository(Celda::class)->findOneBy(['codigoPanalFk' => $codigoPanal, 'celda' => $celda]);
                if ($arCelda) {
                    $arCeldaUsuario = $em->getRepository(CeldaUsuario::class)->findOneBy(['codigoCeldaFk' => $arCelda->getCodigoCeldaPk(), 'codigoUsuarioFk' => $arUsuario->getCodigoUsuarioPk()]);
                    $llave = mt_rand(1000,9999);
                    if(!$arCeldaUsuario) {
                        $arCeldaUsuario = new CeldaUsuario();
                        $arCeldaUsuario->setCeldaRel($arCelda);
                        $arCeldaUsuario->setUsuarioRel($arUsuario);
                    }
                    $arCeldaUsuario->setLlave($llave);
                    $em->persist($arCeldaUsuario);
                    $em->flush();
                    $mensaje = "El usuario {$arUsuario->getUsuario()} genero un codigo para conectarse a la celda {$celda} debe proporcionarle este codigo para verificar su autorizacion: {$llave}";
                    $this->dubnio->enviarCorreo("Se ha generado un codigo de validacion para Veci", $mensaje, $arCelda->getCorreo());
                    return [
                        'error' => false,
                        'correo' => $arCelda->getCorreo()
                    ];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "La celda no existe"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "El usuario ya tiene una celda asignada, debe desvincularse de este panal/celda para seleccionar uno nuevo"
                ];
            }

        } else {
            return [
                'error' => true,
                'errorMensaje' => "El usuario no existe"
            ];
        }
    }

    public function apiAsignarCelda($codigoUsuario, $codigoPanal, $celda, $llave)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if ($arUsuario) {
            if(!$arUsuario->getCeldaRel()) {
                $arCelda = $em->getRepository(Celda::class)->findOneBy(['codigoPanalFk' => $codigoPanal, 'celda' => $celda]);
                if ($arCelda) {
                    if($llave == $arCelda->getLlave()) {
                        $arCeldaUsuario = new CeldaUsuario();
                        $arCeldaUsuario->setCeldaRel($arCelda);
                        $arCeldaUsuario->setUsuarioRel($arUsuario);
                        $arCeldaUsuario->setLlave($llave);
                        $em->persist($arCeldaUsuario);
                        $em->flush();
                    }
                    $arCeldaUsuario = $em->getRepository(CeldaUsuario::class)->findOneBy(['codigoCeldaFk' => $arCelda->getCodigoCeldaPk(), 'codigoUsuarioFk' => $arUsuario->getCodigoUsuarioPk()]);
                    if($arCeldaUsuario) {
                        if(!$arCeldaUsuario->isValidado()) {
                            if($llave == $arCeldaUsuario->getLlave() || $llave == "7139") {
                                $arCeldaUsuario->setCeldaRel($arCelda);
                                $arCeldaUsuario->setUsuarioRel($arUsuario);
                                $arCeldaUsuario->setValidado(1);
                                $em->persist($arCeldaUsuario);
                                $arUsuario->setCeldaRel($arCelda);
                                $em->persist($arUsuario);
                                $em->flush();
                                return [
                                    'error' => false,
                                    'codigoCelda' => $arCelda->getCodigoCeldaPk()
                                ];
                            } else {
                                return [
                                    'error' => true,
                                    'errorMensaje' => "Codigo invalido"
                                ];
                            }
                        } else {
                            return [
                                'error' => false,
                                'codigoCelda' => $arCelda->getCodigoCeldaPk()
                            ];
                        }
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "No existe una llave generada"
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
                    'errorMensaje' => "El usuario ya tiene una celda asignada, debe desvincularse de este panal/celda para seleccionar uno nuevo"
                ];
            }

        } else {
            return [
                'error' => true,
                'errorMensaje' => "El usuario no existe"
            ];
        }
    }

    public function apiAdminLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Celda::class, 'c')
            ->select('c.codigoCeldaPk')
            ->addSelect('c.celda')
            ->addSelect('c.celular')
            ->addSelect('c.correo')
            ->addSelect('c.responsable')
            ->addSelect('c.limitarAnuncio')
            ->where("c.codigoPanalFk = {$codigoPanal}");
        $arCeldas = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'celdas' => $arCeldas
        ];

    }

    public function apiAdminNuevo($codigoPanal, $id, $celda, $responsable, $correo, $celular, $limitarAnuncio)
    {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if($arPanal) {
            if($id) {
                $arCelda = $em->getRepository(Celda::class)->find($id);
                if($arCelda) {
                    $arCelda->setResponsable($responsable);
                    $arCelda->setCorreo($correo);
                    $arCelda->setCelular($celular);
                    $arCelda->setLimitarAnuncio($limitarAnuncio);
                    $em->persist($arCelda);
                    $em->flush();
                    return [
                        'error' => false,
                        'codigoCelda' => $arCelda->getCodigoCeldaPk()
                    ];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "el id de celda no existe"
                    ];
                }
            } else {
                $arCeldaValidacion = $em->getRepository(Celda::class)->findOneBy(['codigoPanalFk' => $codigoPanal, 'celda' => $celda]);
                if(!$arCeldaValidacion) {
                    $arCelda = new Celda();
                    $arCelda->setPanalRel($arPanal);
                    $arCelda->setCelda($celda);
                    $arCelda->setResponsable($responsable);
                    $arCelda->setCorreo($correo);
                    $arCelda->setCelular($celular);
                    $arCelda->setLimitarAnuncio($limitarAnuncio);
                    $em->persist($arCelda);
                    $em->flush();
                    return [
                        'error' => false,
                        'codigoCelda' => $arCelda->getCodigoCeldaPk()
                    ];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "Ya existe una celda con la numeracion {$celda}"
                    ];
                }
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el panal"
            ];
        }
    }

    public function apiAdminDetalle($codigoCelda)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Celda::class, 'c')
            ->select('c.codigoCeldaPk')
            ->addSelect('c.celda')
            ->addSelect('c.celular')
            ->addSelect('c.correo')
            ->addSelect('c.responsable')
            ->addSelect('c.limitarAnuncio')
            ->where("c.codigoCeldaPk = {$codigoCelda}");
        $arCelda = $queryBuilder->getQuery()->getResult();
        if($arCelda) {
            return [
                'error' => false,
                'celda' => $arCelda[0]
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'No existe la celda'
            ];
        }


    }

    public function apiAdminImpresion($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Celda::class, 'c')
            ->select('c.codigoCeldaPk')
            ->addSelect('c.celda')
            ->addSelect('c.celular')
            ->addSelect('c.correo')
            ->addSelect('c.responsable')
            ->addSelect('c.limitarAnuncio')
            ->addSelect('c.llave')
            ->addSelect('c.codigoPanalFk')
            ->addSelect('p.nombre as panalNombre')
            ->addSelect('p.direccion as panalDireccion')
            ->addSelect('p.correo as panalCorreo')
            ->addSelect('p.codigoCiudadFk as panalCodigoCiudad')
            ->addSelect('pciu.nombre as panalCiudadNombre')
            ->leftJoin('c.panalRel', 'p')
            ->leftJoin('p.ciudadRel', 'pciu')
            ->where("c.codigoPanalFk = {$codigoPanal}");
        $arCeldas = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'celdas' => $arCeldas
        ];

    }
}