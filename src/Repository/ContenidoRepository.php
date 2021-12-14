<?php


namespace App\Repository;

use App\Entity\Contenido;
use App\Utilidades\Firebase;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContenidoRepository extends ServiceEntityRepository
{
    private $firebase;
    private $space;

    public function __construct(ManagerRegistry $registry, Firebase $firebase, SpaceDO $space)
    {
        parent::__construct($registry, Contenido::class);
        $this->firebase = $firebase;
        $this->space = $space;
    }

    public function apiLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Contenido::class, 'c')
            ->select('c.codigoContenidoPk')
            ->addSelect('c.nombre')
            ->addSelect('c.url')
            ->where("c.codigoPanalFk = {$codigoPanal}");
        $arContenidos = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'contenidos' => $arContenidos
        ];
        return $respuesta;
    }

}