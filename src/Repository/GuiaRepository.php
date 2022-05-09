<?php


namespace App\Repository;

use App\Entity\Guia;
use App\Entity\Usuario;
use App\Utilidades\Cromo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GuiaRepository extends ServiceEntityRepository
{
    private $cromo;
    public function __construct(ManagerRegistry $registry, Cromo $cromo)
    {
        parent::__construct($registry, Guia::class);
        $this->cromo = $cromo;
    }

    public function apiIngreso($codigoUsuario, $codigoGuia)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            if($arUsuario->getOperadorRel()) {
                $arOperador = $arUsuario->getOperadorRel();
                $parametros = [
                    "codigoGuia" => $codigoGuia,
                    "codigoUsuario" => $codigoUsuario
                ];
                $respuesta = $this->cromo->post($arOperador, '/api/transporte/guia/ingreso', $parametros);
                if($respuesta['error'] == false) {
                    $arGuia = new Guia();
                    $arGuia->setFecha(new \DateTime('now'));
                    $arGuia->setUsuarioRel($arUsuario);
                    $arGuia->setOperadorRel($arOperador);
                    $arGuia->setCodigoGuia($codigoGuia);
                    $arGuia->setCodigoSeguimientoTipoFk('INGRESO');
                    $em->persist($arGuia);
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
                    'errorMensaje' => "El usuario no tiene un operador asignado"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }
}