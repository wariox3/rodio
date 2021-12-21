<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservaDetalleRepository")
 */
class ReservaDetalle
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_reserva_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoReservaDetallePk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="codigo_reserva_fk", type="integer", nullable=false)
     */
    private $codigoReservaFk;

    /**
     * @ORM\Column(name="codigo_celda_fk", type="integer", nullable=false)
     */
    private $codigoCeldaFk;

    /**
     * @ORM\Column(name="comentario", type="string", length=1000, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reserva", inversedBy="reservasDetallesReservaRel")
     * @ORM\JoinColumn(name="codigo_reserva_fk", referencedColumnName="codigo_reserva_pk")
     */
    private $reservaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Celda", inversedBy="reservasDetallesCeldaRel")
     * @ORM\JoinColumn(name="codigo_celda_fk", referencedColumnName="codigo_celda_pk")
     */
    private $celdaRel;

    /**
     * @return mixed
     */
    public function getCodigoReservaDetallePk()
    {
        return $this->codigoReservaDetallePk;
    }

    /**
     * @param mixed $codigoReservaDetallePk
     */
    public function setCodigoReservaDetallePk($codigoReservaDetallePk): void
    {
        $this->codigoReservaDetallePk = $codigoReservaDetallePk;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getCodigoReservaFk()
    {
        return $this->codigoReservaFk;
    }

    /**
     * @param mixed $codigoReservaFk
     */
    public function setCodigoReservaFk($codigoReservaFk): void
    {
        $this->codigoReservaFk = $codigoReservaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCeldaFk()
    {
        return $this->codigoCeldaFk;
    }

    /**
     * @param mixed $codigoCeldaFk
     */
    public function setCodigoCeldaFk($codigoCeldaFk): void
    {
        $this->codigoCeldaFk = $codigoCeldaFk;
    }

    /**
     * @return mixed
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
    }

    /**
     * @return mixed
     */
    public function getReservaRel()
    {
        return $this->reservaRel;
    }

    /**
     * @param mixed $reservaRel
     */
    public function setReservaRel($reservaRel): void
    {
        $this->reservaRel = $reservaRel;
    }

    /**
     * @return mixed
     */
    public function getCeldaRel()
    {
        return $this->celdaRel;
    }

    /**
     * @param mixed $celdaRel
     */
    public function setCeldaRel($celdaRel): void
    {
        $this->celdaRel = $celdaRel;
    }


}