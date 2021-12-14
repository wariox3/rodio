<?php


namespace App\Repository;

use App\Entity\Contenido;
use App\Entity\Soporte;
use App\Entity\Usuario;
use App\Utilidades\Firebase;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SoporteRepository extends ServiceEntityRepository
{
    private $firebase;
    private $space;

    public function __construct(ManagerRegistry $registry, Firebase $firebase, SpaceDO $space)
    {
        parent::__construct($registry, Soporte::class);
        $this->firebase = $firebase;
        $this->space = $space;
    }

    public function apiNuevo($codigoUsuario, $descripcion)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
                $arSoporte = new Soporte();
                $arSoporte->setUsuarioRel($arUsuario);
                $arSoporte->setDescripcion($descripcion);
                $em->persist($arSoporte);
                $em->flush();
                return [
                    'error' => false,
                    'codigoSoporte' => $arSoporte->getCodigoSoportePk(),
                ];

        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }
}