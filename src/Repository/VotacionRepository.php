<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\Votacion;
use App\Entity\VotacionCelda;
use App\Entity\VotacionDetalle;
use App\Utilidades\Firebase;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VotacionRepository extends ServiceEntityRepository
{
    private $firebase;
    private $space;

    public function __construct(ManagerRegistry $registry, Firebase $firebase, SpaceDO $space)
    {
        parent::__construct($registry, Votacion::class);
        $this->firebase = $firebase;
        $this->space = $space;
    }

    public function apiLista($codigoCelda)
    {
        $em = $this->getEntityManager();
        $arCelda = $em->getRepository(Celda::class)->find($codigoCelda);
        if ($arCelda) {
            $queryBuilder = $em->createQueryBuilder()->from(Votacion::class, 'v')
                ->select('v.codigoVotacionPk')
                ->addSelect('v.fecha')
                ->addSelect('v.fechaHasta')
                ->addSelect('v.descripcion')
                ->addSelect('v.cantidad')
                ->addSelect('v.estadoCerrado')
                ->where("v.codigoPanalFk = {$arCelda->getCodigoPanalFk()}")
                ->orderBy('v.fecha', 'DESC');
            $arVotaciones = $queryBuilder->getQuery()->getResult();
            $indice = 0;
            foreach ($arVotaciones as $arVotacion) {
                //Saber si ya voto
                $voto = false;
                $codigoVotacionDetalle = null;
                $queryBuilder = $em->createQueryBuilder()->from(VotacionCelda::class, 'vc')
                    ->select('vc.codigoVotacionCeldaPk')
                    ->addSelect('vc.codigoVotacionDetalleFk')
                    ->where("vc.codigoVotacionFk = {$arVotacion['codigoVotacionPk']}");
                $arVotacionCelda = $queryBuilder->getQuery()->getResult();
                if($arVotacionCelda) {
                    $voto = true;
                    $codigoVotacionDetalle = $arVotacionCelda[0]['codigoVotacionCeldaPk'];

                }
                $arVotaciones[$indice]['voto'] = $voto;
                $arVotaciones[$indice]['codigoVotacionDetalle'] = $codigoVotacionDetalle;
                $queryBuilder = $em->createQueryBuilder()->from(VotacionDetalle::class, 'vd')
                    ->select('vd.codigoVotacionDetallePk')
                    ->addSelect('vd.descripcion')
                    ->where("vd.codigoVotacionFk = {$arVotacion['codigoVotacionPk']}");
                $arVotacionesDetalles = $queryBuilder->getQuery()->getResult();
                $arVotaciones[$indice]['detalles'] = $arVotacionesDetalles;
                $indice++;
            }
            return [
                'error' => false,
                'votaciones' => $arVotaciones
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "La celda no existe"
            ];
        }
    }
}