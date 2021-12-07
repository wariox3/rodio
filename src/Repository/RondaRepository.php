<?php


namespace App\Repository;

use App\Entity\Puesto;
use App\Entity\Punto;
use App\Entity\Ronda;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RondaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ronda::class);
    }

    public function apiLista($codigoUsuario)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arPuesto = $em->getRepository(Puesto::class)->find($arUsuario->getCodigoPuestoFk());
            if($arPuesto) {
                $queryBuilder = $em->createQueryBuilder()->from(Ronda::class, 'r')
                    ->select('r.codigoRondaPk')
                    ->addSelect('r.nombre')
                    ->where("r.codigoPuestoFk = {$arPuesto->getCodigoPuestoPk()}");
                $arRondas = $queryBuilder->getQuery()->getResult();
                return [
                    'error' => false,
                    'rondas' => $arRondas
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
                'errorMensaje' => "El usuario no existe"
            ];
        }
    }

    public function apiPunto($codigoRonda)
    {
        $em = $this->getEntityManager();
        $arRonda = $em->getRepository(Ronda::class)->find($codigoRonda);
        if($arRonda) {
            $queryBuilder = $em->createQueryBuilder()->from(Punto::class, 'p')
                ->select('p.codigoPuntoPk')
                ->addSelect('p.nombre')
                ->addSelect('p.token')
                ->addSelect('p.minutos')
                ->where("p.codigoRondaFk = {$codigoRonda}");
            $arPuntos = $queryBuilder->getQuery()->getResult();
            return [
                'error' => false,
                'puntos' => $arPuntos
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "La ronda no existe"
            ];
        }
    }

}