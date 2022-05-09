<?php


namespace App\Controller\Api;

use App\Entity\Caso;
use App\Entity\Despacho;
use App\Entity\Guia;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class GuiaController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/guia/ingreso")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoGuia = $raw['codigoGuia']?? null;
        if($codigoUsuario && $codigoGuia) {
            return $em->getRepository(Guia::class)->apiIngreso($codigoUsuario, $codigoGuia);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

}