<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CasoRepository")
 */
class Caso
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_caso_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCasoPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_atendido", type="datetime", nullable=true)
     */
    private $fechaAtendido;

    /**
     * @ORM\Column(name="codigo_caso_tipo_fk", type="string", length=20)
     */
    private $codigoCasoTipoFk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer", nullable=false)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="comentario", type="text", nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="codigo_panal_fk", type="integer")
     */
    private $codigoPanalFk;

    /**
     * @ORM\Column(name="estado_atendido", type="boolean", options={"default" : false}, nullable=true)
     */
    private $estadoAtendido = false;

    /**
     * @ORM\Column(name="estado_cerrado", type="boolean", options={"default" : false}, nullable=true)
     */
    private $estadoCerrado = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CasoTipo", inversedBy="casosCasoTipoRel")
     * @ORM\JoinColumn(name="codigo_caso_tipo_fk", referencedColumnName="codigo_caso_tipo_pk")
     */
    private $casoTipoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panal", inversedBy="casosPanalRel")
     * @ORM\JoinColumn(name="codigo_panal_fk", referencedColumnName="codigo_panal_pk")
     */
    private $panalRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="casosUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CasoComentario", mappedBy="casoRel")
     */
    private $casosComentariosCasoRel;

    /**
     * @return mixed
     */
    public function getCodigoCasoPk()
    {
        return $this->codigoCasoPk;
    }

    /**
     * @param mixed $codigoCasoPk
     */
    public function setCodigoCasoPk($codigoCasoPk): void
    {
        $this->codigoCasoPk = $codigoCasoPk;
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
    public function getFechaAtendido()
    {
        return $this->fechaAtendido;
    }

    /**
     * @param mixed $fechaAtendido
     */
    public function setFechaAtendido($fechaAtendido): void
    {
        $this->fechaAtendido = $fechaAtendido;
    }

    /**
     * @return mixed
     */
    public function getCodigoCasoTipoFk()
    {
        return $this->codigoCasoTipoFk;
    }

    /**
     * @param mixed $codigoCasoTipoFk
     */
    public function setCodigoCasoTipoFk($codigoCasoTipoFk): void
    {
        $this->codigoCasoTipoFk = $codigoCasoTipoFk;
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
     * @return bool
     */
    public function isEstadoAtendido(): bool
    {
        return $this->estadoAtendido;
    }

    /**
     * @param bool $estadoAtendido
     */
    public function setEstadoAtendido(bool $estadoAtendido): void
    {
        $this->estadoAtendido = $estadoAtendido;
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
    public function getCasoTipoRel()
    {
        return $this->casoTipoRel;
    }

    /**
     * @param mixed $casoTipoRel
     */
    public function setCasoTipoRel($casoTipoRel): void
    {
        $this->casoTipoRel = $casoTipoRel;
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
     * @return mixed
     */
    public function getCasosComentariosCasoRel()
    {
        return $this->casosComentariosCasoRel;
    }

    /**
     * @param mixed $casosComentariosCasoRel
     */
    public function setCasosComentariosCasoRel($casosComentariosCasoRel): void
    {
        $this->casosComentariosCasoRel = $casosComentariosCasoRel;
    }



}