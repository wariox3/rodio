<?php


namespace App\Repository;

use App\Entity\Comentario;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ComentarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comentario::class);
    }

    public function apiLista($codigoPublicacion) {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Comentario::class, 'c')
            ->select('c.codigoComentarioPk')
            ->addSelect('c.fecha')
            ->addSelect('c.comentario')
            ->addSelect('c.codigoUsuarioFk')
            ->addSelect('u.urlImagen as usuarioUrlImagen')
            ->addSelect('u.usuario as usuario')
            ->leftJoin('c.usuarioRel', 'u')
            ->where("c.codigoPublicacionFk = {$codigoPublicacion}")
            ->orderBy('c.fecha', 'DESC');
        $arComentarios = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'errorMensaje' => null,
            'comentarios' => $arComentarios
        ];
        return $respuesta;
    }

    public function apiNuevo($codigoUsuario, $codigoPublicacion, $comentario) {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arPublicacion = $em->getRepository(Publicacion::class)->find($codigoPublicacion);
            if($arPublicacion) {
                $arComentario = new Comentario();
                $arComentario->setUsuarioRel($arUsuario);
                $arComentario->setPublicacionRel($arPublicacion);
                $arComentario->setComentario($comentario);
                $arComentario->setFecha(new \DateTime('now'));
                $em->persist($arComentario);
                $arPublicacion->setComentarios($arPublicacion->getComentarios() + 1);
                $em->persist($arPublicacion);
                $em->flush();
                return ['error' => false];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => 'No existe la publicacion'];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'No existe el usuario'];
        }
    }

}