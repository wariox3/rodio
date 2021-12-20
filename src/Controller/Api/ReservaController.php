<?php


namespace App\Controller\Api;

use App\Entity\Entrega;
use App\Entity\Publicacion;
use App\Entity\Reserva;
use App\Entity\ReservaDetalle;
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
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            $respuesta = $em->getRepository(Reserva::class)->apiLista($codigoPanal);
        } else {
            $respuesta = [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/reserva/detallelista")
     */
    public function detalleLista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCelda = $raw['codigoCelda']?? null;
        if($codigoCelda) {
            $respuesta = $em->getRepository(ReservaDetalle::class)->apiLista($codigoCelda);
        } else {
            $respuesta = [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/reserva/detallenuevo")
     */
    public function detalleNuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCelda = $raw['codigoCelda']?? null;
        $codigoReserva = $raw['codigoReserva']?? null;
        $fecha = $raw['fecha']?? null;
        if($codigoCelda && $codigoReserva && $fecha) {
            return $em->getRepository(ReservaDetalle::class)->apiNuevo($codigoCelda, $codigoReserva, $fecha);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/reserva/reserva")
     */
    public function reserva(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoReserva = $raw['codigoReserva']?? null;
        $anio = $raw['anio']?? null;
        $mes = $raw['mes']?? null;
        if($codigoReserva && $anio && $mes) {
            $respuesta = $em->getRepository(ReservaDetalle::class)->apiReserva($codigoReserva, $anio, $mes);
        } else {
            $respuesta = [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/admin/reserva/lista")
     */
    public function adminLista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            return $em->getRepository(Reserva::class)->apiAdminLista($codigoPanal);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/reserva/nuevo")
     */
    public function adminNuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        $codigoPanal = $raw['codigoPanal']?? null;
        $nombre = $raw['nombre']?? null;
        $descripcion = $raw['descripcion']?? null;
        if($codigoPanal && $nombre) {
            return $em->getRepository(Reserva::class)->apiAdminNuevo($codigoPanal, $id, $nombre, $descripcion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/reserva/detalle")
     */
    public function adminDetalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoReserva = $raw['codigoReserva']?? null;
        if($codigoReserva) {
            return $em->getRepository(Reserva::class)->apiAdminDetalle($codigoReserva);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

}