<?php


namespace App\Controller\Api;

use App\Entity\Reunion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ReunionController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/admin/reunion/lista")
     */
    public function adminLista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            return $em->getRepository(Reunion::class)->apiAdminLista($codigoPanal);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/reunion/nuevo")
     */
    public function adminNuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        $codigoPanal = $raw['codigoPanal']?? null;
        $nombre = $raw['nombre']?? null;
        if($codigoPanal && $nombre) {
            return $em->getRepository(Reunion::class)->apiAdminNuevo($codigoPanal, $id, $nombre);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/reunion/detalle")
     */
    public function adminDetalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoReunion = $raw['codigoReunion']?? null;
        if($codigoReunion) {
            return $em->getRepository(Reunion::class)->apiAdminDetalle($codigoReunion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/admin/reunion/detallenuevo")
     */
    public function adminDetalleNuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        $celda = $raw['celda']?? null;
        $apoderado = $raw['apoderado']?? null;
        if($id && $celda) {
            return $em->getRepository(Reunion::class)->apiAdminDetalleNuevo($id, $celda, $apoderado);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/reunion/detalleeliminar")
     */
    public function adminDetalleEliminar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        if($id) {
            return $em->getRepository(Reunion::class)->apiAdminDetalleEliminar($id);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/reunion/cerrar")
     */
    public function adminCerrar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoReunion = $raw['codigoReunion']?? null;
        if($codigoReunion) {
            return $em->getRepository(Reunion::class)->apiAdminCerrar($codigoReunion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/admin/reunion/combo")
     */
    public function adminListaCombo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            return $em->getRepository(Reunion::class)->apiAdminListaCombo($codigoPanal);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }
}