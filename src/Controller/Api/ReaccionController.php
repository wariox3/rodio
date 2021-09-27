<?php


namespace App\Controller\Api;

use App\Entity\Comentario;
use App\Entity\Publicacion;
use App\Entity\Reaccion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ReaccionController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/reaccion/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoPublicacion = $raw['codigoPublicacion']?? null;
        if($codigoUsuario && $codigoPublicacion) {
            return $em->getRepository(Reaccion::class)->apiNuevo($codigoUsuario, $codigoPublicacion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/reaccion/nomegusta")
     */
    public function noMeGusta(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoPublicacion = $raw['codigoPublicacion']?? null;
        if($codigoUsuario && $codigoPublicacion) {
            return $em->getRepository(Reaccion::class)->apiNoMeGusta($codigoUsuario, $codigoPublicacion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

}