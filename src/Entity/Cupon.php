<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CuponRepository")
 */
class Cupon
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_cupon_pk", type="string", length=30, unique=true)
     */
    private $codigoCuponPk;

    /**
     * @ORM\Column(name="vr_valor", type="float", options={"default" : 0})
     */
    private $vrValor = 0.0;

    /**
     * @ORM\Column(name="estado_aplicado", type="boolean", options={"default" : false})
     */
    private $estadoAplicado = false;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer", nullable=true)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="fecha_aplicacion", type="datetime", nullable=true)
     */
    private $fechaAplicacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="cuponesUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @return mixed
     */
    public function getCodigoCuponPk()
    {
        return $this->codigoCuponPk;
    }

    /**
     * @param mixed $codigoCuponPk
     */
    public function setCodigoCuponPk($codigoCuponPk): void
    {
        $this->codigoCuponPk = $codigoCuponPk;
    }

    /**
     * @return float
     */
    public function getVrValor(): float
    {
        return $this->vrValor;
    }

    /**
     * @param float $vrValor
     */
    public function setVrValor(float $vrValor): void
    {
        $this->vrValor = $vrValor;
    }

    /**
     * @return bool
     */
    public function isEstadoAplicado(): bool
    {
        return $this->estadoAplicado;
    }

    /**
     * @param bool $estadoAplicado
     */
    public function setEstadoAplicado(bool $estadoAplicado): void
    {
        $this->estadoAplicado = $estadoAplicado;
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
    public function getFechaAplicacion()
    {
        return $this->fechaAplicacion;
    }

    /**
     * @param mixed $fechaAplicacion
     */
    public function setFechaAplicacion($fechaAplicacion): void
    {
        $this->fechaAplicacion = $fechaAplicacion;
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