<?php


namespace App\Controller\Api;

use App\Entity\AnotacionTipo;
use App\Entity\Efecto;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class EfectoController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/efecto/buscar")
     */
    public function buscar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $nombre = $raw['nombre']?? null;
        return $em->getRepository(Efecto::class)->apiBuscar($nombre);

    }


}