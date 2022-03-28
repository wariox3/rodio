<?php


namespace App\Repository;

use App\Entity\Viaje;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ViajeRepository extends ServiceEntityRepository
{
    private $space;

    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Viaje::class);
        $this->space = $space;
    }

    public function apiListaCliente()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Viaje::class, 'v')
            ->select('v.codigoViajePk')
            ->addSelect('v.fecha')
            ->addSelect('v.fechaCargue')
            ->addSelect('v.cantidadClientes')
            ->addSelect('v.comentarios')
            ->addSelect('v.codigoCiudadOrigenFk')
            ->addSelect('v.codigoCiudadDestinoFk')
            ->addSelect('co.nombre as ciudadOrigenNombre')
            ->addSelect('cd.nombre as ciudadDestinoNombre')
            ->leftJoin('v.ciudadOrigenRel', 'co')
            ->leftJoin('v.ciudadDestinoRel', 'cd')
            ->orderBy('v.fechaCargue', 'DESC');
        $arViajes = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'viajes' => $arViajes
        ];
        return $respuesta;
    }

}