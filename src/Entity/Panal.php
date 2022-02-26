<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PanalRepository")
 */
class Panal
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_panal_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoPanalPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(name="direccion", type="string", length=300)
     */
    private $direccion;

    /**
     * @ORM\Column(name="correo", type="string", length=100)
     */
    private $correo;

    /**
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */
    private $codigoCiudadFk;

    /**
     * @ORM\Column(name="publicacion_aprobar", type="boolean", options={"default" : true}, nullable=true)
     */
    private $publicacionAprobar = true;

    /**
     * @ORM\Column(name="exige_celda", type="boolean", options={"default" : true})
     */
    private $exigeCelda = true;


    /**
     * @ORM\Column(name="tienda", type="boolean", options={"default" : true})
     */
    private $tienda = true;


    /**
     * @ORM\Column(name="oferta", type="boolean", options={"default" : true})
     */
    private $oferta = true;

    /**
     * @ORM\Column(name="coeficiente", type="float", options={"default" : 0})
     */
    private $coeficiente = 0.0;

    /**
     * @ORM\Column(name="area", type="float", options={"default" : 0})
     */
    private $area = 0.0;

    /**
     * @ORM\Column(name="cantidad", type="float", options={"default" : 0})
     */
    private $cantidad = 0.0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciudad", inversedBy="panalesCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_fk", referencedColumnName="codigo_ciudad_pk")
     */
    private $ciudadRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Celda", mappedBy="panalRel")
     */
    private $celdasPanalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuario", mappedBy="panalRel")
     */
    private $usuariosPanalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Publicacion", mappedBy="panalRel")
     */
    private $publicacionesPanalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Oferta", mappedBy="panalRel")
     */
    private $ofertasPanalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Votacion", mappedBy="panalRel")
     */
    private $votacionesPanalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reserva", mappedBy="panalRel")
     */
    private $reservasPanalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contenido", mappedBy="panalRel")
     */
    private $contenidosPanalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Caso", mappedBy="panalRel")
     */
    private $casosPanalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visita", mappedBy="panalRel")
     */
    private $visitasPanalRel;

    /**
     * @return mixed
     */
    public function getCodigoPanalPk()
    {
        return $this->codigoPanalPk;
    }

    /**
     * @param mixed $codigoPanalPk
     */
    public function setCodigoPanalPk($codigoPanalPk): void
    {
        $this->codigoPanalPk = $codigoPanalPk;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadFk()
    {
        return $this->codigoCiudadFk;
    }

    /**
     * @param mixed $codigoCiudadFk
     */
    public function setCodigoCiudadFk($codigoCiudadFk): void
    {
        $this->codigoCiudadFk = $codigoCiudadFk;
    }

    /**
     * @return mixed
     */
    public function getCiudadRel()
    {
        return $this->ciudadRel;
    }

    /**
     * @param mixed $ciudadRel
     */
    public function setCiudadRel($ciudadRel): void
    {
        $this->ciudadRel = $ciudadRel;
    }

    /**
     * @return mixed
     */
    public function getCeldasPanalRel()
    {
        return $this->celdasPanalRel;
    }

    /**
     * @param mixed $celdasPanalRel
     */
    public function setCeldasPanalRel($celdasPanalRel): void
    {
        $this->celdasPanalRel = $celdasPanalRel;
    }

    /**
     * @return mixed
     */
    public function getUsuariosPanalRel()
    {
        return $this->usuariosPanalRel;
    }

    /**
     * @param mixed $usuariosPanalRel
     */
    public function setUsuariosPanalRel($usuariosPanalRel): void
    {
        $this->usuariosPanalRel = $usuariosPanalRel;
    }

    /**
     * @return mixed
     */
    public function getPublicacionesPanalRel()
    {
        return $this->publicacionesPanalRel;
    }

    /**
     * @param mixed $publicacionesPanalRel
     */
    public function setPublicacionesPanalRel($publicacionesPanalRel): void
    {
        $this->publicacionesPanalRel = $publicacionesPanalRel;
    }

    /**
     * @return mixed
     */
    public function getOfertasPanalRel()
    {
        return $this->ofertasPanalRel;
    }

    /**
     * @param mixed $ofertasPanalRel
     */
    public function setOfertasPanalRel($ofertasPanalRel): void
    {
        $this->ofertasPanalRel = $ofertasPanalRel;
    }

    /**
     * @return mixed
     */
    public function getVotacionesPanalRel()
    {
        return $this->votacionesPanalRel;
    }

    /**
     * @param mixed $votacionesPanalRel
     */
    public function setVotacionesPanalRel($votacionesPanalRel): void
    {
        $this->votacionesPanalRel = $votacionesPanalRel;
    }

    /**
     * @return mixed
     */
    public function getReservasPanalRel()
    {
        return $this->reservasPanalRel;
    }

    /**
     * @param mixed $reservasPanalRel
     */
    public function setReservasPanalRel($reservasPanalRel): void
    {
        $this->reservasPanalRel = $reservasPanalRel;
    }

    /**
     * @return mixed
     */
    public function getContenidosPanalRel()
    {
        return $this->contenidosPanalRel;
    }

    /**
     * @param mixed $contenidosPanalRel
     */
    public function setContenidosPanalRel($contenidosPanalRel): void
    {
        $this->contenidosPanalRel = $contenidosPanalRel;
    }

    /**
     * @return bool
     */
    public function isPublicacionAprobar(): bool
    {
        return $this->publicacionAprobar;
    }

    /**
     * @param bool $publicacionAprobar
     */
    public function setPublicacionAprobar(bool $publicacionAprobar): void
    {
        $this->publicacionAprobar = $publicacionAprobar;
    }

    /**
     * @return mixed
     */
    public function getCasosPanalRel()
    {
        return $this->casosPanalRel;
    }

    /**
     * @param mixed $casosPanalRel
     */
    public function setCasosPanalRel($casosPanalRel): void
    {
        $this->casosPanalRel = $casosPanalRel;
    }

    /**
     * @return bool
     */
    public function isExigeCelda(): bool
    {
        return $this->exigeCelda;
    }

    /**
     * @param bool $exigeCelda
     */
    public function setExigeCelda(bool $exigeCelda): void
    {
        $this->exigeCelda = $exigeCelda;
    }

    /**
     * @return mixed
     */
    public function getVisitasPanalRel()
    {
        return $this->visitasPanalRel;
    }

    /**
     * @param mixed $visitasPanalRel
     */
    public function setVisitasPanalRel($visitasPanalRel): void
    {
        $this->visitasPanalRel = $visitasPanalRel;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return float
     */
    public function getCoeficiente(): float
    {
        return $this->coeficiente;
    }

    /**
     * @param float $coeficiente
     */
    public function setCoeficiente(float $coeficiente): void
    {
        $this->coeficiente = $coeficiente;
    }

    /**
     * @return float
     */
    public function getArea(): float
    {
        return $this->area;
    }

    /**
     * @param float $area
     */
    public function setArea(float $area): void
    {
        $this->area = $area;
    }

    /**
     * @return bool
     */
    public function isTienda(): bool
    {
        return $this->tienda;
    }

    /**
     * @param bool $tienda
     */
    public function setTienda(bool $tienda): void
    {
        $this->tienda = $tienda;
    }

    /**
     * @return bool
     */
    public function isOferta(): bool
    {
        return $this->oferta;
    }

    /**
     * @param bool $oferta
     */
    public function setOferta(bool $oferta): void
    {
        $this->oferta = $oferta;
    }

    /**
     * @return float
     */
    public function getCantidad(): float
    {
        return $this->cantidad;
    }

    /**
     * @param float $cantidad
     */
    public function setCantidad(float $cantidad): void
    {
        $this->cantidad = $cantidad;
    }



}