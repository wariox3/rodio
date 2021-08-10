<?php


namespace App\Controller\Api;

use App\Entity\Publicacion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class PublicacionController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/publicacion/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $pagina = $raw['pagina']?? 0;
        if($codigoUsuario) {
            return $em->getRepository(Publicacion::class)->apiLista($codigoUsuario, $pagina);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/publicacion/nuevo")
     */
    public function nuevo(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $codigoUsuario = $raw['codigoUsuario']?? null;
            $nombreImagen = $raw['imagenNombre']?? null;
            $imagenBase64 = $raw['imagenBase64']?? null;
            $comentario = $raw['comentario']?? null;
            if($codigoUsuario) {
                $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
                if($arUsuario) {
                    return $em->getRepository(Publicacion::class)->apiNuevo($arUsuario, $nombreImagen, $imagenBase64, $comentario);
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

}