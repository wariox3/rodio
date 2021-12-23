<?php


namespace App\Repository;

use App\Entity\Panal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PanalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panal::class);
    }

    public function apiBuscar($nombre, $codigoCiudad)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Panal::class, 'p')
            ->select('p.codigoPanalPk')
            ->addSelect('p.nombre')
            ->setMaxResults(10);
        if($nombre) {
            $queryBuilder->andWhere("p.nombre like '%{$nombre}%'");
        }
        if($codigoCiudad) {
            $queryBuilder->andWhere("p.codigoCiudadFk =  {$codigoCiudad}");
        }
        $arPanales = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'panales' => $arPanales
        ];
    }

    public function apiAdminLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Panal::class, 'p')
            ->select('p.codigoPanalPk')
            ->addSelect('p.nombre')
            ->addSelect('p.publicacionAprobar')
            ->where("p.codigoPanalPk = {$codigoPanal}");
        $arPanales = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'panales' => $arPanales
        ];

    }

    public function apiAdminDetalle($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Panal::class, 'p')
            ->select('p.codigoPanalPk')
            ->addSelect('p.nombre')
            ->addSelect('p.publicacionAprobar')
            ->where("p.codigoPanalPk = {$codigoPanal}");
        $arPanal = $queryBuilder->getQuery()->getResult();
        if($arPanal) {
            return [
                'error' => false,
                'panal' => $arPanal[0]
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'El panal no existe'
            ];
        }
    }

    public function apiAdminNuevo($codigoPanal, $nombre, $publicacionAprobar) {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if($arPanal) {
            $arPanal->setNombre($nombre);
            $arPanal->setPublicacionAprobar($publicacionAprobar);
            $em->persist($arPanal);
            $em->flush();
            return [
                'error' => false,
                'codigoPanal' => $arPanal->getCodigoPanalPk()
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el panal"
            ];
        }
    }
}