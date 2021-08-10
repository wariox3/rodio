<?php


namespace App\Repository;

use App\Entity\Publicacion;
use App\Entity\Reaccion;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReaccionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reaccion::class);
    }

    public function apiNuevo($codigoUsuario, $codigoPublicacion) {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arPublicacion = $em->getRepository(Publicacion::class)->find($codigoPublicacion);
            if($arPublicacion) {
                $arReaccion = new Reaccion();
                $arReaccion->setUsuarioRel($arUsuario);
                $arReaccion->setPublicacionRel($arPublicacion);
                $arReaccion->setFecha(new \DateTime('now'));
                $em->persist($arReaccion);
                $arPublicacion->setReacciones($arPublicacion->getReacciones() + 1);
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