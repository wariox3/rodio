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