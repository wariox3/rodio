<?php


namespace App\Controller\Api;

use App\Entity\Comentario;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ComentarioController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/comentario/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPublicacion = $raw['codigoPublicacion']?? null;
        if($codigoPublicacion) {
            $respuesta = $em->getRepository(Comentario::class)->apiLista($codigoPublicacion);
        } else {
            $respuesta = ['error' => true, 'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/comentario/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoPublicacion = $raw['codigoPublicacion']?? null;
        $comentario = $raw['comentario']?? null;
        if($codigoUsuario && $codigoPublicacion && $comentario) {
            return $em->getRepository(Comentario::class)->apiNuevo($codigoUsuario, $codigoPublicacion, $comentario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

}