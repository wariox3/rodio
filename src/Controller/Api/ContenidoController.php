<?php


namespace App\Controller\Api;

use App\Entity\Contenido;
use App\Entity\Entrega;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use App\Entity\Visita;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ContenidoController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/contenido/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            $respuesta = $em->getRepository(Contenido::class)->apiLista($codigoPanal);
        } else {
            $respuesta = ['error' => true, 'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/admin/contenido/lista")
     */
    public function adminLista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            return $em->getRepository(Contenido::class)->apiAdminLista($codigoPanal);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/contenido/nuevo")
     */
    public function adminNuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        $codigoPanal = $raw['codigoPanal']?? null;
        $nombre = $raw['nombre']?? null;
        $nombreArchivo = $raw['nombreArchivo']?? null;
        $base64 = $raw['base64']?? null;
        if($codigoPanal && $nombre && $nombreArchivo && $base64) {
            return $em->getRepository(Contenido::class)->apiAdminNuevo($codigoPanal, $id, $nombre, $nombreArchivo, $base64);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/contendio/detalle")
     */
    public function adminDetalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoContenido = $raw['codigoContenido']?? null;
        if($codigoContenido) {
            return $em->getRepository(Contenido::class)->apiAdminDetalle($codigoContenido);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/admin/contenido/eliminar")
     */
    public function adminEliminar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        $codigoContenido = $raw['codigoContenido']?? null;
        if($codigoContenido) {
            return $em->getRepository(Contenido::class)->apiAdminEliminar($codigoContenido);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }
}