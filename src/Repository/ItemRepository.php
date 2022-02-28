<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\CeldaUsuario;
use App\Entity\Item;
use App\Entity\Panal;
use App\Entity\Usuario;
use App\Entity\Visita;
use App\Utilidades\Firebase;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ItemRepository extends ServiceEntityRepository
{
    private $firebase;
    private $space;

    public function __construct(ManagerRegistry $registry, Firebase $firebase, SpaceDO $space)
    {
        parent::__construct($registry, Item::class);
        $this->firebase = $firebase;
        $this->space = $space;
    }

    public function apiLista($linea, $orden)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Item::class, 'i')
            ->select('i.codigoItemPk')
            ->addSelect('i.nombre')
            ->addSelect('i.precio')
            ->addSelect('i.codigoGrupoFk')
            ->addSelect('i.urlImagen')
            ->addSelect('g.nombre as grupoNombre')
            ->leftJoin('i.grupoRel', 'g')
            ->where("i.codigoLineaFk = '{$linea}'")
            ->orderBy("i.codigoGrupoFk");
        if($orden){
            $queryBuilder->addOrderBy('i.precio', $orden);
        }
        $arItemes = $queryBuilder->getQuery()->getResult();
        $grupos = [];
        $codigoGrupo = null;
        foreach ($arItemes as $arItem) {
            if($arItem['codigoGrupoFk'] != $codigoGrupo) {
                $grupos[$arItem['codigoGrupoFk']]['nombre'] = $arItem['grupoNombre'];

                $codigoGrupo = $arItem['codigoGrupoFk'];
            }
            $grupos[$arItem['codigoGrupoFk']]['itemes'][] = [
                'codigoItemPk' => $arItem['codigoItemPk'],
                'nombre' => $arItem['nombre'],
                'precio' => $arItem['precio']
            ];
        }
        return [
            'error' => false,
            'itemes' => $grupos
        ];
    }

    public function apiBuscarItem($itemNombre)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Item::class, 'i')
            ->select('i.codigoItemPk')
            ->addSelect('i.nombre')
            ->addSelect('i.precio')
            ->addSelect('i.codigoGrupoFk')
            ->addSelect('i.urlImagen')
            ->addSelect('g.nombre as grupoNombre')
            ->leftJoin('i.grupoRel', 'g')
            ->where("i.nombre like '%{$itemNombre}%' ")
            ->orderBy("i.codigoGrupoFk");
        $arItemes = $queryBuilder->getQuery()->getResult();
        $grupos = [];
        $codigoGrupo = null;
        foreach ($arItemes as $arItem) {
            if($arItem['codigoGrupoFk'] != $codigoGrupo) {
                $grupos[$arItem['codigoGrupoFk']]['nombre'] = $arItem['grupoNombre'];

                $codigoGrupo = $arItem['codigoGrupoFk'];
            }
            $grupos[$arItem['codigoGrupoFk']]['itemes'][] = [
                'codigoItemPk' => $arItem['codigoItemPk'],
                'nombre' => $arItem['nombre'],
                'precio' => $arItem['precio']
            ];
        }
        return [
            'error' => false,
            'itemes' => $grupos
        ];
    }

}