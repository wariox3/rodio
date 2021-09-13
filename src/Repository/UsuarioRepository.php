<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\Panal;
use App\Entity\Usuario;
use App\Utilidades\Dubnio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UsuarioRepository extends ServiceEntityRepository
{
    private $dubnio;
    public function __construct(ManagerRegistry $registry, Dubnio $dubnio) {
        parent::__construct($registry, Usuario::class);
        $this->dubnio = $dubnio;
    }

    public function apiAutenticar($usuario, $clave, $tokenFirebase)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['usuario' => $usuario, 'clave' => $clave]);
        if($arUsuario) {
            if($tokenFirebase) {
                $arUsuario->setTokenFirebase($tokenFirebase);
                $em->persist($arUsuario);
                $em->flush();
            }
            return [
                'error' => false,
                'autenticar' => true,
                'usuario' => [
                    'codigo' => $arUsuario->getCodigoUsuarioPk(),
                    'usuario' => $arUsuario->getUsuario(),
                    'urlImagen' => $arUsuario->getUrlImagen(),
                    'codigoCelda' => $arUsuario->getCodigoCeldaFk(),
                    'codigoPanal' => $arUsuario->getCodigoPanalFk()
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
        if(!$arUsuario) {
            $arUsuario = new Usuario();
            $arUsuario->setUsuario($usuario);
            $arUsuario->setClave($clave);
            $arUsuario->setCelular($celular);
            $arUsuario->setUrlImagen('https://semantica.sfo3.digitaloceanspaces.com/rodio/perfil/general.png');
            $arUsuario->setPanalRel($em->getReference(Panal::class,'1'));
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
        if($arUsuario) {
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
        if($arUsuario) {
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

    public function apiAsignar($codigoUsuario, $codigoPanal, $celda)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
            if($arPanal) {
                $arCelda = $em->getRepository(Celda::class)->findOneBy(['codigoPanalFk' => $codigoPanal, 'celda' => $celda]);
                if($arCelda) {
                    if(!$arCelda->getUsuarioRel()) {
                        $arCelda->setUsuarioRel($arUsuario);
                        $em->persist($arCelda);
                        $arUsuario->setCeldaRel($arCelda);
                        $arUsuario->setPanalRel($arPanal);
                        $em->persist($arUsuario);
                        $em->flush();
                        return [
                            'error' => false,
                        ];
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "La celda ya esta asignada a otro usuario, comuniquese con la administracion de su panal"
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
                    'errorMensaje' => "El panal no existe"
                ];
            }
        } else {
            return [
                'error' => false,
                'errorMensaje' => "El usuario no existe"
            ];
        }
    }
}