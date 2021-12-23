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

    public function apiLista($codigoUsuario, $pagina = 0)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            if($arUsuario->getPanalRel()) {
                $queryBuilder = $em->createQueryBuilder()->from(Publicacion::class, 'p')
                    ->select('p.codigoPublicacionPk')
                    ->addSelect('p.fecha')
                    ->addSelect('p.comentario')
                    ->addSelect('p.urlImagen')
                    ->addSelect('p.reacciones')
                    ->addSelect('p.comentarios')
                    ->addSelect('u.urlImagen as usuarioUrlImagen')
                    ->addSelect('u.usuario as usuario')
                    ->leftJoin('p.celdaRel', 'c')
                    ->leftJoin('p.usuarioRel', 'u')
                    ->where("c.codigoPanalFk = {$arUsuario->getCodigoPanalFk()}")
                    ->orderBy('p.fecha', 'DESC')
                    ->setFirstResult(10 * $pagina)
                    ->setMaxResults(10);
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

    public function apiLista2($codigoUsuario)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            if($arUsuario->getPanalRel()) {
                $queryBuilder = $em->createQueryBuilder()->from(Publicacion::class, 'p')
                    ->select('p.codigoPublicacionPk')
                    ->addSelect('p.fecha')
                    ->addSelect('p.comentario')
                    ->addSelect('p.urlImagen')
                    ->addSelect('p.reacciones')
                    ->addSelect('p.comentarios')
                    ->addSelect('u.urlImagen as usuarioUrlImagen')
                    ->addSelect('u.usuario as usuario')
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

    public function apiNuevo($arUsuario, $nombreImagen, $imagenBase64, $comentario) {
        $em = $this->getEntityManager();
        $arPublicacion = new Publicacion();
        $arPublicacion->setUsuarioRel($arUsuario);
        $arPublicacion->setPanalRel($arUsuario->getPanalRel());
        $arPublicacion->setComentario($comentario);
        $arPublicacion->setFecha(new \DateTime('now'));
        $arPublicacion->setEstadoAprobado($arUsuario->getPanalRel()->isPublicacionAprobar());
        $arPublicacion->setUrlImagen($this->space->subir('publicacion', $nombreImagen, $imagenBase64));
        $em->persist($arPublicacion);
        $em->flush();
        return [
            'error' => false,
            'codigoPublicacion' => $arPublicacion->getCodigoPublicacionPk()
        ];
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
}