<?php


namespace App\Repository;

use App\Entity\Ciudad;
use App\Entity\Operador;
use App\Entity\Viaje;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ViajeRepository extends ServiceEntityRepository
{
    private $space;

    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Viaje::class);
        $this->space = $space;
    }

    public function apiNuevo($codigoOperador, $ciudadOrigen, $ciudadDestino, $fechaCargue, $flete, $cantidadClientes, $peso, $volumen, $comentario)
    {
        $em = $this->getEntityManager();
        $arOperador = $em->getRepository(Operador::class)->find($codigoOperador);
        if($arOperador) {
            $arCiudadOrigen = $em->getRepository(Ciudad::class)->find($ciudadOrigen);
            $arCiudadDestino = $em->getRepository(Ciudad::class)->find($ciudadDestino);
            if($arCiudadOrigen && $arCiudadDestino) {
                $arViaje = new Viaje();
                $arViaje->setOperadorRel($arOperador);
                $arViaje->setCiudadOrigenRel($arCiudadOrigen);
                $arViaje->setCiudadDestinoRel($arCiudadDestino);
                $arViaje->setFecha(new \DateTime('now'));
                $arViaje->setFechaCargue(date_create($fechaCargue));
                $arViaje->setVrFlete($flete);
                $arViaje->setCantidadClientes($cantidadClientes);
                $arViaje->setPeso($peso);
                $arViaje->setVolumen($volumen);
                $arViaje->setComentario($comentario);
                $em->persist($arViaje);
                $em->flush();
                return [
                    'error' => false
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => 'ELa ciudad origen o destino no existe'
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'El operador no existe'
            ];
        }
    }

    public function apiListaCliente()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Viaje::class, 'v')
            ->select('v.codigoViajePk')
            ->addSelect('v.fecha')
            ->addSelect('v.fechaCargue')
            ->addSelect('v.cantidadClientes')
            ->addSelect('v.comentario')
            ->addSelect('v.codigoCiudadOrigenFk')
            ->addSelect('v.codigoCiudadDestinoFk')
            ->addSelect('co.nombre as ciudadOrigenNombre')
            ->addSelect('cd.nombre as ciudadDestinoNombre')
            ->leftJoin('v.ciudadOrigenRel', 'co')
            ->leftJoin('v.ciudadDestinoRel', 'cd')
            ->orderBy('v.fechaCargue', 'DESC');
        $arViajes = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'viajes' => $arViajes
        ];
        return $respuesta;
    }

}