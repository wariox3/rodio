<?php


namespace App\Controller\Api;

use App\Entity\Caso;
use App\Entity\Despacho;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class DespachoController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/despacho/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $operador = $raw['operador']?? null;
        $codigoDespacho = $raw['codigoDespacho']?? null;
        $token = $raw['token']?? null;
        if($codigoUsuario && $operador && $codigoDespacho && $token) {
            return $em->getRepository(Despacho::class)->apiNuevo($codigoUsuario, $operador, $codigoDespacho, $token);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/despacho/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoUsuario) {
            return $em->getRepository(Despacho::class)->apiLista($codigoUsuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }


}