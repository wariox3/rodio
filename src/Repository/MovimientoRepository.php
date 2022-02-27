<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\CeldaUsuario;
use App\Entity\Item;
use App\Entity\Movimiento;
use App\Entity\MovimientoClase;
use App\Entity\MovimientoDetalle;
use App\Entity\Panal;
use App\Entity\Usuario;
use App\Entity\Visita;
use App\Utilidades\Firebase;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MovimientoRepository extends ServiceEntityRepository
{
    private $firebase;
    private $space;

    public function __construct(ManagerRegistry $registry, Firebase $firebase, SpaceDO $space)
    {
        parent::__construct($registry, Movimiento::class);
        $this->firebase = $firebase;
        $this->space = $space;
    }

    public function apiNuevoPedido($codigoUsuario, $detalles)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arMovimientoClase = $em->getRepository(MovimientoClase::class)->find('PED');
            if($arMovimientoClase) {
                if(is_array($detalles)) {
                    $arMovimiento = new Movimiento();
                    $arMovimiento->setMovimientoClaseRel($arMovimientoClase);
                    $arMovimiento->setFecha(new \DateTime('now'));
                    $arMovimiento->setUsuarioRel($arUsuario);
                    $em->persist($arMovimiento);
                    foreach ($detalles as $detalle) {
                        $arItem = $em->getRepository(Item::class)->find($detalle['item']);
                        if($arItem) {
                            $cantidad = $detalle['cantidad'];
                            $precio = $arItem->getPrecio();
                            $subtotal = $cantidad * $precio;
                            $porcentajeIva = $arItem->getPorcentajeIva();
                            $iva = 0;
                            if($porcentajeIva > 0) {
                                $iva = $subtotal * $porcentajeIva / 100;
                            }
                            $neto = $subtotal + $iva;
                            $arMovimientoDetalle = new MovimientoDetalle();
                            $arMovimientoDetalle->setMovimientoRel($arMovimiento);
                            $arMovimientoDetalle->setItemRel($arItem);
                            $arMovimientoDetalle->setCantidad($cantidad);
                            $arMovimientoDetalle->setPorcentajeIva($porcentajeIva);
                            $arMovimientoDetalle->setVrPrecio($precio);
                            $arMovimientoDetalle->setVrSubtotal($subtotal);
                            $arMovimientoDetalle->setVrIva($iva);
                            $arMovimientoDetalle->setVrNeto($neto);
                            $em->persist($arMovimientoDetalle);
                        }
                    }
                    $em->flush();
                    return [
                        'error' => false,
                        'codigoMovimiento' => $arMovimiento->getCodigoMovimientoPk(),
                    ];
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "Los detalles deben ser un arreglo"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "La clase de movimiento no existe"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }

    public function apiListaPedido($codigoUsuario)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Movimiento::class, 'm')
            ->select('m.codigoMovimientoPk')
            ->addSelect('m.fecha')
            ->where("m.codigoUsuarioFk = {$codigoUsuario}");
        $arMovimientos = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'movimientos' => $arMovimientos
        ];

    }
}