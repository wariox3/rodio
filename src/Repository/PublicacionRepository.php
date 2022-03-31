<?php


namespace App\Repository;

use App\Entity\Publicacion;
use App\Entity\Reporte;
use App\Entity\Usuario;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PublicacionRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Publicacion::class);
        $this->space = $space;
    }

    public function apiLista($codigoUsuario)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            if($arUsuario->getPanalRel()) {
                $queryBuilder = $em->createQueryBuilder()->from(Publicacion::class, 'p')
                    ->select('p.codigoPublicacionPk')
                    ->addSelect('p.fecha')
                    ->addSelect('p.comentario')
                    ->addSelect("CONCAT('{$_ENV['ALMACENAMIENTO_URL']}', p.urlImagen) as urlImagen")
                    ->addSelect('p.reacciones')
                    ->addSelect('p.comentarios')
                    ->addSelect('p.permiteComentario')
                    ->addSelect('p.codigoUsuarioFk')
                    ->addSelect("CONCAT('{$_ENV['ALMACENAMIENTO_URL']}', u.urlImagen) as usuarioUrlImagen")
                    ->addSelect('u.usuario as usuario')
                    ->addSelect('u.nombre as usuarioNombre')
                    ->leftJoin('p.usuarioRel', 'u')
                    ->where("p.codigoPanalFk = {$arUsuario->getCodigoPanalFk()}")
                    ->andWhere("p.estadoAprobado = 1")
                    ->orderBy('p.fecha', 'DESC');
                $arPublicaciones = $queryBuilder->getQuery()->getResult();
                return [
                    'error' => false,
                    'publicaciones' => $arPublicaciones
                ];
            }  else {
                return [
                    'error' => true,
                    'errorMensaje' => "El usuario no tiene un panal asignado"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El usuario no existe"
            ];
        }
    }

    public function apiNuevoV1($codigoUsuario, $nombreImagen, $imagenBase64, $comentario, $permiteComentario) {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arPublicacion = new Publicacion();
            $arPublicacion->setUsuarioRel($arUsuario);
            $arPublicacion->setPanalRel($arUsuario->getPanalRel());
            $arPublicacion->setComentario($comentario);
            $arPublicacion->setFecha(new \DateTime('now'));
            $arPublicacion->setEstadoAprobado($arUsuario->getPanalRel()->isPublicacionAprobar());
            $archivo = $this->space->subir('publicacion', $imagenBase64);
            $arPublicacion->setUrlImagen($archivo['url']);
            if($permiteComentario) {
                if($arUsuario->getPanalRel()->isPublicacionPermiteComentario() == false) {
                    $permiteComentario = false;
                }
            }
            $arPublicacion->setPermiteComentario($permiteComentario);
            $em->persist($arPublicacion);
            $em->flush();
            return [
                'error' => false,
                'codigoPublicacion' => $arPublicacion->getCodigoPublicacionPk()
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'No existe el usuario'];
        }
    }

    public function reporte($codigoUsuario, $codigoPublicacion, $tipoReporte, $comentario)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arPublicacion = $em->getRepository(Publicacion::class)->find($codigoPublicacion);
            if($arPublicacion) {
                $arReporte = new Reporte();
                $arReporte->setFecha(new \DateTime('now'));
                $arReporte->setComentario($comentario);
                $arReporte->setTipo($tipoReporte);
                $arReporte->setUsuarioRel(
                    $arUsuario);
                $em->persist($arReporte);
                $em->flush();
                return [
                    'error' => false,
                    'codigoReporte' => $arReporte->getCodigoReportePk()
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => 'No existe la publicación'];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'No existe el usuario'];
        }
    }

    public function apiEliminar($codigoPublicacion, $codigoUsuario)
    {
        $em = $this->getEntityManager();
        $arPublicacion = $em->getRepository(Publicacion::class)->find($codigoPublicacion);
        if($arPublicacion) {
            if($arPublicacion->getCodigoUsuarioFk() == $codigoUsuario) {
                $em->remove($arPublicacion);
                $em->flush();
                $this->space->eliminar($arPublicacion->getRuta());
                return [
                    'error' => false
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "El usuario no puede eliminar esta publicacion"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El contenido no existe"
            ];
        }
    }

    public function apiAdminLista($codigoPanal, $estadoAprobado)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Publicacion::class, 'p')
            ->select('p.codigoPublicacionPk')
            ->addSelect('p.fecha')
            ->addSelect('p.estadoAprobado')
            ->addSelect('p.ruta')
            ->addSelect('p.urlImagen')
            ->addSelect('u.nombre usuarioNombre')
            ->leftJoin('p.usuarioRel', 'u')
            ->where("p.codigoPanalFk = {$codigoPanal}")
            ->orderBy('p.fecha', 'DESC');
        switch ($estadoAprobado) {
            case '0':
                $queryBuilder->andWhere("p.estadoAprobado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("p.estadoAprobado = 1");
                break;
        }
        $arPublicaciones = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'publicaciones' => $arPublicaciones
        ];

    }

    public function apiAdminAprobar($id)
    {
        $em = $this->getEntityManager();
        $arPublicacion = $em->getRepository(Publicacion::class)->find($id);
        if($arPublicacion) {
            $arPublicacion->setEstadoAprobado(1);
            $em->persist($arPublicacion);
            $em->flush();
            return [
                'error' => false
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "La publicacion no existe"
            ];
        }
    }
}