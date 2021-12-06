<?php


namespace App\Repository;

use App\Entity\Operador;
use App\Entity\Puesto;
use App\Entity\Ronda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RondaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ronda::class);
    }

    public function apiLista($codigoOperador, $codigoPuesto)
    {
        $em = $this->getEntityManager();
        $arOperador = $em->getRepository(Operador::class)->find($codigoOperador);
        if($arOperador) {
            $arPuesto = $em->getRepository(Puesto::class)->findOneBy(['codigoOperadorFk' => $codigoOperador, 'codigoPuestoInterface' => $codigoPuesto]);
            if($arPuesto) {
                $queryBuilder = $em->createQueryBuilder()->from(Ronda::class, 'r')
                    ->select('r.codigoRondaPk')
                    ->addSelect('r.nombre')
                    ->where("r.codigoPuestoFk = {$arPuesto->getCodigoPuestoPk()}");
                $arPanales = $queryBuilder->getQuery()->getResult();
                return [
                    'error' => false,
                    'rondas' => $arPanales
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "El puesto no existe"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El operador no existe"
            ];
        }


    }

}