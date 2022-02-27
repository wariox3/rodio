<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovimientoDetalleRepository")
 */
class MovimientoDetalle
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_movimiento_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoMovimientoDetallePk;

    /**
     * @ORM\Column(name="codigo_movimiento_fk", type="integer")
     */
    private $codigoMovimientoFk;

    /**
     * @ORM\Column(name="codigo_item_fk", type="integer")
     */
    private $codigoItemFk;

    /**
     * @ORM\Column(name="cantidad", type="float", options={"default" : 0})
     */
    private $cantidad = 0.0;

    /**
     * @ORM\Column(name="vr_precio", type="float", options={"default" : 0})
     */
    private $vrPrecio = 0.0;

    /**
     * @ORM\Column(name="vr_subtotal", type="float", options={"default" : 0})
     */
    private $vrSubtotal = 0.0;

    /**
     * @ORM\Column(name="operacion_inventario", type="smallint", nullable=true, options={"default" : 0})
     */
    private $operacionInventario = 0;

    /**
     * @ORM\Column(name="porcentaje_iva", type="float", nullable=true, options={"default" : 0})
     */
    private $porcentajeIva = 0.0;

    /**
     * @ORM\Column(name="vr_iva", type="float", nullable=true, options={"default" : 0})
     */
    private $vrIva = 0.0;

    /**
     * @ORM\Column(name="vr_neto", type="float", options={"default" : 0})
     */
    private $vrNeto = 0.0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movimiento", inversedBy="movimientosDetallesMovimientoRel")
     * @ORM\JoinColumn(name="codigo_movimiento_fk", referencedColumnName="codigo_movimiento_pk")
     */
    private $movimientoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="movimientosDetallesItemRel")
     * @ORM\JoinColumn(name="codigo_item_fk", referencedColumnName="codigo_item_pk")
     */
    private $itemRel;

    /**
     * @return mixed
     */
    public function getCodigoMovimientoDetallePk()
    {
        return $this->codigoMovimientoDetallePk;
    }

    /**
     * @param mixed $codigoMovimientoDetallePk
     */
    public function setCodigoMovimientoDetallePk($codigoMovimientoDetallePk): void
    {
        $this->codigoMovimientoDetallePk = $codigoMovimientoDetallePk;
    }

    /**
     * @return mixed
     */
    public function getCodigoMovimientoFk()
    {
        return $this->codigoMovimientoFk;
    }

    /**
     * @param mixed $codigoMovimientoFk
     */
    public function setCodigoMovimientoFk($codigoMovimientoFk): void
    {
        $this->codigoMovimientoFk = $codigoMovimientoFk;
    }

    /**
     * @return float
     */
    public function getCantidad(): float
    {
        return $this->cantidad;
    }

    /**
     * @param float $cantidad
     */
    public function setCantidad(float $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return float
     */
    public function getVrPrecio(): float
    {
        return $this->vrPrecio;
    }

    /**
     * @param float $vrPrecio
     */
    public function setVrPrecio(float $vrPrecio): void
    {
        $this->vrPrecio = $vrPrecio;
    }

    /**
     * @return float
     */
    public function getVrSubtotal(): float
    {
        return $this->vrSubtotal;
    }

    /**
     * @param float $vrSubtotal
     */
    public function setVrSubtotal(float $vrSubtotal): void
    {
        $this->vrSubtotal = $vrSubtotal;
    }

    /**
     * @return int
     */
    public function getOperacionInventario(): int
    {
        return $this->operacionInventario;
    }

    /**
     * @param int $operacionInventario
     */
    public function setOperacionInventario(int $operacionInventario): void
    {
        $this->operacionInventario = $operacionInventario;
    }

    /**
     * @return float
     */
    public function getPorcentajeIva(): float
    {
        return $this->porcentajeIva;
    }

    /**
     * @param float $porcentajeIva
     */
    public function setPorcentajeIva(float $porcentajeIva): void
    {
        $this->porcentajeIva = $porcentajeIva;
    }

    /**
     * @return mixed
     */
    public function getMovimientoRel()
    {
        return $this->movimientoRel;
    }

    /**
     * @param mixed $movimientoRel
     */
    public function setMovimientoRel($movimientoRel): void
    {
        $this->movimientoRel = $movimientoRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoItemFk()
    {
        return $this->codigoItemFk;
    }

    /**
     * @param mixed $codigoItemFk
     */
    public function setCodigoItemFk($codigoItemFk): void
    {
        $this->codigoItemFk = $codigoItemFk;
    }

    /**
     * @return mixed
     */
    public function getItemRel()
    {
        return $this->itemRel;
    }

    /**
     * @param mixed $itemRel
     */
    public function setItemRel($itemRel): void
    {
        $this->itemRel = $itemRel;
    }

    /**
     * @return float
     */
    public function getVrIva(): float
    {
        return $this->vrIva;
    }

    /**
     * @param float $vrIva
     */
    public function setVrIva(float $vrIva): void
    {
        $this->vrIva = $vrIva;
    }

    /**
     * @return float
     */
    public function getVrNeto(): float
    {
        return $this->vrNeto;
    }

    /**
     * @param float $vrNeto
     */
    public function setVrNeto(float $vrNeto): void
    {
        $this->vrNeto = $vrNeto;
    }


}