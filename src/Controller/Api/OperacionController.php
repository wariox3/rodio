<?php


namespace App\Controller\Api;

use App\Entity\Celda;
use App\Entity\Ciudad;
use App\Entity\Operador;
use App\Entity\OperadorConfiguracion;
use App\Entity\Panal;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use App\Utilidades\Cromo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class OperacionController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/operacion/origen")
     */
    public function origen(Request $request, Cromo $cromo)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoOperacion = $raw['codigoOperacion'] ?? null;
        if ($codigoUsuario && $codigoOperacion) {
            $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
            if($arUsuario) {
                if($arUsuario->getOperadorRel()) {
                    $arOperador = $arUsuario->getOperadorRel();
                    $parametros = [
                        "operacion" => $codigoOperacion,
                    ];
                    return $cromo->post($arOperador, '/api/transporte/operacion/origen', $parametros);
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
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }

    }

}