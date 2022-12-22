<?php


namespace App\Repository;

use App\Entity\Operador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OperadorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operador::class);
    }

    public function apiLista()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Operador::class, 'o')
            ->select('o.codigoOperadorPk')
            ->addSelect('o.nombre')
            ->where('o.transporte = 1');
        $arOperadores = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'operadores' => $arOperadores
        ];
    }

    public function apiConectar($codigoOperador)
    {
        $em = $this->getEntityManager();
        $arOperador = $em->getRepository(Operador::class)->find($codigoOperador);
        if ($arOperador) {
            return [
                'error' => false,
                'nombre' => $arOperador->getNombre(),
                'puntoServicio' => $arOperador->getPuntoServicioCromo(),
                'puntoServicioToken' => $arOperador->getToken()
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el operador"
            ];
        }
    }

}