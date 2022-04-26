<?php


namespace App\Repository;

use App\Entity\Despacho;
use App\Entity\Operador;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DespachoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Despacho::class);
    }

    public function apiNuevo($codigoUsuario, $operador, $codigoDespacho, $token)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arOperador = $em->getRepository(Operador::class)->find($operador);
            if($arOperador) {
                $arDespacho = new Despacho();
                $arDespacho->setFecha(new \DateTime('now'));
                $arDespacho->setUsuarioRel($arUsuario);
                $arDespacho->setOperadorRel($arOperador);
                $arDespacho->setCodigoDespacho($codigoDespacho);
                $arDespacho->setToken($token);
                $em->persist($arDespacho);
                $em->flush();
                return [
                    'error' => false,
                    'codigoDespacho' => $arDespacho->getCodigoDespachoPk(),
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe el operador"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }

    public function apiLista($codigoUsuario)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Despacho::class, 'd')
            ->select('d.codigoDespachoPk')
            ->addSelect('d.fecha')
            ->addSelect('d.codigoOperadorFk')
            ->addSelect('d.codigoDespacho')
            ->addSelect('d.token')
            ->addSelect('o.nombre as operadorNombre')
            ->leftJoin('d.operadorRel', 'o')
            ->andWhere("d.codigoUsuarioFk = {$codigoUsuario}")
            ->orderBy('d.fecha', 'DESC');
        $arDespachos = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'despachos' => $arDespachos
        ];

    }
}