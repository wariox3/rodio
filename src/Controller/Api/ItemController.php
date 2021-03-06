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
        $orden = $raw['orden']?? null;
        if($linea) {
            return $em->getRepository(Item::class)->apiLista($linea, $orden);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/item/buscaritem")
     */
    public function buscarItem(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $itemNombre = $raw['itemNombre']?? null;
        if($itemNombre) {
            return $em->getRepository(Item::class)->apiBuscarItem($itemNombre);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

}