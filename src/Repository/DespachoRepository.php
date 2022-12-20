<?php


namespace App\Repository;

use App\Entity\Despacho;
use App\Entity\Guia;
use App\Entity\Operador;
use App\Entity\Ubicacion;
use App\Entity\Usuario;
use App\Utilidades\Cromo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DespachoRepository extends ServiceEntityRepository
{
    private $cromo;
    public function __construct(ManagerRegistry $registry, Cromo $cromo)
    {
        parent::__construct($registry, Despacho::class);
        $this->cromo = $cromo;
    }

    public function apiNuevo($codigoUsuario, $operador, $codigoDespacho, $token)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arOperador = $em->getRepository(Operador::class)->find($operador);
            if($arOperador) {
                $arDespacho = $em->getRepository(Despacho::class)->findOneBy(['codigoUsuarioFk' => $codigoUsuario, 'codigoOperadorFk' => $operador, 'codigoDespacho' => $codigoDespacho]);
                if(!$arDespacho) {
                    $parametros = [
                        "codigoDespacho" => $codigoDespacho,
                        "codigoUsuario" => $codigoUsuario,
                        "token" => $token,
                    ];
                    $respuesta = $this->cromo->post($arOperador, '/api/transporte/despacho/cargar', $parametros);
                    if($respuesta['error'] == false) {
                        $arDespacho = new Despacho();
                        $arDespacho->setFecha(new \DateTime('now'));
                        $arDespacho->setFechaDespacho(date_create($respuesta['fecha']));
                        $arDespacho->setCodigoDespachoClaseFk($respuesta['codigoDespachoClase']);
                        $arDespacho->setUsuarioRel($arUsuario);
                        $arDespacho->setOperadorRel($arOperador);
                        $arDespacho->setCodigoDespacho($codigoDespacho);
                        $arDespacho->setToken($token);
                        $em->persist($arDespacho);
                        $em->flush();
                        return [
                            'error' => false,
                            'codigoDespacho' => $arDespacho->getCodigoDespachoPk(),
                        ];
                    } else {
                        return $respuesta;
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "El usuario ya cargo este despacho"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe el operador"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }

    public function apiLista($codigoUsuario)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Despacho::class, 'd')
            ->select('d.codigoDespachoPk')
            ->addSelect('d.fecha')
            ->addSelect('d.codigoOperadorFk')
            ->addSelect('d.codigoDespacho')
            ->addSelect('d.token')
            ->addSelect('d.fechaDespacho')
            ->addSelect('d.codigoDespachoClaseFk')
            ->addSelect('d.estadoEntregado')
            ->addSelect('o.nombre as operadorNombre')
            ->leftJoin('d.operadorRel', 'o')
            ->andWhere("d.codigoUsuarioFk = {$codigoUsuario}")
            ->orderBy('d.fecha', 'DESC')
            ->setMaxResults(5);
        $arDespachos = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'despachos' => $arDespachos
        ];
    }

    public function apiDetalle($codigoDespacho)
    {
        $em = $this->getEntityManager();
        $arDespacho = $em->getRepository(Despacho::class)->find($codigoDespacho);
        if($arDespacho) {
            return [
                'error' => false,
                'codigoDespachoPk' =>$arDespacho->getCodigoDespachoPk(),
                'fecha' =>$arDespacho->getFecha(),
                'codigoDespacho' => $arDespacho->getCodigoDespacho(),
                'token' => $arDespacho->getToken(),
                'estadoEntregado' => $arDespacho->isEstadoEntregado(),
                'codigoOperador' => $arDespacho->getCodigoOperadorFk(),
                'nombre' => $arDespacho->getOperadorRel()->getNombre(),
                'puntoServicio' => $arDespacho->getOperadorRel()->getPuntoServicioCromo(),
                'puntoServicioToken' => $arDespacho->getOperadorRel()->getToken()

            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El despacho no existe"
            ];
        }
    }

    public function apiEntrega($codigoDespacho, $fecha, $hora)
    {
        $em = $this->getEntityManager();
        $arDespacho = $em->getRepository(Despacho::class)->find($codigoDespacho);
        if($arDespacho) {
            $parametros = [
                "codigoDespacho" => $arDespacho->getCodigoDespacho(),
                "fecha" => $fecha,
                "hora" => $hora
            ];
            $respuesta = $this->cromo->post($arDespacho->getOperadorRel(), '/api/transporte/despacho/entrega', $parametros);
            if($respuesta['error'] == false) {
                $arDespacho->setEstadoEntregado(1);
                $em->persist($arDespacho);
                $em->flush();
                return [
                    'error' => false
                ];
            } else {
                return $respuesta;
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El despacho no existe"
            ];
        }
    }

    public function apiGuiaEntrega($codigoDespacho, $guia, $usuario, $imagenes, $ubicacion, $firma, $recibe, $recibeParentesco, $recibeNumeroIdentificacion, $recibeCelular)
    {
        $em = $this->getEntityManager();
        $arDespacho = $em->getRepository(Despacho::class)->find($codigoDespacho);
        if($arDespacho) {
            $arUsuario = $em->getRepository(Usuario::class)->find($usuario);
            if($arUsuario) {
                $parametros = [
                    "codigoGuia" => $guia,
                    "codigoDespacho" => $arDespacho->getCodigoDespacho(),
                    "usuario" => $usuario,
                    "usuarioNombre" => $arUsuario->getNombre(),
                    "usuarioCorreo" => $arUsuario->getUsuario(),
                    "imagenes" => $imagenes,
                    "firmarBase64" => $firma,
                    "ubicacion" => $ubicacion,
                    "recibe" => $recibe,
                    "parentesco" => $recibeParentesco,
                    "numeroIdentificacion" => $recibeNumeroIdentificacion,
                    "celular" => $recibeCelular,
                ];
                $respuesta = $this->cromo->post($arDespacho->getOperadorRel(), '/api/transporte/guia/entrega', $parametros);
                if($respuesta['error'] == false) {
                    $arGuia = new Guia();
                    $arGuia->setFecha(new \DateTime('now'));
                    $arGuia->setUsuarioRel($arUsuario);
                    $arGuia->setOperadorRel($arDespacho->getOperadorRel());
                    $arGuia->setCodigoGuia($guia);
                    $arGuia->setCodigoSeguimientoTipoFk('ENTREGA');
                    $em->persist($arGuia);

                    if ($ubicacion) {
                        if (is_array($ubicacion)) {
                            $arUbicacion = new Ubicacion();
                            $arUbicacion->setCodigoGuiaFk($guia);
                            $arUbicacion->setDespachoRel($arDespacho);
                            $arUbicacion->setFecha(new \DateTime('now'));
                            $arUbicacion->setVelocidad($ubicacion['speed'] ?? 0);
                            $arUbicacion->setLatitud($ubicacion['latitude'] ?? 0);
                            $arUbicacion->setLongitud($ubicacion['longitude'] ?? 0);
                            $arUbicacion->setAltitud($ubicacion['altitude'] ?? 0);
                            $arUbicacion->setExactitud($ubicacion['accuracy'] ?? 0);
                            $arUbicacion->setExactitudAltitud($ubicacion['altitudeAccuracy'] ?? 0);
                            $em->persist($arUbicacion);
                        }
                    }

                    $em->flush();
                    return [
                        'error' => false
                    ];
                } else {
                    return $respuesta;
                }
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El despacho no existe"
            ];
        }
    }

    public function apiGuiaRecogidoDetalle($codigoDespacho, $guia)
    {
        $em = $this->getEntityManager();
        $arDespacho = $em->getRepository(Despacho::class)->find($codigoDespacho);
        if($arDespacho) {
            $parametros = [
                "codigoGuia" => $guia
            ];
            return $this->cromo->post($arDespacho->getOperadorRel(), '/api/transporte/guia/detalle/recogido', $parametros);
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El despacho no existe"
            ];
        }
    }

    public function apiGuiaRecogido($codigoDespacho, $guia, $usuario, $unidades)
    {
        $em = $this->getEntityManager();
        $arDespacho = $em->getRepository(Despacho::class)->find($codigoDespacho);
        if($arDespacho) {
            $parametros = [
                "codigoGuia" => $guia,
                "codigoDespacho" => $arDespacho->getCodigoDespacho(),
                "usuario" => $usuario,
                "unidades" => $unidades
            ];
            $respuesta = $this->cromo->post($arDespacho->getOperadorRel(), '/api/transporte/guia/recogido', $parametros);
            if($respuesta['error'] == false) {
                return [
                    'error' => false
                ];
            } else {
                return $respuesta;
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El despacho no existe"
            ];
        }
    }

    public function apiGuiaEntregaPendiente($codigoDespacho)
    {
        $em = $this->getEntityManager();
        $arDespacho = $em->getRepository(Despacho::class)->find($codigoDespacho);
        if($arDespacho) {
            $parametros = [
                "codigoDespacho" => $arDespacho->getCodigoDespacho()
            ];
            return $this->cromo->post($arDespacho->getOperadorRel(), '/api/transporte/guia/pendiente/entrega/despacho', $parametros);
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El despacho no existe"
            ];
        }
    }

    public function apiGuiaNovedadTipoLista($codigoDespacho)
    {
        $em = $this->getEntityManager();
        $arDespacho = $em->getRepository(Despacho::class)->find($codigoDespacho);
        if($arDespacho) {
            return $this->cromo->post($arDespacho->getOperadorRel(), '/api/transporte/novedadtipo/lista', []);
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El despacho no existe"
            ];
        }
    }

    public function apiGuiaNovedadNuevo($codigoDespacho, $codigoGuia, $codigoNovedadTipo, $descripcion)
    {
        $em = $this->getEntityManager();
        $arDespacho = $em->getRepository(Despacho::class)->find($codigoDespacho);
        if($arDespacho) {
            $parametros = [
                "codigoGuia" => $codigoGuia,
                "codigoNovedadTipo" => $codigoNovedadTipo,
                "descripcion" => $descripcion
            ];
            return $this->cromo->post($arDespacho->getOperadorRel(), '/api/transporte/novedad/nuevo', $parametros);
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El despacho no existe"
            ];
        }
    }

    public function apiGuias($codigoDespacho)
    {
        $em = $this->getEntityManager();
        $arDespacho = $em->getRepository(Despacho::class)->find($codigoDespacho);
        if($arDespacho) {
            $parametros = [
                "codigoDespacho" => $arDespacho->getCodigoDespacho()
            ];
            return $this->cromo->post($arDespacho->getOperadorRel(), '/api/transporte/despacho/guias', $parametros);
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El despacho no existe"
            ];
        }
    }

    public function apiMonitoreoDetalleNuevo($codigoDespacho, $usuario, $ubicacion, $comentario)
    {
        $em = $this->getEntityManager();
        $arDespacho = $em->getRepository(Despacho::class)->find($codigoDespacho);
        if($arDespacho) {
            $arUsuario = $em->getRepository(Usuario::class)->find($usuario);
            if($arUsuario) {
                $parametros = [
                    "codigoDespacho" => $arDespacho->getCodigoDespacho(),
                    "usuario" => $usuario,
                    "comentario" => $comentario,
                    "ubicacion" => $ubicacion
                ];
                $respuesta = $this->cromo->post($arDespacho->getOperadorRel(), '/api/transporte/monitoreo/detalle/nuevo', $parametros);
                if($respuesta['error'] == false) {
                    if ($ubicacion) {
                        if (is_array($ubicacion)) {
                            $arUbicacion = new Ubicacion();
                            $arUbicacion->setDespachoRel($arDespacho);
                            $arUbicacion->setFecha(new \DateTime('now'));
                            $arUbicacion->setVelocidad($ubicacion['speed'] ?? 0);
                            $arUbicacion->setLatitud($ubicacion['latitude'] ?? 0);
                            $arUbicacion->setLongitud($ubicacion['longitude'] ?? 0);
                            $arUbicacion->setAltitud($ubicacion['altitude'] ?? 0);
                            $arUbicacion->setExactitud($ubicacion['accuracy'] ?? 0);
                            $arUbicacion->setExactitudAltitud($ubicacion['altitudeAccuracy'] ?? 0);
                            $em->persist($arUbicacion);
                        }
                    }

                    $em->flush();
                    return [
                        'error' => false
                    ];
                } else {
                    return $respuesta;
                }
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El despacho no existe"
            ];
        }
    }
}