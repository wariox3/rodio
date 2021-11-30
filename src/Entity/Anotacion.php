<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnotacionRepository")
 */
class Anotacion
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_anotacion_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoAnotacionPk;

    /**
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(name="comentario", type="string", length=250, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="codigo_puesto_fk", type="integer", nullable=true)
     */
    private $codigoPuestoFk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer", nullable=false)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="codigo_anotacion_tipo_fk", type="string", length=10)
     */
    private $codigoAnotacionTipoFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="anotacionesUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AnotacionTipo", inversedBy="anotacionesAnotacionTipoRel")
     * @ORM\JoinColumn(name="codigo_anotacion_tipo_fk", referencedColumnName="codigo_anotacion_tipo_pk")
     */
    private $anotacionTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoAnotacionPk()
    {
        return $this->codigoAnotacionPk;
    }

    /**
     * @param mixed $codigoAnotacionPk
     */
    public function setCodigoAnotacionPk($codigoAnotacionPk): void
    {
        $this->codigoAnotacionPk = $codigoAnotacionPk;
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


}