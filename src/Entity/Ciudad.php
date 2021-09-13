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
     * @ORM\OneToMany(targetEntity="App\Entity\Panal", mappedBy="ciudadRel")
     */
    private $panalesCiudadRel;

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



}