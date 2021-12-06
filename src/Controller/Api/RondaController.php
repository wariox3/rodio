<?php


namespace App\Controller\Api;

use App\Entity\Entrega;
use App\Entity\Publicacion;
use App\Entity\Ronda;
use App\Entity\Usuario;
use App\Entity\Visita;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class RondaController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/ronda/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPuesto = $raw['codigoPuesto']?? null;
        $codigoOperador = $raw['codigoOperador']?? null;
        if($codigoPuesto && $codigoOperador) {
            return $em->getRepository(Ronda::class)->apiLista($codigoOperador, $codigoPuesto);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }



}