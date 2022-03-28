<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ViajeRepository")
 */
class Viaje
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_viaje_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoViajePk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_cargue", type="datetime", nullable=true)
     */
    private $fechaCargue;

    /**
     * @ORM\Column(name="vr_flete", type="float", options={"default" : 0})
     */
    private $vrFlete = 0.0;

    /**
     * @ORM\Column(name="codigo_ciudad_origen_fk", type="integer", nullable=true)
     */
    private $codigoCiudadOrigenFk;

    /**
     * @ORM\Column(name="codigo_ciudad_destino_fk", type="integer", nullable=true)
     */
    private $codigoCiudadDestinoFk;

    /**
     * @ORM\Column(name="cantidad_clientes", type="integer", options={"default" : 0})
     */
    private $cantidadClientes = 0;

    /**
     * @ORM\Column(name="comentarios", type="string", length=300, nullable=true)
     */
    private $comentarios;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciudad", inversedBy="viajesCiudadOrigenRel")
     * @ORM\JoinColumn(name="codigo_ciudad_origen_fk", referencedColumnName="codigo_ciudad_pk")
     */
    private $ciudadOrigenRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciudad", inversedBy="viajesCiudadDestinoRel")
     * @ORM\JoinColumn(name="codigo_ciudad_destino_fk", referencedColumnName="codigo_ciudad_pk")
     */
    private $ciudadDestinoRel;

    /**
     * @return mixed
     */
    public function getCodigoViajePk()
    {
        return $this->codigoViajePk;
    }

    /**
     * @param mixed $codigoViajePk
     */
    public function setCodigoViajePk($codigoViajePk): void
    {
        $this->codigoViajePk = $codigoViajePk;
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
    public function getFechaCargue()
    {
        return $this->fechaCargue;
    }

    /**
     * @param mixed $fechaCargue
     */
    public function setFechaCargue($fechaCargue): void
    {
        $this->fechaCargue = $fechaCargue;
    }

    /**
     * @return float
     */
    public function getVrFlete(): float
    {
        return $this->vrFlete;
    }

    /**
     * @param float $vrFlete
     */
    public function setVrFlete(float $vrFlete): void
    {
        $this->vrFlete = $vrFlete;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadOrigenFk()
    {
        return $this->codigoCiudadOrigenFk;
    }

    /**
     * @param mixed $codigoCiudadOrigenFk
     */
    public function setCodigoCiudadOrigenFk($codigoCiudadOrigenFk): void
    {
        $this->codigoCiudadOrigenFk = $codigoCiudadOrigenFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadDestinoFk()
    {
        return $this->codigoCiudadDestinoFk;
    }

    /**
     * @param mixed $codigoCiudadDestinoFk
     */
    public function setCodigoCiudadDestinoFk($codigoCiudadDestinoFk): void
    {
        $this->codigoCiudadDestinoFk = $codigoCiudadDestinoFk;
    }

    /**
     * @return int
     */
    public function getCantidadClientes(): int
    {
        return $this->cantidadClientes;
    }

    /**
     * @param int $cantidadClientes
     */
    public function setCantidadClientes(int $cantidadClientes): void
    {
        $this->cantidadClientes = $cantidadClientes;
    }

    /**
     * @return mixed
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * @param mixed $comentarios
     */
    public function setComentarios($comentarios): void
    {
        $this->comentarios = $comentarios;
    }

    /**
     * @return mixed
     */
    public function getCiudadOrigenRel()
    {
        return $this->ciudadOrigenRel;
    }

    /**
     * @param mixed $ciudadOrigenRel
     */
    public function setCiudadOrigenRel($ciudadOrigenRel): void
    {
        $this->ciudadOrigenRel = $ciudadOrigenRel;
    }

    /**
     * @return mixed
     */
    public function getCiudadDestinoRel()
    {
        return $this->ciudadDestinoRel;
    }

    /**
     * @param mixed $ciudadDestinoRel
     */
    public function setCiudadDestinoRel($ciudadDestinoRel): void
    {
        $this->ciudadDestinoRel = $ciudadDestinoRel;
    }


}