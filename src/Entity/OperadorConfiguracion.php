<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperadorConfiguracionRepository")
 */
class OperadorConfiguracion
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_operador_pk", type="integer")
     */
    private $codigoOperadorConfiguracionPk;

    /**
     * @ORM\Column(name="calidad_imagen_entrega", type="float", options={"default" : 1} )
     */
    private $calidadImagenEntrega = 1.0;

    /**
     * @ORM\Column(name="exige_imagen_entrega", type="boolean", options={"default" : false})
     */
    private $exigeImagenEntrega = false;

    /**
     * @ORM\Column(name="exige_firma_entrega", type="boolean", options={"default" : false})
     */
    private $exigeFirmaEntrega = false;

    /**
     * @ORM\Column(name="entrega_novedad", type="boolean", options={"default" : false})
     */
    private $entrega_novedad = false;

    /**
     * @return mixed
     */
    public function getCodigoOperadorConfiguracionPk()
    {
        return $this->codigoOperadorConfiguracionPk;
    }

    /**
     * @param mixed $codigoOperadorConfiguracionPk
     */
    public function setCodigoOperadorConfiguracionPk($codigoOperadorConfiguracionPk): void
    {
        $this->codigoOperadorConfiguracionPk = $codigoOperadorConfiguracionPk;
    }

    /**
     * @return float
     */
    public function getCalidadImagenEntrega(): float
    {
        return $this->calidadImagenEntrega;
    }

    /**
     * @param float $calidadImagenEntrega
     */
    public function setCalidadImagenEntrega(float $calidadImagenEntrega): void
    {
        $this->calidadImagenEntrega = $calidadImagenEntrega;
    }

    /**
     * @return bool
     */
    public function isExigeImagenEntrega(): bool
    {
        return $this->exigeImagenEntrega;
    }

    /**
     * @param bool $exigeImagenEntrega
     */
    public function setExigeImagenEntrega(bool $exigeImagenEntrega): void
    {
        $this->exigeImagenEntrega = $exigeImagenEntrega;
    }

    /**
     * @return bool
     */
    public function isExigeFirmaEntrega(): bool
    {
        return $this->exigeFirmaEntrega;
    }

    /**
     * @param bool $exigeFirmaEntrega
     */
    public function setExigeFirmaEntrega(bool $exigeFirmaEntrega): void
    {
        $this->exigeFirmaEntrega = $exigeFirmaEntrega;
    }

    /**
     * @return bool
     */
    public function isEntregaNovedad(): bool
    {
        return $this->entrega_novedad;
    }

    /**
     * @param bool $entrega_novedad
     */
    public function setEntregaNovedad(bool $entrega_novedad): void
    {
        $this->entrega_novedad = $entrega_novedad;
    }




}