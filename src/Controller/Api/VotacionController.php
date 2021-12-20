<?php


namespace App\Controller\Api;

use App\Entity\Celda;
use App\Entity\Entrega;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use App\Entity\Visita;
use App\Entity\Votacion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class VotacionController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/votacion/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCelda = $raw['codigoCelda']?? null;
        if($codigoCelda) {
            return $em->getRepository(Votacion::class)->apiLista($codigoCelda);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/votacion/votar")
     */
    public function votar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoVotacion = $raw['codigoVotacion']?? null;
        $codigoCelda = $raw['codigoCelda']?? null;
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoVotacionDetalle = $raw['codigoVotacionDetalle']?? null;
        if($codigoCelda && $codigoVotacion && $codigoUsuario && $codigoVotacionDetalle) {
            return $em->getRepository(Votacion::class)->apiVotar($codigoVotacion, $codigoCelda, $codigoUsuario, $codigoVotacionDetalle);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/votacion/lista")
     */
    public function adminLista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            return $em->getRepository(Votacion::class)->apiAdminLista($codigoPanal);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/votacion/nuevo")
     */
    public function adminNuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        $codigoPanal = $raw['codigoPanal']?? null;
        $fechaHasta = $raw['fechaHasta']?? null;
        $descripcion = $raw['descripcion']?? null;
        $titulo = $raw['titulo']?? null;
        if($codigoPanal && $fechaHasta && $titulo && $descripcion) {
            return $em->getRepository(Votacion::class)->apiAdminNuevo($codigoPanal, $id, $fechaHasta, $titulo, $descripcion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/votacion/detalle")
     */
    public function adminDetalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoVotacion = $raw['codigoVotacion']?? null;
        if($codigoVotacion) {
            return $em->getRepository(Votacion::class)->apiAdminDetalle($codigoVotacion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/admin/votacion/detallenuevo")
     */
    public function adminDetalleNuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        $descripcion = $raw['descripcion']?? null;
        if($id && $descripcion) {
            return $em->getRepository(Votacion::class)->apiAdminDetalleNuevo($id, $descripcion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/votacion/detalleeliminar")
     */
    public function adminDetalleEliminar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        if($id) {
            return $em->getRepository(Votacion::class)->apiAdminDetalleEliminar($id);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/votacion/publicar")
     */
    public function adminPublicar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoVotacion = $raw['codigoVotacion']?? null;
        if($codigoVotacion) {
            return $em->getRepository(Votacion::class)->apiAdminPublicar($codigoVotacion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }
}