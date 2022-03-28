<?php


namespace App\Controller\Api;

use App\Entity\Celda;
use App\Entity\Ciudad;
use App\Entity\Cupon;
use App\Entity\Panal;
use App\Entity\Publicacion;
use App\Entity\Transaccion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class TransaccionController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/transaccion/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $tipo = $raw['tipo']?? null;
        $valor = $raw['valor']?? null;
        if($codigoUsuario && $tipo && $valor) {
            return $em->getRepository(Transaccion::class)->apiNuevo($codigoUsuario, $tipo, $valor);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }

    }

}