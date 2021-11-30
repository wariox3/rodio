<?php


namespace App\Controller\Api;

use App\Entity\AnotacionTipo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class AnotacionTipoController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/anotaciontipo/buscar")
     */
    public function buscar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $nombre = $raw['nombre']?? null;
        return $em->getRepository(AnotacionTipo::class)->apiBuscar($nombre);

    }


}