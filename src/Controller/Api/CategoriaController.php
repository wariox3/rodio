<?php

namespace App\Controller\Api;

use App\Entity\Categoria;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class CategoriaController  extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/categoria/lista")
     */
    public function buscar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        return $em->getRepository(Categoria::class)->apliLista();

    }
}