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