<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VotacionDetalleRepository")
 */
class VotacionDetalle
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_votacion_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoVotacionDetallePk;

    /**
     * @ORM\Column(name="codigo_votacion_fk", type="integer")
     */
    private $codigoVotacionFk;

    /**
     * @ORM\Column(name="descripcion", type="string", length=100)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Votacion", inversedBy="votacionesDetallesVotacionRel")
     * @ORM\JoinColumn(name="codigo_votacion_fk", referencedColumnName="codigo_votacion_pk")
     */
    private $votacionRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VotacionCelda", mappedBy="votacionDetalleRel")
     */
    private $votacionesCeldasVotacionDetalleRel;

    /**
     * @return mixed
     */
    public function getCodigoVotacionDetallePk()
    {
        return $this->codigoVotacionDetallePk;
    }

    /**
     * @param mixed $codigoVotacionDetallePk
     */
    public function setCodigoVotacionDetallePk($codigoVotacionDetallePk): void
    {
        $this->codigoVotacionDetallePk = $codigoVotacionDetallePk;
    }

    /**
     * @return mixed
     */
    public function getCodigoVotacionFk()
    {
        return $this->codigoVotacionFk;
    }

    /**
     * @param mixed $codigoVotacionFk
     */
    public function setCodigoVotacionFk($codigoVotacionFk): void
    {
        $this->codigoVotacionFk = $codigoVotacionFk;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getVotacionRel()
    {
        return $this->votacionRel;
    }

    /**
     * @param mixed $votacionRel
     */
    public function setVotacionRel($votacionRel): void
    {
        $this->votacionRel = $votacionRel;
    }

    /**
     * @return mixed
     */
    public function getVotacionesCeldasVotacionDetalleRel()
    {
        return $this->votacionesCeldasVotacionDetalleRel;
    }

    /**
     * @param mixed $votacionesCeldasVotacionDetalleRel
     */
    public function setVotacionesCeldasVotacionDetalleRel($votacionesCeldasVotacionDetalleRel): void
    {
        $this->votacionesCeldasVotacionDetalleRel = $votacionesCeldasVotacionDetalleRel;
    }


}