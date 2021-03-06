<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReunionRepository")
 */
class Reunion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_reunion_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoReunionPk;

    /**
     * @ORM\Column(name="codigo_panal_fk", type="integer")
     */
    private $codigoPanalFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="nombre", type="string", length=300)
     */
    private $nombre;

    /**
     * @ORM\Column(name="cantidad", type="float", options={"default" : 0})
     */
    private $cantidad = 0.0;

    /**
     * @ORM\Column(name="cantidad_coeficiente", type="float", options={"default" : 0})
     */
    private $cantidadCoeficiente = 0.0;

    /**
     * @ORM\Column(name="cantidad_panal", type="float", options={"default" : 0})
     */
    private $cantidadPanal = 0.0;

    /**
     * @ORM\Column(name="cantidad_coeficiente_panal", type="float", options={"default" : 0})
     */
    private $cantidadCoeficientePanal = 0.0;

    /**
     * @ORM\Column(name="estado_cerrado", type="boolean", options={"default" : false})
     */
    private $estadoCerrado = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panal", inversedBy="reunionesPanalRel")
     * @ORM\JoinColumn(name="codigo_panal_fk", referencedColumnName="codigo_panal_pk")
     */
    private $panalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Votacion", mappedBy="reunionRel")
     */
    private $votacionesReunionRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReunionDetalle", mappedBy="reunionRel")
     */
    private $reunionesDetallesReunionRel;

    /**
     * @return mixed
     */
    public function getCodigoReunionPk()
    {
        return $this->codigoReunionPk;
    }

    /**
     * @param mixed $codigoReunionPk
     */
    public function setCodigoReunionPk($codigoReunionPk): void
    {
        $this->codigoReunionPk = $codigoReunionPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoPanalFk()
    {
        return $this->codigoPanalFk;
    }

    /**
     * @param mixed $codigoPanalFk
     */
    public function setCodigoPanalFk($codigoPanalFk): void
    {
        $this->codigoPanalFk = $codigoPanalFk;
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
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
    public function getCantidadCoeficiente(): float
    {
        return $this->cantidadCoeficiente;
    }

    /**
     * @param float $cantidadCoeficiente
     */
    public function setCantidadCoeficiente(float $cantidadCoeficiente): void
    {
        $this->cantidadCoeficiente = $cantidadCoeficiente;
    }

    /**
     * @return float
     */
    public function getCantidadPanal(): float
    {
        return $this->cantidadPanal;
    }

    /**
     * @param float $cantidadPanal
     */
    public function setCantidadPanal(float $cantidadPanal): void
    {
        $this->cantidadPanal = $cantidadPanal;
    }

    /**
     * @return float
     */
    public function getCantidadCoeficientePanal(): float
    {
        return $this->cantidadCoeficientePanal;
    }

    /**
     * @param float $cantidadCoeficientePanal
     */
    public function setCantidadCoeficientePanal(float $cantidadCoeficientePanal): void
    {
        $this->cantidadCoeficientePanal = $cantidadCoeficientePanal;
    }

    /**
     * @return bool
     */
    public function isEstadoCerrado(): bool
    {
        return $this->estadoCerrado;
    }

    /**
     * @param bool $estadoCerrado
     */
    public function setEstadoCerrado(bool $estadoCerrado): void
    {
        $this->estadoCerrado = $estadoCerrado;
    }

    /**
     * @return mixed
     */
    public function getPanalRel()
    {
        return $this->panalRel;
    }

    /**
     * @param mixed $panalRel
     */
    public function setPanalRel($panalRel): void
    {
        $this->panalRel = $panalRel;
    }

    /**
     * @return mixed
     */
    public function getVotacionesReunionRel()
    {
        return $this->votacionesReunionRel;
    }

    /**
     * @param mixed $votacionesReunionRel
     */
    public function setVotacionesReunionRel($votacionesReunionRel): void
    {
        $this->votacionesReunionRel = $votacionesReunionRel;
    }

    /**
     * @return mixed
     */
    public function getReunionesDetallesReunionRel()
    {
        return $this->reunionesDetallesReunionRel;
    }

    /**
     * @param mixed $reunionesDetallesReunionRel
     */
    public function setReunionesDetallesReunionRel($reunionesDetallesReunionRel): void
    {
        $this->reunionesDetallesReunionRel = $reunionesDetallesReunionRel;
    }



}