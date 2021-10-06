<?php


namespace App\Controller\Api;

use App\Entity\Entrega;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use App\Entity\Visita;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class VisitaController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/visita/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoCelda = $raw['codigoCelda']?? null;
        if($codigoCelda) {
            return $em->getRepository(Visita::class)->apiLista($codigoCelda);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/visita/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        $celda = $raw['celda']?? null;
        $codigoCelda = $raw['codigoCelda']?? null;
        $numeroIdentificacion = $raw['numeroIdentificacion']?? null;
        $nombre = $raw['nombre']?? null;
        $placa = $raw['placa']?? null;
        if($codigoPanal && ($celda || $codigoCelda)) {
            return $em->getRepository(Visita::class)->apiNuevo($codigoPanal, $codigoCelda, $celda, $numeroIdentificacion, $nombre, $placa);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/visita/pendiente")
     */
    public function pendiente(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        $celda = $raw['celda']?? null;
        $estadoAutorizado = $raw['estadoAutorizado']?? null;
        if($codigoPanal) {
            return $em->getRepository(Visita::class)->apiPendiente($codigoPanal, $celda, $estadoAutorizado);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/visita/autorizar")
     */
    public function autorizar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoVisita = $raw['codigoVisita']?? null;
        $autorizar = $raw['autorizar']?? null;
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoVisita && $autorizar && $codigoUsuario) {
            return $em->getRepository(Visita::class)->apiAutorizar($codigoVisita, $autorizar, $codigoUsuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

}