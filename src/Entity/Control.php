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
     * @ORM\Column(name="codigo_usuario_fk", type="integer", nullable=false)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="codigo_puesto_fk", type="integer", nullable=false)
     */
    private $codigoPuestoFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_control", type="datetime", nullable=true)
     */
    private $fechaControl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="controlUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

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
    public function getCodigoUsuarioFk()
    {
        return $this->codigoUsuarioFk;
    }

    /**
     * @param mixed $codigoUsuarioFk
     */
    public function setCodigoUsuarioFk($codigoUsuarioFk): void
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;
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
    public function getUsuarioRel()
    {
        return $this->usuarioRel;
    }

    /**
     * @param mixed $usuarioRel
     */
    public function setUsuarioRel($usuarioRel): void
    {
        $this->usuarioRel = $usuarioRel;
    }

}