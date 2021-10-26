<?php

namespace App\Repository;

use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    public function apliLista()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Categoria::class, 'c')
            ->select('c.codigoCatagoriaPk')
            ->addSelect('c.nombre')
            ->addSelect('c.urlImagen');

        $arCategorias = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'categorias' => $arCategorias
        ];
    }

}