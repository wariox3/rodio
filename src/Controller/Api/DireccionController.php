<?php


namespace App\Controller\Api;

use App\Entity\Caso;
use App\Entity\Direccion;
use App\Entity\Movimiento;
use App\Entity\Votacion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class DireccionController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/direccion/lista/usuario/v1")
     */
    public function listaUsuario(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoUsuario) {
            return $em->getRepository(Direccion::class)->apiListaUsuario($codigoUsuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/direccion/actualizar/v1")
     */
    public function actualizar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoDireccion = $raw['codigoDireccion']?? null;
        $nombre = $raw['nombre']?? null;
        $celda = $raw['celda']?? null;
        $celular = $raw['celular']?? null;
        $correo = $raw['correo']?? null;
        if($codigoDireccion && $nombre && $celda && $celular && $correo) {
            return $em->getRepository(Direccion::class)->apiActualizar($codigoDireccion, $nombre, $celda, $celular, $correo);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/direccion/consulta/v1")
     */
    public function consulta(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoDireccion = $raw['codigoDireccion']?? null;
        if($codigoDireccion) {
            return $em->getRepository(Direccion::class)->apiConsulta($codigoDireccion);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

}