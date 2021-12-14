<?php


namespace App\Controller\Api;

use App\Entity\Anotacion;
use App\Entity\Atencion;
use App\Entity\Reserva;
use App\Entity\ReservaItem;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class AtencionController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/atencion/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCelda = $raw['codigoCelda']?? null;
        if($codigoCelda) {
            $respuesta = $em->getRepository(Atencion::class)->apiLista($codigoCelda);
        } else {
            $respuesta = [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/atencion/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario'] ?? null;
        $codigoCelda = $raw['codigoCelda'] ?? null;
        $descripcion = $raw['descripcion'] ?? null;
        if($codigoUsuario && $codigoCelda) {
            return $em->getRepository(Atencion::class)->apiNuevo($codigoUsuario, $codigoCelda, $descripcion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

}