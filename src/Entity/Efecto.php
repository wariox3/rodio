<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EfectoRepository")
 */
class Efecto
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_efecto_pk", type="string", length=20, nullable=false, unique=true)
     */
    private $codigoEfectoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evento", mappedBy="efectoRel")
     */
    private $eventosEfectoRel;

    /**
     * @return mixed
     */
    public function getCodigoEfectoPk()
    {
        return $this->codigoEfectoPk;
    }

    /**
     * @param mixed $codigoEfectoPk
     */
    public function setCodigoEfectoPk($codigoEfectoPk): void
    {
        $this->codigoEfectoPk = $codigoEfectoPk;
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
    public function getEventosEfectoRel()
    {
        return $this->eventosEfectoRel;
    }

    /**
     * @param mixed $eventosEfectoRel
     */
    public function setEventosEfectoRel($eventosEfectoRel): void
    {
        $this->eventosEfectoRel = $eventosEfectoRel;
    }

    /**
     * @return int
     */
    public function getOrden(): int
    {
        return $this->orden;
    }

    /**
     * @param int $orden
     */
    public function setOrden(int $orden): void
    {
        $this->orden = $orden;
    }



}