<?php


namespace App\Controller\Api;

use App\Entity\Caso;
use App\Entity\Votacion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class CasoController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/caso/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $tipo = $raw['tipo']?? null;
        $comentario = $raw['comentario']?? null;
        if($codigoUsuario && $comentario && $tipo) {
            return $em->getRepository(Caso::class)->apiNuevo($tipo, $codigoUsuario, $comentario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/caso/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            return $em->getRepository(Caso::class)->apiLista($codigoPanal);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/admin/caso/lista")
     */
    public function adminLista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            return $em->getRepository(Caso::class)->apiAdminLista($codigoPanal);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/admin/caso/detalle")
     */
    public function adminDetalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCaso = $raw['codigoCaso']?? null;
        if($codigoCaso) {
            return $em->getRepository(Caso::class)->apiAdminDetalle($codigoCaso);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/admin/caso/atender")
     */
    public function adminAtender(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCaso = $raw['codigoCaso']?? null;
        if($codigoCaso) {
            return $em->getRepository(Caso::class)->apiAdminAtender($codigoCaso);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/admin/caso/respuestanuevo")
     */
    public function adminRespuestaNuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        $respuesta = $raw['respuesta']?? null;
        if($id && $respuesta) {
            return $em->getRepository(Caso::class)->apiAdminRespuestaNuevo($id, $respuesta);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

}