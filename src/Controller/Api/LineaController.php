<?php


namespace App\Controller\Api;

use App\Entity\Entrega;
use App\Entity\Linea;
use App\Entity\Oferta;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use App\Entity\Visita;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class LineaController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/linea/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        return $em->getRepository(Linea::class)->apiLista();
    }


}