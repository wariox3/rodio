<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoRepository")
 */
class Evento
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_evento_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoEventoPk;

    /**
     * @ORM\Column(name="codigo_evento_tipo_fk", type="string", length=10)
     */
    private $codigoEventoTipoFk;

    /**
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(name="codigo_puesto_fk", type="string", length=20)
     */
    private $codigoPuestoFk;

    /**
     * @ORM\Column(name="codigo_efecto_fk", type="string", length=20)
     */
    private $codigoEfectoFk;

    /**
     * @ORM\Column(name="comentario", type="string", length=250, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="codigo_operador_fk", type="integer")
     */
    private $codigoOperadorFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventoTipo", inversedBy="eventosEventoTipoRel")
     * @ORM\JoinColumn(name="codigo_evento_tipo_fk", referencedColumnName="codigo_evento_tipo_pk")
     */
    private $eventoTipoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Operador", inversedBy="eventosOperadorRel")
     * @ORM\JoinColumn(name="codigo_operador_fk", referencedColumnName="codigo_operador_pk")
     */
    private $operadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Efecto", inversedBy="eventosEfectoRel")
     * @ORM\JoinColumn(name="codigo_efecto_fk", referencedColumnName="codigo_efecto_pk")
     */
    private $efectoRel;

    /**
     * @return mixed
     */
    public function getCodigoEventoPk()
    {
        return $this->codigoEventoPk;
    }

    /**
     * @param mixed $codigoEventoPk
     */
    public function setCodigoEventoPk($codigoEventoPk): void
    {
        $this->codigoEventoPk = $codigoEventoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEventoTipoFk()
    {
        return $this->codigoEventoTipoFk;
    }

    /**
     * @param mixed $codigoEventoTipoFk
     */
    public function setCodigoEventoTipoFk($codigoEventoTipoFk): void
    {
        $this->codigoEventoTipoFk = $codigoEventoTipoFk;
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
    public function getCodigoEfectoFk()
    {
        return $this->codigoEfectoFk;
    }

    /**
     * @param mixed $codigoEfectoFk
     */
    public function setCodigoEfectoFk($codigoEfectoFk): void
    {
        $this->codigoEfectoFk = $codigoEfectoFk;
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
    public function getEventoTipoRel()
    {
        return $this->eventoTipoRel;
    }

    /**
     * @param mixed $eventoTipoRel
     */
    public function setEventoTipoRel($eventoTipoRel): void
    {
        $this->eventoTipoRel = $eventoTipoRel;
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

    /**
     * @return mixed
     */
    public function getEfectoRel()
    {
        return $this->efectoRel;
    }

    /**
     * @param mixed $efectoRel
     */
    public function setEfectoRel($efectoRel): void
    {
        $this->efectoRel = $efectoRel;
    }



}