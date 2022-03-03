<?php


namespace App\Repository;

use App\Entity\Contenido;
use App\Entity\Panal;
use App\Utilidades\Firebase;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContenidoRepository extends ServiceEntityRepository
{
    private $firebase;
    private $space;

    public function __construct(ManagerRegistry $registry, Firebase $firebase, SpaceDO $space)
    {
        parent::__construct($registry, Contenido::class);
        $this->firebase = $firebase;
        $this->space = $space;
    }

    public function apiLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Contenido::class, 'c')
            ->select('c.codigoContenidoPk')
            ->addSelect('c.nombre')
            ->addSelect('c.nombreArchivo')
            ->addSelect('c.url')
            ->where("c.codigoPanalFk = {$codigoPanal}");
        $arContenidos = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'contenidos' => $arContenidos
        ];
        return $respuesta;
    }

    public function apiAdminLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Contenido::class, 'c')
            ->select('c.codigoContenidoPk')
            ->addSelect('c.nombre')
            ->addSelect('c.nombreArchivo')
            ->addSelect('c.url')
            ->where("c.codigoPanalFk = {$codigoPanal}")
            ->setMaxResults(20);
        $arContenidos = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'contenidos' => $arContenidos
        ];
        return $respuesta;
    }

    public function apiAdminNuevo($codigoPanal, $id, $nombre, $nombreArchivo, $base64)
    {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if($arPanal) {
            if($id) {
                $arContenido = $em->getRepository(Contenido::class)->find($id);
                if($arContenido) {
                    $arContenido->setNombre($nombre);
                    $em->persist($arContenido);
                    $em->flush();
                    return [
                        'error' => false,
                        'codigoContenido' => $arContenido->getCodigoContenidoPk()
                    ];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "El id de contenido no existe"
                    ];
                }
            } else {
                $arContenido = new Contenido();
                $arContenido->setPanalRel($arPanal);
                $arContenido->setNombre($nombre);
                $arContenido->setNombreArchivo($nombreArchivo);
                $arContenido->setUrl($this->space->subir('contenido', $nombreArchivo, $base64));
                $em->persist($arContenido);
                $em->flush();
                return [
                    'error' => false,
                    'codigoContenido' => $arContenido->getCodigoContenidoPk()
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el panal"
            ];
        }
    }

    public function apiAdminDetalle($codigoContenido)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Contenido::class, 'c')
            ->select('c.codigoContenidoPk')
            ->addSelect('c.nombre')
            ->addSelect('c.nombreArchivo')
            ->where("c.codigoContenidoPk = {$codigoContenido}");
        $arContenido = $queryBuilder->getQuery()->getResult();
        if($arContenido) {
            return [
                'error' => false,
                'contenido' => $arContenido[0]
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'No existe el contenido'
            ];
        }
    }

    public function apiAdminEliminar($codigoContenido)
    {
        $em = $this->getEntityManager();
        $arContenido = $em->getRepository(Contenido::class)->find($codigoContenido);
        if($arContenido) {
            $em->remove($arContenido);
            $em->flush();
            $this->space->eliminar($arContenido->getUrl());
            return [
                'error' => false,
                'codigoContenido' => $arContenido->getCodigoContenidoPk()
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El contenido no existe"
            ];
        }
    }

}