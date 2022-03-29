<?php


namespace App\Controller\Api;

use App\Entity\Anotacion;
use App\Entity\Reserva;
use App\Entity\ReservaItem;
use App\Entity\Viaje;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ViajeController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/viaje/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoOperador = $raw['codigoOperador']?? null;
        $ciudadOrigen = $raw['codigoCiudadOrigen']?? null;
        $ciudadDestino = $raw['codigoCiudadDestino']?? null;
        $fechaCargue = $raw['fechaCargue']?? null;
        $flete = $raw['flete']?? null;
        $cantidadClientes = $raw['cantidadClientes']?? null;
        $comentario = $raw['comentario']?? null;
        $peso = $raw['peso']?? null;
        $volumen = $raw['volumen']?? null;
        if($codigoOperador && $ciudadOrigen && $ciudadDestino && $fechaCargue && $flete && $cantidadClientes && $peso && $volumen) {
            return $em->getRepository(Viaje::class)->apiNuevo($codigoOperador, $ciudadOrigen, $ciudadDestino, $fechaCargue, $flete, $cantidadClientes, $peso, $volumen, $comentario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }

    }

    /**
     * @Rest\Post("/api/viaje/lista/cliente")
     */
    public function listaCliente(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        return $em->getRepository(Viaje::class)->apiListaCliente();
    }

    /**
     * @Rest\Post("/api/viaje/lista/proveedor")
     */
    public function listaProveedor(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        return [
            'error' => true,
            'errorMensaje' => 'Faltan parametros para el consumo de la api'];;
    }

}