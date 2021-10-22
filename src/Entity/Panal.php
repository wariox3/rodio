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
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */
    private $codigoCiudadFk;

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



}