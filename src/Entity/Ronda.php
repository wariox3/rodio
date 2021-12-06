<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RondaRepository")
 */
class Ronda
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_ronda_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoRondaPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_puesto_fk", type="integer")
     */
    private $codigoPuestoFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Puesto", inversedBy="rondasPuestoRel")
     * @ORM\JoinColumn(name="codigo_puesto_fk", referencedColumnName="codigo_puesto_pk")
     */
    private $puestoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Punto", mappedBy="rondaRel")
     */
    private $puntosRondaRel;

    /**
     * @return mixed
     */
    public function getCodigoRondaPk()
    {
        return $this->codigoRondaPk;
    }

    /**
     * @param mixed $codigoRondaPk
     */
    public function setCodigoRondaPk($codigoRondaPk): void
    {
        $this->codigoRondaPk = $codigoRondaPk;
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
    public function getPuestoRel()
    {
        return $this->puestoRel;
    }

    /**
     * @param mixed $puestoRel
     */
    public function setPuestoRel($puestoRel): void
    {
        $this->puestoRel = $puestoRel;
    }

    /**
     * @return mixed
     */
    public function getPuntosRondaRel()
    {
        return $this->puntosRondaRel;
    }

    /**
     * @param mixed $puntosRondaRel
     */
    public function setPuntosRondaRel($puntosRondaRel): void
    {
        $this->puntosRondaRel = $puntosRondaRel;
    }



}