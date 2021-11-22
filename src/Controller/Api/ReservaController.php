<?php


namespace App\Controller\Api;

use App\Entity\Entrega;
use App\Entity\Publicacion;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Entity\Visita;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ReservaController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/reserva/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCelda = $raw['codigoCelda']?? null;
        if($codigoCelda) {
            $respuesta = $em->getRepository(Reserva::class)->apiLista($codigoCelda);
        } else {
            $respuesta = [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }


}