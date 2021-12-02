<?php


namespace App\Controller\Api;

use App\Entity\Anotacion;
use App\Entity\Evento;
use App\Entity\Reserva;
use App\Entity\ReservaItem;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class EventoController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/evento/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPuesto = $raw['codigoPuesto']?? null;
        if($codigoPuesto) {
            $respuesta = $em->getRepository(Evento::class)->apiLista($codigoPuesto);
        } else {
            $respuesta = [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/evento/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoTipo = $raw['codigoTipo']?? null;
        $codigoEfecto = $raw['codigoEfecto']?? null;
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoPuesto = $raw['codigoPuesto']?? null;
        $comentario = $raw['comentario']?? null;
        $arrArchivos = $raw['archivos']?? null;
        if($codigoUsuario && $codigoPuesto && $codigoTipo && $codigoEfecto) {
            return $em->getRepository(Evento::class)->apiNuevo($codigoTipo, $codigoEfecto, $codigoUsuario, $codigoPuesto, $comentario, $arrArchivos);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }


}