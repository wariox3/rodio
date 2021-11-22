<?php


namespace App\Controller\Api;

use App\Entity\Entrega;
use App\Entity\Publicacion;
use App\Entity\Reserva;
use App\Entity\ReservaItem;
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

    /**
     * @Rest\Post("/api/reserva/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCelda = $raw['codigoCelda']?? null;
        $codigoItem = $raw['codigoItem']?? null;
        $fecha = $raw['fecha']?? null;
        if($codigoCelda && $codigoItem && $fecha) {
            return $em->getRepository(Reserva::class)->apiNuevo($codigoCelda, $codigoItem, $fecha);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/reserva/listaitem")
     */
    public function listaItem(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            $respuesta = $em->getRepository(ReservaItem::class)->apiLista($codigoPanal);
        } else {
            $respuesta = [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/reserva/reserva")
     */
    public function reserva(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoItem = $raw['codigoItem']?? null;
        $anio = $raw['anio']?? null;
        $mes = $raw['mes']?? null;
        if($codigoItem && $anio && $mes) {
            $respuesta = $em->getRepository(Reserva::class)->apiReserva($codigoItem, $anio, $mes);
        } else {
            $respuesta = [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

}