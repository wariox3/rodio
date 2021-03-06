<?php


namespace App\Controller\Api;

use App\Entity\Caso;
use App\Entity\Movimiento;
use App\Entity\Votacion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class MovimientoController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/movimiento/nuevo/pedido/v1")
     */
    public function nuevoPedido(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $detalles = $raw['detalles']?? null;
        $comentario = $raw['comentario']?? null;
        $codigoDireccion = $raw['codigoDireccion']?? null;
        if($codigoUsuario && $detalles && $codigoDireccion) {
            return $em->getRepository(Movimiento::class)->apiNuevoPedido($codigoUsuario, $codigoDireccion, $comentario, $detalles);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/movimiento/lista/pedido/v1")
     */
    public function listaPedido(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoUsuario) {
            return $em->getRepository(Movimiento::class)->apiListaPedido($codigoUsuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

}