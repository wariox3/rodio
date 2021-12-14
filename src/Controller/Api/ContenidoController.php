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

}