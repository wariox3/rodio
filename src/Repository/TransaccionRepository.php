<?php


namespace App\Repository;

use App\Entity\Transaccion;
use App\Entity\Usuario;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TransaccionRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Transaccion::class);
        $this->space = $space;
    }

    public function apiNuevo($codigoUsuario, $tipo, $valor)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
//            if($arUsuario->getVrSaldo() + $valor >= 0) {
                $arTransaccion = new Transaccion();
                $arTransaccion->setCodigoTransaccionTipoFk($tipo);
                $arTransaccion->setUsuarioRel($arUsuario);
                $arTransaccion->setFecha(new \DateTime('now'));
                $arTransaccion->setVrValor($valor);
                $em->persist($arTransaccion);
                $arUsuario->setVrSaldo($arUsuario->getVrSaldo() + $valor);
                $em->persist($arUsuario);
                $em->flush();
                return [
                    'error' => false
                ];
//            } else {
//                return [
//                    'error' => true,
//                    'errorMensaje' => 'El saldo es insuficiente para la transaccion'
//                ];
//            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'El usuario no existe'
            ];
        }
    }
}