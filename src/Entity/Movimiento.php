<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovimientoRepository")
 */
class Movimiento
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_movimiento_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoMovimientoPk;

    /**
     * @ORM\Column(name="codigo_movimiento_clase_fk", type="string", length=3)
     */
    private $codigoMovimientoClaseFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer")
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="codigo_direccion_fk", type="integer")
     */
    private $codigoDireccionFk;

    /**
     * @ORM\Column(name="estado_aprobado", type="boolean", options={"default" : false}, nullable=true)
     */
    private $estadoAprobado = false;

    /**
     * @ORM\Column(name="estado_entregado", type="boolean", options={"default" : false}, nullable=true)
     */
    private $estadoEntregado = false;

    /**
     * @ORM\Column(name="comentario", type="string", length=500, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MovimientoClase", inversedBy="movimientosMovimientoClaseRel")
     * @ORM\JoinColumn(name="codigo_movimiento_clase_fk", referencedColumnName="codigo_movimiento_clase_pk")
     */
    private $movimientoClaseRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="movimientosUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Direccion", inversedBy="movimientosDireccionRel")
     * @ORM\JoinColumn(name="codigo_direccion_fk", referencedColumnName="codigo_direccion_pk")
     */
    private $direccionRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MovimientoDetalle", mappedBy="movimientoRel")
     */
    private $movimientosDetallesMovimientoRel;

    /**
     * @return mixed
     */
    public function getCodigoMovimientoPk()
    {
        return $this->codigoMovimientoPk;
    }

    /**
     * @param mixed $codigoMovimientoPk
     */
    public function setCodigoMovimientoPk($codigoMovimientoPk): void
    {
        $this->codigoMovimientoPk = $codigoMovimientoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoMovimientoClaseFk()
    {
        return $this->codigoMovimientoClaseFk;
    }

    /**
     * @param mixed $codigoMovimientoClaseFk
     */
    public function setCodigoMovimientoClaseFk($codigoMovimientoClaseFk): void
    {
        $this->codigoMovimientoClaseFk = $codigoMovimientoClaseFk;
    }

    /**
     * @return mixed
     */
    public function getMovimientoClaseRel()
    {
        return $this->movimientoClaseRel;
    }

    /**
     * @param mixed $movimientoClaseRel
     */
    public function setMovimientoClaseRel($movimientoClaseRel): void
    {
        $this->movimientoClaseRel = $movimientoClaseRel;
    }

    /**
     * @return mixed
     */
    public function getMovimientosDetallesMovimientoRel()
    {
        return $this->movimientosDetallesMovimientoRel;
    }

    /**
     * @param mixed $movimientosDetallesMovimientoRel
     */
    public function setMovimientosDetallesMovimientoRel($movimientosDetallesMovimientoRel): void
    {
        $this->movimientosDetallesMovimientoRel = $movimientosDetallesMovimientoRel;
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

    /**
     * @return bool
     */
    public function isEstadoAprobado(): bool
    {
        return $this->estadoAprobado;
    }

    /**
     * @param bool $estadoAprobado
     */
    public function setEstadoAprobado(bool $estadoAprobado): void
    {
        $this->estadoAprobado = $estadoAprobado;
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
    public function getCodigoDireccionFk()
    {
        return $this->codigoDireccionFk;
    }

    /**
     * @param mixed $codigoDireccionFk
     */
    public function setCodigoDireccionFk($codigoDireccionFk): void
    {
        $this->codigoDireccionFk = $codigoDireccionFk;
    }

    /**
     * @return mixed
     */
    public function getDireccionRel()
    {
        return $this->direccionRel;
    }

    /**
     * @param mixed $direccionRel
     */
    public function setDireccionRel($direccionRel): void
    {
        $this->direccionRel = $direccionRel;
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


}