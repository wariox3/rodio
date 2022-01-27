<?php


namespace App\Controller\Api;

use App\Entity\Entrega;
use App\Entity\Item;
use App\Entity\Oferta;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use App\Entity\Visita;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/item/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $linea = $raw['linea']?? null;
        if($linea) {
            return $em->getRepository(Item::class)->apiLista($linea);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

}