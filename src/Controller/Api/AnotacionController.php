<?php


namespace App\Controller\Api;

use App\Entity\Anotacion;
use App\Entity\Reserva;
use App\Entity\ReservaItem;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class AnotacionController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/anotacion/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPuesto = $raw['codigoPuesto']?? null;
        if($codigoPuesto) {
            $respuesta = $em->getRepository(Anotacion::class)->apiLista($codigoPuesto);
        } else {
            $respuesta = [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/anotacion/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoPuesto = $raw['codigoPuesto']?? null;
        $comentario = $raw['comentario']?? null;
        $arrArchivos = $raw['archivos']?? null;
        $tipo = $raw['tipo']?? null;
        if($codigoUsuario && $codigoPuesto) {
            return $em->getRepository(Anotacion::class)->apiNuevo($codigoUsuario, $codigoPuesto, $comentario, $tipo, $arrArchivos);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/anotacion/detalle")
     */
    public function detalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoAnotacion = $raw['codigoAnotacion']?? null;
        if($codigoAnotacion) {
            $respuesta = $em->getRepository(Anotacion::class)->apiDetalle($codigoAnotacion);
        } else {
            $respuesta = [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

}