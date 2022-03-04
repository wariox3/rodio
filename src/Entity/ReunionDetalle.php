<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReunionDetalleRepository")
 */
class ReunionDetalle
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_reunion_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoReunionDetallePk;

    /**
     * @ORM\Column(name="codigo_reunion_fk", type="integer")
     */
    private $codigoReunionFk;

    /**
     * @ORM\Column(name="codigo_celda_fk", type="integer")
     */
    private $codigoCeldaFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reunion", inversedBy="reunionesDetallesReunionRel")
     * @ORM\JoinColumn(name="codigo_reunion_fk", referencedColumnName="codigo_reunion_pk")
     */
    private $reunionRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Celda", inversedBy="reunionesDetallesCeldaRel")
     * @ORM\JoinColumn(name="codigo_celda_fk", referencedColumnName="codigo_celda_pk")
     */
    private $celdaRel;

    /**
     * @return mixed
     */
    public function getCodigoReunionDetallePk()
    {
        return $this->codigoReunionDetallePk;
    }

    /**
     * @param mixed $codigoReunionDetallePk
     */
    public function setCodigoReunionDetallePk($codigoReunionDetallePk): void
    {
        $this->codigoReunionDetallePk = $codigoReunionDetallePk;
    }

    /**
     * @return mixed
     */
    public function getCodigoReunionFk()
    {
        return $this->codigoReunionFk;
    }

    /**
     * @param mixed $codigoReunionFk
     */
    public function setCodigoReunionFk($codigoReunionFk): void
    {
        $this->codigoReunionFk = $codigoReunionFk;
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
    public function getReunionRel()
    {
        return $this->reunionRel;
    }

    /**
     * @param mixed $reunionRel
     */
    public function setReunionRel($reunionRel): void
    {
        $this->reunionRel = $reunionRel;
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



}