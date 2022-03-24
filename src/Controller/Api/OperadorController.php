<?php


namespace App\Controller\Api;

use App\Entity\Celda;
use App\Entity\Ciudad;
use App\Entity\Operador;
use App\Entity\Panal;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class OperadorController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/operador/conectar")
     */
    public function conectar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoOperador = $raw['codigoOperador'] ?? null;
        if ($codigoOperador) {
            return $em->getRepository(Operador::class)->apiConectar($codigoOperador);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }

    }

}