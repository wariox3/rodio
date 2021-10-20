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
                    $mensaje = "El usuario {$arUsuario->getCodigoUsuarioPk()} genero un codigo para vincularse a la celda {$celda} debe proporcionarle este codigo para verificar su autorizacion: {$llave}";
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
                    $arCeldaUsuario = $em->getRepository(CeldaUsuario::class)->findOneBy(['codigoCeldaFk' => $arCelda->getCodigoCeldaPk(), 'codigoUsuarioFk' => $arUsuario->getCodigoUsuarioPk()]);
                    if($arCeldaUsuario) {
                        if(!$arCeldaUsuario->isValidado()) {
                            if($llave == $arCeldaUsuario->getLlave()) {
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

}