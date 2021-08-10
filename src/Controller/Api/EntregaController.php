<?php


namespace App\Controller\Api;

use App\Entity\Entrega;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class EntregaController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/entrega/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoUsuario) {
            $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
            if($arUsuario) {
                $respuesta = $em->getRepository(Entrega::class)->apiLista($codigoUsuario);
            } else {
                $respuesta = ['error' => true, 'mensajeError' => 'No existe el usuario'];
            }
        } else {
            $respuesta = ['error' => true, 'mensajeError' => 'Faltan parametros para el consumo de la api'];
        }
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/entrega/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        $celda = $raw['celda']?? null;
        $tipo = $raw['tipo']?? null;
        if($codigoPanal && $celda && $tipo) {
            return $em->getRepository(Entrega::class)->apiNuevo($codigoPanal, $celda, $tipo);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

}