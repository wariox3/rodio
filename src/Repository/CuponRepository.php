<?php


namespace App\Repository;

use App\Entity\Cupon;
use App\Entity\Transaccion;
use App\Entity\Usuario;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CuponRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Cupon::class);
        $this->space = $space;
    }

    public function apiAplicar($raw)
    {
        $em = $this->getEntityManager();
        $codigoCupon = $raw['codigoCupon']?? null;
        $codigoUsuario = $raw['codigoUsuario']?? null;
        if($codigoCupon && $codigoUsuario) {
            $arCupon = $em->getRepository(Cupon::class)->find($codigoCupon);
            if($arCupon) {
                if($arCupon->isEstadoAplicado() == 0) {
                    $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
                    if($arUsuario) {
                        $arCupon->setFechaAplicacion(new \DateTime('now'));
                        $arCupon->setUsuarioRel($arUsuario);
                        $arCupon->setEstadoAplicado(1);
                        $em->persist($arCupon);
                        $arTransaccion = new Transaccion();
                        $arTransaccion->setCodigoTransaccionTipoFk('cupon');
                        $arTransaccion->setFecha(new \DateTime('now'));
                        $arTransaccion->setUsuarioRel($arUsuario);
                        $arTransaccion->setVrValor($arCupon->getVrValor());
                        $em->persist($arTransaccion);
                        $arUsuario->setVrSaldo($arUsuario->getVrSaldo() + $arCupon->getVrValor());
                        $em->persist($arUsuario);
                        $em->flush();
                        return [
                            'error' => false
                        ];
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => 'El usuario no existe'];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => 'Este cupon ya fue aplicado'];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => 'El cupon no existe'];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }
}