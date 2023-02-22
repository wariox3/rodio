<?php


namespace App\Repository;

use App\Entity\Operador;
use App\Entity\OperadorConfiguracion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OperadorConfiguracionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperadorConfiguracion::class);
    }

    public function apiCalidadImagenEntrega($codigoOperador)
    {
        $em = $this->getEntityManager();
        $arOperadorConfiguracion = $em->getRepository(OperadorConfiguracion::class)->find($codigoOperador);
        if ($arOperadorConfiguracion) {
            return [
                'error' => false,
                'calidadImagenEntrega' => $arOperadorConfiguracion->getCalidadImagenEntrega(),
                'exigeImagenEntrega' => $arOperadorConfiguracion->isExigeImagenEntrega(),
                'exigeFirmaEntrega' => $arOperadorConfiguracion->isExigeFirmaEntrega()
            ];
        } else {
            return [
                'error' => false,
                'calidadImagenEntrega' => 1,
                'exigeImagenEntrega' => false,
                'exigeFirmaEntrega' => false
            ];
        }
    }

}