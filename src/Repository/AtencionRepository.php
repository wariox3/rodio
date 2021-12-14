<?php


namespace App\Repository;

use App\Entity\Anotacion;
use App\Entity\AnotacionTipo;
use App\Entity\Archivo;
use App\Entity\Atencion;
use App\Entity\Celda;
use App\Entity\Usuario;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AtencionRepository extends ServiceEntityRepository
{
    private $space;

    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Atencion::class);
        $this->space = $space;
    }

    public function apiLista($codigoCelda)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Atencion::class, 'a')
            ->select('a.codigoAtencionPk')
            ->addSelect('a.fecha')
            ->addSelect('a.descripcion')
            ->addSelect('a.estadoAtendido')
            ->where("a.codigoCeldaFk = {$codigoCelda}");
        $arAtenciones = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'atenciones' => $arAtenciones
        ];
        return $respuesta;
    }


    public function apiNuevo($codigoUsuario, $codigoCelda, $descripcion)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if ($arUsuario) {
            $arCelda = $em->getRepository(Celda::class)->find($codigoCelda);
            if($arCelda) {
                $arAtencion = new Atencion();
                $arAtencion->setUsuarioRel($arUsuario);
                $arAtencion->setCeldaRel($arCelda);
                $arAtencion->setFecha(new \DateTime('now'));
                $arAtencion->setDescripcion($descripcion);
                $em->persist($arAtencion);
                $em->flush();
                return [
                    'error' => false,
                    'codigoAtencion' => $arAtencion->getCodigoAtencionPk()
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe la celda"
                ];
            }

        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }
}