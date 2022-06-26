<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GuiaRepository")
 */
class Guia
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_guia_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoGuiaPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="codigo_operador_fk", type="integer")
     */
    private $codigoOperadorFk;

    /**
     * @ORM\Column(name="codigo_guia", type="integer")
     */
    private $codigoGuia;

    /**
     * @ORM\Column(name="codigo_seguimiento_tipo_fk", type="string", length=20)
     */
    private $codigoSeguimientoTipoFk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer", nullable=true)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="estado_error", type="boolean", options={"default" : false}, nullable=true)
     */
    private $estadoError = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Operador", inversedBy="guiasOperadorRel")
     * @ORM\JoinColumn(name="codigo_operador_fk", referencedColumnName="codigo_operador_pk")
     */
    private $operadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="guiasUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @return mixed
     */
    public function getCodigoGuiaPk()
    {
        return $this->codigoGuiaPk;
    }

    /**
     * @param mixed $codigoGuiaPk
     */
    public function setCodigoGuiaPk($codigoGuiaPk): void
    {
        $this->codigoGuiaPk = $codigoGuiaPk;
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
    public function getCodigoGuia()
    {
        return $this->codigoGuia;
    }

    /**
     * @param mixed $codigoGuia
     */
    public function setCodigoGuia($codigoGuia): void
    {
        $this->codigoGuia = $codigoGuia;
    }

    /**
     * @return mixed
     */
    public function getCodigoSeguimientoTipoFk()
    {
        return $this->codigoSeguimientoTipoFk;
    }

    /**
     * @param mixed $codigoSeguimientoTipoFk
     */
    public function setCodigoSeguimientoTipoFk($codigoSeguimientoTipoFk): void
    {
        $this->codigoSeguimientoTipoFk = $codigoSeguimientoTipoFk;
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
    public function isEstadoError(): bool
    {
        return $this->estadoError;
    }

    /**
     * @param bool $estadoError
     */
    public function setEstadoError(bool $estadoError): void
    {
        $this->estadoError = $estadoError;
    }


}