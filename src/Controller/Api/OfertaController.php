<?php


namespace App\Controller\Api;

use App\Entity\Entrega;
use App\Entity\Oferta;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use App\Entity\Visita;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class OfertaController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/oferta/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal'] ?? null;
        $codigoCategoria = $raw['codigoCategoria'] ?? null;
        if ($codigoPanal) {
            return $em->getRepository(Oferta::class)->apiLista($codigoPanal, $codigoCategoria);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/oferta/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal'] ?? null;
        $descripcion = $raw['descripcion'] ?? null;
        $precio = $raw['precio'] ?? null;
        $imagen = $raw['imagen'] ?? null;
        $categoria = $raw['categoria'] ?? null;
        $codigoUsuario = $raw['codigoUsuario'] ?? null;
        if ($codigoPanal && $descripcion && $precio && $categoria && $codigoUsuario) {
            return $em->getRepository(Oferta::class)->apiNuevo($codigoPanal, $descripcion, $precio, $imagen, $categoria, $codigoUsuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

}