<?php


namespace App\Repository;

use App\Entity\Reserva;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservaRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Reserva::class);
        $this->space = $space;
    }

    public function apiLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Reserva::class, 'r')
            ->select('r.codigoReservaPk')
            ->addSelect('r.nombre')
            ->where("r.codigoPanalFk = {$codigoPanal}")
            ->setMaxResults(20);
        $arReservas = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'reservas' => $arReservas
        ];
        return $respuesta;
    }
}