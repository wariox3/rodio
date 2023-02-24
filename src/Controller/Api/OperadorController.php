<?php


namespace App\Controller\Api;

use App\Entity\Celda;
use App\Entity\Ciudad;
use App\Entity\Operador;
use App\Entity\OperadorConfiguracion;
use App\Entity\Panal;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class OperadorController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/operador/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        return $em->getRepository(Operador::class)->apiLista();
    }

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

    /**
     * @Rest\Post("/api/operador/calidadimagenentrega")
     */
    public function calidadImagenEntrega(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoOperador = $raw['codigoOperador'] ?? null;
        if ($codigoOperador) {
            return $em->getRepository(OperadorConfiguracion::class)->apiCalidadImagenEntrega($codigoOperador);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }

    }

    /**
     * @Rest\Post("/api/operador/datosoperador")
     */
    public function datosOperador(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoOperador = $raw['codigoOperador'] ?? null;
        if ($codigoOperador) {
            return $em->getRepository(Operador::class)->apiDatosOperador($codigoOperador);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/operador/cambiarConfiguracion")
     */
    public function cambiarConfiguracion(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoOperador = $raw['codigoOperador'] ?? null;
        $calidadImagenEntrega = $raw['calidadImagenEntrega'] ?? null;
        $exigeImagenEntrega = $raw['exigeImagenEntrega'] ?? null;
        $exigeFirmaEntrega = $raw['exigeFirmaEntrega'] ?? null;
        if ($codigoOperador) {
            return $em->getRepository(OperadorConfiguracion::class)->apiCambiarConfiguracion($codigoOperador, $calidadImagenEntrega, $exigeImagenEntrega, $exigeFirmaEntrega);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }

    }
}