<?php


namespace App\Controller\Api;

use App\Entity\Publicacion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class PublicacionController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/api/publicacion/lista/{codigoUsuario}/{pagina}")
     */
    public function lista(Request $request, PaginatorInterface $paginator, $codigoUsuario, $pagina = 1)
    {
        $em = $this->getDoctrine()->getManager();
        if($codigoUsuario) {
            $respuesta =  $em->getRepository(Publicacion::class)->apiLista($codigoUsuario);
            if($respuesta['error'] == false){
                $arLiquidaciones = $paginator->paginate($respuesta['publicaciones'], $request->query->getInt('page', $pagina), 10);
                $respuesta['publicaciones'] = $arLiquidaciones;
                return $respuesta;
            } else {
                return $respuesta;
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/publicacion/nuevo/v1")
     */
    public function nuevoV1(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $codigoUsuario = $raw['codigoUsuario']?? null;
            $nombreImagen = $raw['imagenNombre']?? null;
            $imagenBase64 = $raw['imagenBase64']?? null;
            $comentario = $raw['comentario']?? null;
            $permiteComentario = $raw['permiteComentario']?? null;
            if($codigoUsuario && $permiteComentario) {
                return $em->getRepository(Publicacion::class)->apiNuevoV1($codigoUsuario, $nombreImagen, $imagenBase64, $comentario, $permiteComentario);
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => 'Faltan parametros para el consumo de la api'];
            }
        } catch (\Exception $e) {
            return [
                'error' => true,
                'errorMensaje' => $e->getMessage()
            ];
        }
    }

    /**
     * @Rest\Post("/api/publicacion/reporte")
     */
    public function reporte(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $codigoUsuario = $raw['codigoUsuario']?? null;
            $tipoReporte = $raw['tipoReporte']?? null;
            $comentario = $raw['comentario']?? null;
            $codigoPublicacion = $raw['codigoPublicacion']?? null;
            if($codigoUsuario) {
                $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
                if($arUsuario) {
                    return $em->getRepository(Publicacion::class)->reporte($arUsuario, $codigoPublicacion, $tipoReporte, $comentario);
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => 'No existe el usuario'];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => 'Faltan parametros para el consumo de la api'];
            }
        } catch (\Exception $e) {
            return [
                'error' => true,
                'errorMensaje' => $e->getMessage()
            ];
        }
    }

    /**
     * @Rest\Post("/api/publicacion/eliminar")
     */
    public function eliminar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPublicacion = $raw['codigoPublicacion']?? null;
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoPublicacion && $codigoUsuario) {
            return $em->getRepository(Publicacion::class)->apiEliminar($codigoPublicacion, $codigoUsuario);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/publicacion/lista")
     */
    public function adminLista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoPanal = $raw['codigoPanal']?? null;
        $estadoAprobado = $raw['estadoAprobado']?? null;
        if($codigoPanal) {
            return $em->getRepository(Publicacion::class)->apiAdminLista($codigoPanal, $estadoAprobado);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/admin/publicacion/aprobar")
     */
    public function adminAprobar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id']?? null;
        if($id) {
            return $em->getRepository(Publicacion::class)->apiAdminAprobar($id);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

}