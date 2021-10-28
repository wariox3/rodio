<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VotacionRepository")
 */
class Votacion
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_votacion_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoVotacionPk;

    /**
     * @ORM\Column(name="codigo_panal_fk", type="integer", nullable=true)
     */
    private $codigoPanalFk;

    /**
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_hasta", type="datetime")
     */
    private $fechaHasta;

    /**
     * @ORM\Column(name="descripcion", type="string", length=200)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="cantidad", type="integer", options={"default" : 0})
     */
    private $cantidad = 0;

    /**
     * @ORM\Column(name="estado_cerrado", type="boolean", options={"default" : false}, nullable=true)
     */
    private $estadoCerrado = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panal", inversedBy="votacionesPanalRel")
     * @ORM\JoinColumn(name="codigo_panal_fk", referencedColumnName="codigo_panal_pk")
     */
    private $panalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VotacionCelda", mappedBy="votacionRel")
     */
    private $votacionesCeldasVotacionRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VotacionDetalle", mappedBy="votacionRel")
     */
    private $votacionesDetallesVotacionRel;

    /**
     * @return mixed
     */
    public function getCodigoVotacionPk()
    {
        return $this->codigoVotacionPk;
    }

    /**
     * @param mixed $codigoVotacionPk
     */
    public function setCodigoVotacionPk($codigoVotacionPk): void
    {
        $this->codigoVotacionPk = $codigoVotacionPk;
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
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * @param mixed $fechaHasta
     */
    public function setFechaHasta($fechaHasta): void
    {
        $this->fechaHasta = $fechaHasta;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return int
     */
    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    /**
     * @param int $cantidad
     */
    public function setCantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
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
    public function getVotacionesCeldasVotacionRel()
    {
        return $this->votacionesCeldasVotacionRel;
    }

    /**
     * @param mixed $votacionesCeldasVotacionRel
     */
    public function setVotacionesCeldasVotacionRel($votacionesCeldasVotacionRel): void
    {
        $this->votacionesCeldasVotacionRel = $votacionesCeldasVotacionRel;
    }

    /**
     * @return mixed
     */
    public function getVotacionesDetallesVotacionRel()
    {
        return $this->votacionesDetallesVotacionRel;
    }

    /**
     * @param mixed $votacionesDetallesVotacionRel
     */
    public function setVotacionesDetallesVotacionRel($votacionesDetallesVotacionRel): void
    {
        $this->votacionesDetallesVotacionRel = $votacionesDetallesVotacionRel;
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



}