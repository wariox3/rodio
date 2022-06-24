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

class CondicionController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/condicion/guia")
     */
    public function guia(Request $request, Cromo $cromo)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoProducto = $raw['codigoProducto']??null;
        $codigoTercero = $raw['codigoTercero']??null;
        $codigoOrigen = $raw['origen']??null;
        $codigoDestino = $raw['destino']??null;
        $codigoPrecio = $raw['codigoPrecio']??null;
        $guiaTipo = $raw['guiaTipo']??null;
        if($codigoUsuario && $codigoProducto && $codigoTercero && $codigoOrigen && $codigoDestino && $codigoPrecio && $guiaTipo) {
            $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
            if($arUsuario) {
                if($arUsuario->getOperadorRel()) {
                    $arOperador = $arUsuario->getOperadorRel();
                    $parametros = [
                        "codigoProducto" => $codigoProducto,
                        "codigoTercero" => $codigoTercero,
                        "origen" => $codigoOrigen,
                        "destino" => $codigoDestino,
                        "codigoPrecio" => $codigoPrecio,
                        "guiaTipo" => $guiaTipo,
                    ];
                    return $cromo->post($arOperador, '/api/transporte/condicion/guia', $parametros);
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