<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ControlRepository")
 */
class Control
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_control_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoControlPk;

    /**
     * @ORM\Column(name="codigo_puesto_fk", type="integer", nullable=false)
     */
    private $codigoPuestoFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="estado_autorizado", type="string", options={"default" : "P"})
     */
    private $estadoRepote = "P";

    /**
     * @ORM\Column(name="fecha_reporte", type="datetime", nullable=true)
     */
    private $fechaReporte;


    /**
     * @ORM\Column(name="fecha_control", type="datetime", nullable=true)
     */
    private $fechaControl;

    /**
     * @ORM\Column(name="codigo_operador_fk", type="integer")
     */
    private $codigoOperadorFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Operador", inversedBy="controlesOperadorRel")
     * @ORM\JoinColumn(name="codigo_operador_fk", referencedColumnName="codigo_operador_pk")
     */
    private $operadorRel;

    /**
     * @return mixed
     */
    public function getCodigoControlPk()
    {
        return $this->codigoControlPk;
    }

    /**
     * @param mixed $codigoControlPk
     */
    public function setCodigoControlPk($codigoControlPk): void
    {
        $this->codigoControlPk = $codigoControlPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoPuestoFk()
    {
        return $this->codigoPuestoFk;
    }

    /**
     * @param mixed $codigoPuestoFk
     */
    public function setCodigoPuestoFk($codigoPuestoFk): void
    {
        $this->codigoPuestoFk = $codigoPuestoFk;
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
     * @return string
     */
    public function getEstadoRepote(): string
    {
        return $this->estadoRepote;
    }

    /**
     * @param string $estadoRepote
     */
    public function setEstadoRepote(string $estadoRepote): void
    {
        $this->estadoRepote = $estadoRepote;
    }

    /**
     * @return mixed
     */
    public function getFechaReporte()
    {
        return $this->fechaReporte;
    }

    /**
     * @param mixed $fechaReporte
     */
    public function setFechaReporte($fechaReporte): void
    {
        $this->fechaReporte = $fechaReporte;
    }

    /**
     * @return mixed
     */
    public function getFechaControl()
    {
        return $this->fechaControl;
    }

    /**
     * @param mixed $fechaControl
     */
    public function setFechaControl($fechaControl): void
    {
        $this->fechaControl = $fechaControl;
    }

    /**
     * @return mixed
     */
    public function getCodigoOperadorFk()
    {
        return $this->codigoOperadorFk;
    }

    /**
     * @param mixed $codigoOperadorFk
     */
    public function setCodigoOperadorFk($codigoOperadorFk): void
    {
        $this->codigoOperadorFk = $codigoOperadorFk;
    }

    /**
     * @return mixed
     */
    public function getOperadorRel()
    {
        return $this->operadorRel;
    }

    /**
     * @param mixed $operadorRel
     */
    public function setOperadorRel($operadorRel): void
    {
        $this->operadorRel = $operadorRel;
    }



}