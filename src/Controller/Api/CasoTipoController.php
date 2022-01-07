<?php


namespace App\Controller\Api;

use App\Entity\Caso;
use App\Entity\CasoTipo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class CasoTipoController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/casotipo/buscar")
     */
    public function buscar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $nombre = $raw['nombre']?? null;
        return $em->getRepository(CasoTipo::class)->apiBuscar($nombre);

    }

}