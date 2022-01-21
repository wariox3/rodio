<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\CeldaUsuario;
use App\Entity\Ciudad;
use App\Entity\Panal;
use App\Entity\Usuario;
use App\Utilidades\Dubnio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UsuarioRepository extends ServiceEntityRepository
{
    private $dubnio;

    public function __construct(ManagerRegistry $registry, Dubnio $dubnio)
    {
        parent::__construct($registry, Usuario::class);
        $this->dubnio = $dubnio;
    }

    public function apiAutenticar($usuario, $clave, $tokenFirebase)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['usuario' => $usuario, 'clave' => $clave]);
        if ($arUsuario) {
            if ($tokenFirebase) {
                $arUsuario->setTokenFirebase($tokenFirebase);
                $em->persist($arUsuario);
                $em->flush();
            }
            $operador = "";
            $puntoServicio = "";
            $puntoServicioToken = "";
            if($arUsuario->getOperadorRel()) {
                $operador = $arUsuario->getOperadorRel()->getNombre();
                $puntoServicio = $arUsuario->getOperadorRel()->getPuntoServicioCromo();
                $puntoServicioToken = $arUsuario->getOperadorRel()->getPuntoServicioCromoToken();
            }
            return [
                'error' => false,
                'autenticar' => true,
                'usuario' => [
                    'codigo' => $arUsuario->getCodigoUsuarioPk(),
                    'usuario' => $arUsuario->getUsuario(),
                    'nombre' => $arUsuario->getNombre(),
                    'urlImagen' => $arUsuario->getUrlImagen(),
                    'codigoCelda' => $arUsuario->getCodigoCeldaFk(),
                    'codigoPanal' => $arUsuario->getCodigoPanalFk(),
                    'codigoCiudad' => $arUsuario->getCodigoCiudadFk(),
                    'codigoPuesto' => $arUsuario->getCodigoPuestoFk(),
                    'codigoOperador' => $arUsuario->getCodigoOperadorFk(),
                    'operador' => $operador,
                    'puntoServicio' => $puntoServicio,
                    'puntoServicioToken' => $puntoServicioToken,
                ],
            ];
        } else {
            return [
                'error' => false,
                'autenticar' => false
            ];
        }
    }

    public function apiNuevo($usuario, $clave, $celular)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Usuario::class, 'u')
            ->select('u.codigoUsuarioPk')
            ->where("u.usuario = '{$usuario}'");
        $arUsuario = $queryBuilder->getQuery()->getResult();
        if (!$arUsuario) {
            $usuarioSeparado = explode('@', $usuario);
            $arUsuario = new Usuario();
            $arUsuario->setUsuario($usuario);
            $arUsuario->setNombre($usuarioSeparado[0]);
            $arUsuario->setClave($clave);
            $arUsuario->setCelular($celular);
            $arUsuario->setUrlImagen('https://semantica.sfo3.digitaloceanspaces.com/rodio/perfil/general.png');
            $em->persist($arUsuario);
            $em->flush();
            return [
                'error' => false,
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Ya existe un usuario con este correo'
            ];
        }
    }

    public function apiRecuperarClave($usuario)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['usuario' => $usuario]);
        if ($arUsuario) {
            $asunto = "Veci! recuperamos tu clave";
            $mensaje = "Tu clave para acceder a la app Veci! es {$arUsuario->getClave()}";
            $this->dubnio->enviarCorreo($asunto, $mensaje, $usuario);
            return [
                'error' => false
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }

    public function apiCambiarClave($codigoUsuario, $claveNueva)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if ($arUsuario) {
            $arUsuario->setClave($claveNueva);
            $em->persist($arUsuario);
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
    }

    public function apiAsignarPanal($codigoUsuario, $codigoPanal, $codigoCiudad)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if ($arUsuario) {
            if(!$arUsuario->getPanalRel()) {
                $arCiudad = $em->getRepository(Ciudad::class)->find($codigoCiudad);
                if ($arCiudad) {
                    $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
                    if ($arPanal) {
                        $arUsuario->setPanalRel($arPanal);
                        $arUsuario->setCiudadRel($arCiudad);
                        $em->persist($arUsuario);
                        $em->flush();
                        return [
                            'error' => false,
                            'panal' => $arPanal->getCodigoPanalPk(),
                            'ciudad' => $arCiudad->getCodigoCiudadPk()
                        ];
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "El panal no existe"
                        ];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "La ciudad no existe"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "El usuario ya tiene un panal asignado, debe desvincularse de este panal para seleccionar uno nuevo"
                ];
            }

        } else {
            return [
                'error' => true,
                'errorMensaje' => "El usuario no existe"
            ];
        }
    }

    public function apiDesvincular($codigoUsuario)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if ($arUsuario) {
            if($arUsuario->getCeldaRel()) {
                $arCeldaUsuarios = $em->getRepository(CeldaUsuario::class)->findBy(['codigoCeldaFk' => $arUsuario->getCodigoCeldaFk(), 'codigoUsuarioFk' => $codigoUsuario]);
                foreach ($arCeldaUsuarios as $arCeldaUsuario) {
                    $em->remove($arCeldaUsuario);
                }
            }
            $arUsuario->setCeldaRel(null);
            $arUsuario->setPanalRel(null);
            $arUsuario->setCiudadRel(null);
            $em->persist($arUsuario);
            $em->flush();
            return [
                'error' => false
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El usuario no existe"
            ];
        }
    }

    public function apiDetalle($codigoUsuario)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $panalNombre = null;
            $celda = null;
            $ciudadNombre = null;
            if($arUsuario->getPanalRel()) {
                $panalNombre = $arUsuario->getPanalRel()->getNombre();
            }
            if($arUsuario->getCeldaRel()) {
                $celda = $arUsuario->getCeldaRel()->getCelda();
            }
            if($arUsuario->getCiudadRel()) {
                $ciudadNombre = $arUsuario->getCiudadRel()->getNombre();
            }
            return [
                'error' => false,
                'nombre' => $arUsuario->getNombre(),
                'codigoPanalFk' => $arUsuario->getCodigoPanalFk(),
                'codigoCeldaFk' => $arUsuario->getCodigoCeldaFk(),
                'celular' => $arUsuario->getCelular(),
                'panalNombre' => $panalNombre,
                'celda' => $celda,
                'codigoCiudadFk' => $arUsuario->getCodigoCiudadFk(),
                'ciudadNombre' => $ciudadNombre
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El usuario no existe"
            ];
        }
    }

    public function apiEditarInformacion($codigoUsuario, $nombre, $celular)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            if($nombre){
                $arUsuario->setNombre($nombre);
            }else {
                return [
                    'error' => true,
                    'errorMensaje' => "El nombre del usuario no puede estar vacio"
                ];
            }
            if($celular){
                $arUsuario->setCelular($celular);
            }else {
                return [
                    'error' => true,
                    'errorMensaje' => "El celular no del usuario no puede estar"
                ];
            }
            $em->persist($arUsuario);
            $em->flush();
            return [
                'error' => false,
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El usuario no existe"
            ];
        }
    }
}