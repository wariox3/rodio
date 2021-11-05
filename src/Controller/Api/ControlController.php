<?php

namespace App\Controller\Api;

use App\Entity\Control;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ControlController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/control/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoPuesto = $raw['codigoPuesto']?? null;
        $fechaControl = $raw['fechaControl']?? null;


        if($codigoUsuario && $codigoPuesto && $fechaControl) {
            return $em->getRepository(Control::class)->apiNuevo($codigoUsuario, $codigoPuesto, $fechaControl);
        }else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/control/reportar")
     */
    public function reportar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $estadoRepote = $raw['estadoRepote']?? null;
        $codigoControl = $raw['codigoControl']?? null;

        if($codigoUsuario && $estadoRepote && $codigoControl) {
            return $em->getRepository(Control::class)->apiReportar($codigoUsuario, $estadoRepote, $codigoControl);
        }else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/control/pendiente")
     */
    public function pendiente(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoUsuario) {
            return $em->getRepository(Control::class)->apiPendiente($codigoUsuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }
}