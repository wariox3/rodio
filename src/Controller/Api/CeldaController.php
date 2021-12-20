<?php


namespace App\Controller\Api;

use App\Entity\Celda;
use App\Entity\CeldaUsuario;
use App\Entity\Ciudad;
use App\Entity\Panal;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class CeldaController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/celda/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            return $em->getRepository(Celda::class)->apiLista($codigoPanal);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/celda/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        $codigoPanal = $raw['codigoPanal']?? null;
        $celda = $raw['celda']?? null;
        $responsable = $raw['responsable']?? null;
        $correo = $raw['correo']?? null;
        $celular = $raw['celular']?? null;
        if($codigoPanal && $celda && $responsable && $correo && $celular) {
            return $em->getRepository(Celda::class)->apiNuevo($codigoPanal, $id, $celda, $responsable, $correo, $celular);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/celda/detalle")
     */
    public function detalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCelda = $raw['codigoCelda']?? null;
        if($codigoCelda) {
            return $em->getRepository(Celda::class)->apiDetalle($codigoCelda);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/celda/llave")
     */
    public function llave(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoPanal = $raw['codigoPanal']?? null;
        $celda = $raw['celda']?? null;
        if($codigoUsuario && $codigoPanal && $celda) {
            return $em->getRepository(Celda::class)->apiLlave($codigoUsuario, $codigoPanal, $celda);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/celda/asignar")
     */
    public function asignar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoPanal = $raw['codigoPanal']?? null;
        $celda = $raw['celda']?? null;
        $llave = $raw['llave']?? null;
        if($codigoUsuario && $codigoPanal && $celda && $llave) {
            return $em->getRepository(Celda::class)->apiAsignarCelda($codigoUsuario, $codigoPanal, $celda, $llave);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

}