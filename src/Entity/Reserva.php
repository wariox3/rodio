<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservaRepository")
 */
class Reserva
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_reserva_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoReservaPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="codigo_reserva_item_fk", type="integer", nullable=false)
     */
    private $codigoReservaItemFk;

    /**
     * @ORM\Column(name="codigo_celda_fk", type="integer", nullable=false)
     */
    private $codigoCeldaFk;

    /**
     * @ORM\Column(name="comentario", type="string", length=250, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ReservaItem", inversedBy="reservasReservaItemRel")
     * @ORM\JoinColumn(name="codigo_reserva_item_fk", referencedColumnName="codigo_reserva_item_pk")
     */
    private $reservaItemRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Celda", inversedBy="reservasCeldaRel")
     * @ORM\JoinColumn(name="codigo_celda_fk", referencedColumnName="codigo_celda_pk")
     */
    private $celdaRel;

    /**
     * @return mixed
     */
    public function getCodigoReservaPk()
    {
        return $this->codigoReservaPk;
    }

    /**
     * @param mixed $codigoReservaPk
     */
    public function setCodigoReservaPk($codigoReservaPk): void
    {
        $this->codigoReservaPk = $codigoReservaPk;
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
    public function getCodigoReservaItemFk()
    {
        return $this->codigoReservaItemFk;
    }

    /**
     * @param mixed $codigoReservaItemFk
     */
    public function setCodigoReservaItemFk($codigoReservaItemFk): void
    {
        $this->codigoReservaItemFk = $codigoReservaItemFk;
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
    public function getReservaItemRel()
    {
        return $this->reservaItemRel;
    }

    /**
     * @param mixed $reservaItemRel
     */
    public function setReservaItemRel($reservaItemRel): void
    {
        $this->reservaItemRel = $reservaItemRel;
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