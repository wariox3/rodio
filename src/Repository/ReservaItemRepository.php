<?php


namespace App\Repository;

use App\Entity\ReservaItem;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservaItemRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, ReservaItem::class);
        $this->space = $space;
    }

    public function apiLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(ReservaItem::class, 'ri')
            ->select('ri.codigoReservaItemPk')
            ->addSelect('ri.nombre')
            ->where("ri.codigoPanalFk = {$codigoPanal}")
            ->setMaxResults(20);
        $arReservasItem = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'reservasItemes' => $arReservasItem
        ];
        return $respuesta;
    }
}