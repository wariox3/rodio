<?php


namespace App\Controller\Api;

use App\Entity\Entrega;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use App\Entity\Visita;
use App\Entity\Votacion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class VotacionController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/votacion/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCelda = $raw['codigoCelda']?? null;
        if($codigoCelda) {
            return $em->getRepository(Votacion::class)->apiLista($codigoCelda);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/votacion/votar")
     */
    public function votar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoVotacion = $raw['codigoVotacion']?? null;
        $codigoCelda = $raw['codigoCelda']?? null;
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoVotacionDetalle = $raw['codigoVotacionDetalle']?? null;
        if($codigoCelda && $codigoVotacion && $codigoUsuario && $codigoVotacionDetalle) {
            return $em->getRepository(Votacion::class)->apiVotar($codigoVotacion, $codigoCelda, $codigoUsuario, $codigoVotacionDetalle);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

}