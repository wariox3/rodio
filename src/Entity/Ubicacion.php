<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UbicacionRepository")
 */
class Ubicacion
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_reserva_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoUbicacionPk;

    /**
     * @ORM\Column(name="codigo_despacho_fk", type="integer")
     */
    private $codigoDespachoFk;

    /**
     * @ORM\Column(name="codigo_guia_fk", type="integer", nullable=true)
     */
    private $codigoGuiaFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="latitud", type="float", options={"default":0}, nullable=true)
     */
    private $latitud = 0.0;

    /**
     * @ORM\Column(name="longitud", type="float", options={"default":0}, nullable=true)
     */
    private $longitud = 0.0;

    /**
     * @ORM\Column(name="velocidad", type="float", options={"default":0}, nullable=true)
     */
    private $velocidad = 0.0;

    /**
     * @ORM\Column(name="altitud", type="float", options={"default":0}, nullable=true)
     */
    private $altitud = 0.0;

    /**
     * @ORM\Column(name="exactitud", type="float", options={"default":0}, nullable=true)
     */
    private $exactitud = 0.0;

    /**
     * @ORM\Column(name="exactitud_altitud", type="float", options={"default":0}, nullable=true)
     */
    private $exactitudAltitud = 0.0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Despacho", inversedBy="ubicacionesDespachoRel")
     * @ORM\JoinColumn(name="codigo_despacho_fk", referencedColumnName="codigo_despacho_pk")
     */
    private $despachoRel;

    /**
     * @return mixed
     */
    public function getCodigoUbicacionPk()
    {
        return $this->codigoUbicacionPk;
    }

    /**
     * @param mixed $codigoUbicacionPk
     */
    public function setCodigoUbicacionPk($codigoUbicacionPk): void
    {
        $this->codigoUbicacionPk = $codigoUbicacionPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoDespachoFk()
    {
        return $this->codigoDespachoFk;
    }

    /**
     * @param mixed $codigoDespachoFk
     */
    public function setCodigoDespachoFk($codigoDespachoFk): void
    {
        $this->codigoDespachoFk = $codigoDespachoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoGuiaFk()
    {
        return $this->codigoGuiaFk;
    }

    /**
     * @param mixed $codigoGuiaFk
     */
    public function setCodigoGuiaFk($codigoGuiaFk): void
    {
        $this->codigoGuiaFk = $codigoGuiaFk;
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
     * @return float
     */
    public function getLatitud(): float
    {
        return $this->latitud;
    }

    /**
     * @param float $latitud
     */
    public function setLatitud(float $latitud): void
    {
        $this->latitud = $latitud;
    }

    /**
     * @return float
     */
    public function getLongitud(): float
    {
        return $this->longitud;
    }

    /**
     * @param float $longitud
     */
    public function setLongitud(float $longitud): void
    {
        $this->longitud = $longitud;
    }

    /**
     * @return float
     */
    public function getVelocidad(): float
    {
        return $this->velocidad;
    }

    /**
     * @param float $velocidad
     */
    public function setVelocidad(float $velocidad): void
    {
        $this->velocidad = $velocidad;
    }

    /**
     * @return float
     */
    public function getAltitud(): float
    {
        return $this->altitud;
    }

    /**
     * @param float $altitud
     */
    public function setAltitud(float $altitud): void
    {
        $this->altitud = $altitud;
    }

    /**
     * @return float
     */
    public function getExactitud(): float
    {
        return $this->exactitud;
    }

    /**
     * @param float $exactitud
     */
    public function setExactitud(float $exactitud): void
    {
        $this->exactitud = $exactitud;
    }

    /**
     * @return float
     */
    public function getExactitudAltitud(): float
    {
        return $this->exactitudAltitud;
    }

    /**
     * @param float $exactitudAltitud
     */
    public function setExactitudAltitud(float $exactitudAltitud): void
    {
        $this->exactitudAltitud = $exactitudAltitud;
    }

    /**
     * @return mixed
     */
    public function getDespachoRel()
    {
        return $this->despachoRel;
    }

    /**
     * @param mixed $despachoRel
     */
    public function setDespachoRel($despachoRel): void
    {
        $this->despachoRel = $despachoRel;
    }


}