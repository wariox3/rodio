<?php


namespace App\Controller\Api;

use App\Entity\Caso;
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
        $descripcion = $raw['descripcion']?? null;
        if($codigoUsuario && $descripcion && $tipo) {
            return $em->getRepository(Caso::class)->apiNuevo($tipo, $codigoUsuario, $descripcion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/caso/lista/v1")
     */
    public function listaV1(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoPanal && $codigoUsuario) {
            return $em->getRepository(Caso::class)->apiLista($codigoPanal, $codigoUsuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/caso/detalle/v1")
     */
    public function detalleV1(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCaso = $raw['codigoCaso']?? null;
        if($codigoCaso) {
            return $em->getRepository(Caso::class)->apiDetalle($codigoCaso);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/caso/detalle/nuevo/v1")
     */
    public function detalleNuevoV1(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoCaso = $raw['codigoCaso']?? null;
        $comentario = $raw['comentario']?? null;
        if($codigoCaso && $comentario && $codigoUsuario) {
            return $em->getRepository(Caso::class)->apiDetalleNuevo($codigoCaso, $codigoUsuario, $comentario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
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
     * @Rest\Post("/api/admin/caso/nuevo")
     */
    public function adminNuevo(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $codigoPanal = $raw['codigoPanal']?? null;
            $tipo = $raw['tipo']?? null;
            $descripcion = $raw['descripcion']?? null;
            if($descripcion && $tipo && $codigoPanal) {
                return $em->getRepository(Caso::class)->apiAdminNuevo($codigoPanal, $tipo, $descripcion);
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => 'Faltan parametros para el consumo de la api'
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => true,
                'errorMensaje' => $e->getMessage()
            ];
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
     * @Rest\Post("/api/admin/caso/cerrar")
     */
    public function adminCerrar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCaso = $raw['codigoCaso']?? null;
        if($codigoCaso) {
            return $em->getRepository(Caso::class)->apiAdminCerrar($codigoCaso);
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