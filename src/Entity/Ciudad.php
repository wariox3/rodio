<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CiudadRepository")
 */
class Ciudad
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_ciudad_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCiudadPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_departamento_fk", type="integer", nullable=true)
     */
    private $codigoDepartamentoFk;

    /**
     * @ORM\Column(name="codigo_interface", type="string", length=20, nullable=true)
     */
    private $codigoInterface;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departamento", inversedBy="ciudadesDepartamentoRel")
     * @ORM\JoinColumn(name="codigo_departamento_fk", referencedColumnName="codigo_departamento_pk")
     */
    private $departamentoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Panal", mappedBy="ciudadRel")
     */
    private $panalesCiudadRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuario", mappedBy="ciudadRel")
     */
    private $usuariosCiudadRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Viaje", mappedBy="ciudadOrigenRel")
     */
    private $viajesCiudadOrigenRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Viaje", mappedBy="ciudadDestinoRel")
     */
    private $viajesCiudadDestinoRel;

    /**
     * @return mixed
     */
    public function getCodigoCiudadPk()
    {
        return $this->codigoCiudadPk;
    }

    /**
     * @param mixed $codigoCiudadPk
     */
    public function setCodigoCiudadPk($codigoCiudadPk): void
    {
        $this->codigoCiudadPk = $codigoCiudadPk;
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
    public function getPanalesCiudadRel()
    {
        return $this->panalesCiudadRel;
    }

    /**
     * @param mixed $panalesCiudadRel
     */
    public function setPanalesCiudadRel($panalesCiudadRel): void
    {
        $this->panalesCiudadRel = $panalesCiudadRel;
    }

    /**
     * @return mixed
     */
    public function getUsuariosCiudadRel()
    {
        return $this->usuariosCiudadRel;
    }

    /**
     * @param mixed $usuariosCiudadRel
     */
    public function setUsuariosCiudadRel($usuariosCiudadRel): void
    {
        $this->usuariosCiudadRel = $usuariosCiudadRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoDepartamentoFk()
    {
        return $this->codigoDepartamentoFk;
    }

    /**
     * @param mixed $codigoDepartamentoFk
     */
    public function setCodigoDepartamentoFk($codigoDepartamentoFk): void
    {
        $this->codigoDepartamentoFk = $codigoDepartamentoFk;
    }

    /**
     * @return mixed
     */
    public function getDepartamentoRel()
    {
        return $this->departamentoRel;
    }

    /**
     * @param mixed $departamentoRel
     */
    public function setDepartamentoRel($departamentoRel): void
    {
        $this->departamentoRel = $departamentoRel;
    }

    /**
     * @return mixed
     */
    public function getViajesCiudadOrigenRel()
    {
        return $this->viajesCiudadOrigenRel;
    }

    /**
     * @param mixed $viajesCiudadOrigenRel
     */
    public function setViajesCiudadOrigenRel($viajesCiudadOrigenRel): void
    {
        $this->viajesCiudadOrigenRel = $viajesCiudadOrigenRel;
    }

    /**
     * @return mixed
     */
    public function getViajesCiudadDestinoRel()
    {
        return $this->viajesCiudadDestinoRel;
    }

    /**
     * @param mixed $viajesCiudadDestinoRel
     */
    public function setViajesCiudadDestinoRel($viajesCiudadDestinoRel): void
    {
        $this->viajesCiudadDestinoRel = $viajesCiudadDestinoRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoInterface()
    {
        return $this->codigoInterface;
    }

    /**
     * @param mixed $codigoInterface
     */
    public function setCodigoInterface($codigoInterface): void
    {
        $this->codigoInterface = $codigoInterface;
    }



}