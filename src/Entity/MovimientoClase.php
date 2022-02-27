<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovimientoClaseRepository")
 */
class MovimientoClase
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="codigo_movimiento_clase_pk", type="string", length=3, unique=true)
     */
    private $codigoMovimientoClasePk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movimiento", mappedBy="movimientoClaseRel")
     */
    private $movimientosMovimientoClaseRel;

    /**
     * @return mixed
     */
    public function getCodigoMovimientoClasePk()
    {
        return $this->codigoMovimientoClasePk;
    }

    /**
     * @param mixed $codigoMovimientoClasePk
     */
    public function setCodigoMovimientoClasePk($codigoMovimientoClasePk): void
    {
        $this->codigoMovimientoClasePk = $codigoMovimientoClasePk;
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
    public function getMovimientosMovimientoClaseRel()
    {
        return $this->movimientosMovimientoClaseRel;
    }

    /**
     * @param mixed $movimientosMovimientoClaseRel
     */
    public function setMovimientosMovimientoClaseRel($movimientosMovimientoClaseRel): void
    {
        $this->movimientosMovimientoClaseRel = $movimientosMovimientoClaseRel;
    }


}