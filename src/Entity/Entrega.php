<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntregaRepository")
 */
class Entrega
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_entrega_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoEntregaPk;

    /**
     * @ORM\Column(name="codigo_celda_fk", type="integer", nullable=false)
     */
    private $codigoCeldaFk;

    /**
     * @ORM\Column(name="fecha_ingreso", type="datetime", nullable=true)
     */
    private $fechaIngreso;

    /**
     * @ORM\Column(name="codigo_entrega_tipo_fk", type="string", length=30)
     */
    private $codigoEntregaTipoFk;

    /**
     * @ORM\Column(name="entrega", type="string", length=100, nullable=true)
     */
    private $entrega;

    /**
     * @ORM\Column(name="descripcion", type="string", length=200, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="estado_notificado", type="boolean", options={"default" : false}, nullable=true)
     */
    private $estadoNotificado = false;

    /**
     * @ORM\Column(name="estado_entregado", type="boolean", options={"default" : false}, nullable=true)
     */
    private $estadoEntregado = false;

    /**
     * @ORM\Column(name="estado_autorizado", type="string", options={"default" : "P"})
     */
    private $estadoAutorizado = "P";

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Celda", inversedBy="entregasCeldaRel")
     * @ORM\JoinColumn(name="codigo_celda_fk", referencedColumnName="codigo_celda_pk")
     */
    private $celdaRel;

    /**
     * @return mixed
     */
    public function getCodigoEntregaPk()
    {
        return $this->codigoEntregaPk;
    }

    /**
     * @param mixed $codigoEntregaPk
     */
    public function setCodigoEntregaPk($codigoEntregaPk): void
    {
        $this->codigoEntregaPk = $codigoEntregaPk;
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
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * @param mixed $fechaIngreso
     */
    public function setFechaIngreso($fechaIngreso): void
    {
        $this->fechaIngreso = $fechaIngreso;
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
     * @return bool
     */
    public function isEstadoNotificado(): bool
    {
        return $this->estadoNotificado;
    }

    /**
     * @param bool $estadoNotificado
     */
    public function setEstadoNotificado(bool $estadoNotificado): void
    {
        $this->estadoNotificado = $estadoNotificado;
    }

    /**
     * @return bool
     */
    public function isEstadoEntregado(): bool
    {
        return $this->estadoEntregado;
    }

    /**
     * @param bool $estadoEntregado
     */
    public function setEstadoEntregado(bool $estadoEntregado): void
    {
        $this->estadoEntregado = $estadoEntregado;
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

    /**
     * @return mixed
     */
    public function getCodigoEntregaTipoFk()
    {
        return $this->codigoEntregaTipoFk;
    }

    /**
     * @param mixed $codigoEntregaTipoFk
     */
    public function setCodigoEntregaTipoFk($codigoEntregaTipoFk): void
    {
        $this->codigoEntregaTipoFk = $codigoEntregaTipoFk;
    }

    /**
     * @return string
     */
    public function getEstadoAutorizado(): string
    {
        return $this->estadoAutorizado;
    }

    /**
     * @param string $estadoAutorizado
     */
    public function setEstadoAutorizado(string $estadoAutorizado): void
    {
        $this->estadoAutorizado = $estadoAutorizado;
    }

    /**
     * @return mixed
     */
    public function getEntrega()
    {
        return $this->entrega;
    }

    /**
     * @param mixed $entrega
     */
    public function setEntrega($entrega): void
    {
        $this->entrega = $entrega;
    }



}