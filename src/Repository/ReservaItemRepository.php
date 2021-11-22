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

}