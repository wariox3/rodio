<?php


namespace App\Controller\Api;

use App\Entity\Ciudad;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class CiudadController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/ciudad/buscar")
     */
    public function buscar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $nombre = $raw['nombre']?? null;
        return $em->getRepository(Ciudad::class)->apiBuscar($nombre);

    }


}