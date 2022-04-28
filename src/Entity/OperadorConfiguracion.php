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




}