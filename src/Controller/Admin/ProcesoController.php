<?php


namespace App\Controller\Admin;

use App\Entity\Celda;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ProcesoController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/admin/proceso/generarllave")
     */
    public function generarLlave(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            $respuesta = $em->getRepository(Celda::class)->asignarLlave($codigoPanal);
        } else {
            $respuesta = [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

}