<?php


namespace App\Controller\Api;

use App\Entity\Entrega;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use App\Entity\Visita;
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
        $entrega = $raw['entrega']?? null;
        if($codigoPanal && $celda && $tipo) {
            return $em->getRepository(Entrega::class)->apiNuevo($codigoPanal, $celda, $tipo, $entrega);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/entrega/autorizar")
     */
    public function autorizar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoEntrega = $raw['codigoEntrega']?? null;
        $autorizar = $raw['autorizar']?? null;
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoEntrega && $autorizar && $codigoUsuario) {
            return $em->getRepository(Entrega::class)->apiAutorizar($codigoEntrega, $autorizar, $codigoUsuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/entrega/entregar")
     */
    public function entregar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoEntrega = $raw['codigoEntrega']?? null;
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoEntrega && $codigoUsuario) {
            return $em->getRepository(Entrega::class)->apiEntregar($codigoEntrega, $codigoUsuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/entrega/pendiente")
     */
    public function pendiente(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        if($codigoPanal) {
            return $em->getRepository(Entrega::class)->apiPendiente($codigoPanal);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

}