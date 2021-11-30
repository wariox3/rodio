<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnotacionTipoRepository")
 */
class AnotacionTipo
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_anotacion_tipo_pk", type="string", length=10)
     */
    private $codigoAnotacionTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Anotacion", mappedBy="anotacionTipoRel")
     */
    private $anotacionesAnotacionTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoAnotacionTipoPk()
    {
        return $this->codigoAnotacionTipoPk;
    }

    /**
     * @param mixed $codigoAnotacionTipoPk
     */
    public function setCodigoAnotacionTipoPk($codigoAnotacionTipoPk): void
    {
        $this->codigoAnotacionTipoPk = $codigoAnotacionTipoPk;
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
    public function getAnotacionesAnotacionTipoRel()
    {
        return $this->anotacionesAnotacionTipoRel;
    }

    /**
     * @param mixed $anotacionesAnotacionTipoRel
     */
    public function setAnotacionesAnotacionTipoRel($anotacionesAnotacionTipoRel): void
    {
        $this->anotacionesAnotacionTipoRel = $anotacionesAnotacionTipoRel;
    }



}