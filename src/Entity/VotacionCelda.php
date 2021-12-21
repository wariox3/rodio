<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VotacionCeldaRepository")
 */
class VotacionCelda
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_votacion_celda_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoVotacionCeldaPk;

    /**
     * @ORM\Column(name="codigo_votacion_fk", type="integer")
     */
    private $codigoVotacionFk;

    /**
     * @ORM\Column(name="codigo_celda_fk", type="integer")
     */
    private $codigoCeldaFk;

    /**
     * @ORM\Column(name="codigo_votacion_detalle_fk", type="integer")
     */
    private $codigoVotacionDetalleFk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer")
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Votacion", inversedBy="votacionesCeldasVotacionRel")
     * @ORM\JoinColumn(name="codigo_votacion_fk", referencedColumnName="codigo_votacion_pk")
     */
    private $votacionRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Celda", inversedBy="votacionesCeldasCeldaRel")
     * @ORM\JoinColumn(name="codigo_celda_fk", referencedColumnName="codigo_celda_pk")
     */
    private $celdaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="votacionesCeldasUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VotacionDetalle", inversedBy="votacionesCeldasVotacionDetalleRel")
     * @ORM\JoinColumn(name="codigo_votacion_detalle_fk", referencedColumnName="codigo_votacion_detalle_pk")
     */
    private $votacionDetalleRel;

    /**
     * @return mixed
     */
    public function getCodigoVotacionCeldaPk()
    {
        return $this->codigoVotacionCeldaPk;
    }

    /**
     * @param mixed $codigoVotacionCeldaPk
     */
    public function setCodigoVotacionCeldaPk($codigoVotacionCeldaPk): void
    {
        $this->codigoVotacionCeldaPk = $codigoVotacionCeldaPk;
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
    public function getCodigoCeldaFk()
    {
        return $this->codigoCeldaFk;
    }

    /**
     * @param mixed $codigoCeldaFk
     */
    public function setCodigoCeldaFk($codigoCeldaFk): void
    {
        $this->codigoCeldaFk = $codigoCeldaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoVotacionDetalleFk()
    {
        return $this->codigoVotacionDetalleFk;
    }

    /**
     * @param mixed $codigoVotacionDetalleFk
     */
    public function setCodigoVotacionDetalleFk($codigoVotacionDetalleFk): void
    {
        $this->codigoVotacionDetalleFk = $codigoVotacionDetalleFk;
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
    public function getCeldaRel()
    {
        return $this->celdaRel;
    }

    /**
     * @param mixed $celdaRel
     */
    public function setCeldaRel($celdaRel): void
    {
        $this->celdaRel = $celdaRel;
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
    public function getVotacionDetalleRel()
    {
        return $this->votacionDetalleRel;
    }

    /**
     * @param mixed $votacionDetalleRel
     */
    public function setVotacionDetalleRel($votacionDetalleRel): void
    {
        $this->votacionDetalleRel = $votacionDetalleRel;
    }



}