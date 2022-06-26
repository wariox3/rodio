<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DespachoRepository")
 */
class Despacho
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_despacho_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoDespachoPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="codigo_operador_fk", type="integer")
     */
    private $codigoOperadorFk;

    /**
     * @ORM\Column(name="codigo_despacho", type="integer")
     */
    private $codigoDespacho;

    /**
     * @ORM\Column(name="token", type="string", length=10)
     */
    private $token;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer", nullable=true)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="codigo_despacho_clase_fk", type="string", length=5, nullable=true)
     */
    private $codigoDespachoClaseFk;

    /**
     * @ORM\Column(name="fecha_despacho", type="datetime", nullable=true)
     */
    private $fechaDespacho;

    /**
     * @ORM\Column(name="estado_entregado", type="boolean", options={"default" : false})
     */
    private $estadoEntregado = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Operador", inversedBy="despachosOperadorRel")
     * @ORM\JoinColumn(name="codigo_operador_fk", referencedColumnName="codigo_operador_pk")
     */
    private $operadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="despachosUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ubicacion", mappedBy="despachoRel")
     */
    private $ubicacionesDespachoRel;

    /**
     * @return mixed
     */
    public function getCodigoDespachoPk()
    {
        return $this->codigoDespachoPk;
    }

    /**
     * @param mixed $codigoDespachoPk
     */
    public function setCodigoDespachoPk($codigoDespachoPk): void
    {
        $this->codigoDespachoPk = $codigoDespachoPk;
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
    public function getCodigoDespacho()
    {
        return $this->codigoDespacho;
    }

    /**
     * @param mixed $codigoDespacho
     */
    public function setCodigoDespacho($codigoDespacho): void
    {
        $this->codigoDespacho = $codigoDespacho;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
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
     * @return mixed
     */
    public function getCodigoDespachoClaseFk()
    {
        return $this->codigoDespachoClaseFk;
    }

    /**
     * @param mixed $codigoDespachoClaseFk
     */
    public function setCodigoDespachoClaseFk($codigoDespachoClaseFk): void
    {
        $this->codigoDespachoClaseFk = $codigoDespachoClaseFk;
    }

    /**
     * @return mixed
     */
    public function getFechaDespacho()
    {
        return $this->fechaDespacho;
    }

    /**
     * @param mixed $fechaDespacho
     */
    public function setFechaDespacho($fechaDespacho): void
    {
        $this->fechaDespacho = $fechaDespacho;
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
    public function getUbicacionesDespachoRel()
    {
        return $this->ubicacionesDespachoRel;
    }

    /**
     * @param mixed $ubicacionesDespachoRel
     */
    public function setUbicacionesDespachoRel($ubicacionesDespachoRel): void
    {
        $this->ubicacionesDespachoRel = $ubicacionesDespachoRel;
    }



}