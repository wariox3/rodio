<?php


namespace App\Repository;

use App\Entity\Despacho;
use App\Entity\Operador;
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
            ->addSelect('o.nombre as operadorNombre')
            ->leftJoin('d.operadorRel', 'o')
            ->andWhere("d.codigoUsuarioFk = {$codigoUsuario}")
            ->orderBy('d.fecha', 'DESC');
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

    public function apiGuiaEntrega($codigoDespacho, $guia, $usuario, $imagenes)
    {
        $em = $this->getEntityManager();
        $arDespacho = $em->getRepository(Despacho::class)->find($codigoDespacho);
        if($arDespacho) {
            $parametros = [
                "codigoGuia" => $guia,
                "usuario" => $usuario,
                "imagenes" => $imagenes
            ];
            $respuesta = $this->cromo->post($arDespacho->getOperadorRel(), '/api/transporte/guia/entrega', $parametros);
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
}