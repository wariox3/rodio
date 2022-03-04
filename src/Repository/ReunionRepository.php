<?php

namespace App\Repository;

use App\Entity\Caso;
use App\Entity\CasoTipo;
use App\Entity\Panal;
use App\Entity\Reunion;
use App\Entity\ReunionDetalle;
use App\Entity\Usuario;
use App\Utilidades\Firebase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReunionRepository  extends ServiceEntityRepository
{
    private $firebase;

    public function __construct(ManagerRegistry $registry, Firebase $firebase)
    {
        parent::__construct($registry, Reunion::class);
        $this->firebase = $firebase;
    }

    public function apiAdminLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Reunion::class, 'r')
            ->select('r.codigoReunionPk')
            ->addSelect('r.fecha')
            ->addSelect('r.nombre')
            ->addSelect('r.cantidad')
            ->addSelect('r.cantidadCoeficiente')
            ->addSelect('r.estadoCerrado')
            ->where("r.codigoPanalFk = {$codigoPanal}")
            ->orderBy('r.fecha', 'DESC');
        $arReuniones = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'reuniones' => $arReuniones
        ];

    }

    public function apiAdminNuevo($codigoPanal, $id, $nombre)
    {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if($arPanal) {
            if($id) {
                $arReunion = $em->getRepository(Reunion::class)->find($id);
                if($arReunion) {
                    $arReunion->setNombre($nombre);
                    $em->persist($arReunion);
                    $em->flush();
                    return [
                        'error' => false,
                        'codigoReunion' => $arReunion->getCodigoReunionPk()
                    ];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "el id de reunion no existe"
                    ];
                }
            } else {
                $arReunion = new Reunion();
                $arReunion->setPanalRel($arPanal);
                $arReunion->setFecha(new \DateTime('now'));
                $arReunion->setNombre($nombre);
                $em->persist($arReunion);
                $em->flush();
                return [
                    'error' => false,
                    'codigoReunion' => $arReunion->getCodigoReunionPk()
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el panal"
            ];
        }
    }

    public function apiAdminDetalle($codigoReunion)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Reunion::class, 'r')
            ->select('r.codigoReunionPk')
            ->addSelect('r.fecha')
            ->addSelect('r.nombre')
            ->addSelect('r.cantidad')
            ->addSelect('r.cantidadCoeficiente')
            ->addSelect('r.estadoCerrado')
            ->addSelect('p.coeficiente as panalCoeficiente')
            ->addSelect('p.area as panalArea')
            ->addSelect('p.cantidad as panalCantidad')
            ->leftJoin('r.panalRel', 'p')
            ->where("r.codigoReunionPk = {$codigoReunion}");
        $arReunion = $queryBuilder->getQuery()->getResult();
        if($arReunion) {
            $queryBuilder = $em->createQueryBuilder()->from(ReunionDetalle::class, 'rd')
                ->select('rd.codigoReunionDetallePk')
                ->addSelect('rd.codigoCeldaFk')
                ->where("rd.codigoReunionFk = {$codigoReunion}");
            $arReunionDetalles = $queryBuilder->getQuery()->getResult();
            return [
                'error' => false,
                'reunion' => $arReunion[0],
                'reunionDetalles' => $arReunionDetalles
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'No existe la reunion'
            ];
        }
    }
}