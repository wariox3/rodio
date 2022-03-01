<?php


namespace App\Controller\Api;

use App\Entity\Chat;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ChatController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/chat/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoOferta = $raw['codigoOferta']?? null;
        if($codigoUsuario && $codigoOferta) {
            return $em->getRepository(Chat::class)->apiNuevo($codigoUsuario, $codigoOferta);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/chat/consulta")
     */
    public function consulta(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoOferta = $raw['codigoOferta']?? null;
        if($codigoUsuario && $codigoOferta) {
            return $em->getRepository(Chat::class)->apiConsulta($codigoUsuario, $codigoOferta);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

}