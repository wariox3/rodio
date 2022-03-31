<?php


namespace App\Controller\Api;

use App\Entity\Publicacion;
use App\Entity\Usuario;
use App\Utilidades\SpaceDO;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/usuario/autenticar")
     */
    public function autenticar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $usuario = $raw['usuario']?? null;
        $clave = $raw['clave']?? null;
        $token = $raw['tokenFirebase']?? null;
        if($usuario && $clave) {
            return $em->getRepository(Usuario::class)->apiAutenticar($usuario, $clave, $token);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/usuario/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $usuario = $raw['usuario']?? null;
        $clave = $raw['clave']?? null;
        $celular = $raw['celular']?? null;
        if($usuario && $clave && $celular) {
            return $em->getRepository(Usuario::class)->apiNuevo(strtolower($usuario), $clave, $celular);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/usuario/asignarpanal")
     */
    public function asignarPanal(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoPanal = $raw['codigoPanal']?? null;
        $codigoCiudad = $raw['codigoCiudad']?? null;
        if($codigoUsuario && $codigoPanal && $codigoCiudad) {
            return $em->getRepository(Usuario::class)->apiAsignarPanal($codigoUsuario, $codigoPanal, $codigoCiudad);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/usuario/desvincular")
     */
    public function desvincular(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoUsuario) {
            return $em->getRepository(Usuario::class)->apiDesvincular($codigoUsuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/usuario/cambiarimagen")
     */
    public function cambiarImagen(Request $request, SpaceDO $spaceDO)
    {
        //https://github.com/SociallyDev/Spaces-API
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $imagenBase64 = $raw['imagenBase64']?? null;
        if($codigoUsuario && $imagenBase64) {
            $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
            if($arUsuario) {
                $archivo = $spaceDO->subir('perfil', $imagenBase64);
                $arUsuario->setUrlImagen($archivo['url']);
                $em->persist($arUsuario);
                $em->flush();
                return [
                    'error' => false,
                    'urlImagen' => $_ENV['ALMACENAMIENTO_URL'].$archivo['url']
                ];
            } else {
                return [
                    'error' => true,
                    'erroMensaje' => 'No existe el usuario'
                ];
            }
        } else {
            return [
                'error' => true,
                'erroMensaje' => 'Faltan datos para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/usuario/recuperarclave")
     */
    public function recuperarClave(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $usuario = $raw['usuario']?? null;
        if($usuario) {
            return $em->getRepository(Usuario::class)->apiRecuperarClave($usuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/usuario/cambiarclave")
     */
    public function cambiarClave(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $claveNueva = $raw['claveNueva']?? null;
        if($codigoUsuario && $claveNueva) {
            return $em->getRepository(Usuario::class)->apiCambiarClave($codigoUsuario, $claveNueva);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/usuario/detalle")
     */
    public function detalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $usuario = $raw['codigoUsuario']?? null;
        if($usuario) {
            return $em->getRepository(Usuario::class)->apiDetalle($usuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/usuario/editarinformacion")
     */
    public function editarInformacion(Request  $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $nombre = $raw['nombre']?? null;
        $celular = $raw['celular']?? null;
        if($codigoUsuario && $nombre && $celular) {
            return $em->getRepository(Usuario::class)->apiEditarInformacion($codigoUsuario, $nombre, $celular);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

}