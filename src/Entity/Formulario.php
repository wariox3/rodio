<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormularioRepository")
 */
class Formulario
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_formulario_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoFormularioPk;

    /**
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(name="nombre", type="string", length=200)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_operador_fk", type="integer")
     */
    private $codigoOperadorFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Operador", inversedBy="formulariosOperadorRel")
     * @ORM\JoinColumn(name="codigo_operador_fk", referencedColumnName="codigo_operador_pk")
     */
    private $operadorRel;

    /**
     * @return mixed
     */
    public function getCodigoFormularioPk()
    {
        return $this->codigoFormularioPk;
    }

    /**
     * @param mixed $codigoFormularioPk
     */
    public function setCodigoFormularioPk($codigoFormularioPk): void
    {
        $this->codigoFormularioPk = $codigoFormularioPk;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
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
    public function getCodigoOperadorFk()
    {
        return $this->codigoOperadorFk;
    }

    /**
     * @param mixed $codigoOperadorFk
     */
    public function setCodigoOperadorFk($codigoOperadorFk): void
    {
        $this->codigoOperadorFk = $codigoOperadorFk;
    }

    /**
     * @return mixed
     */
    public function getOperadorRel()
    {
        return $this->operadorRel;
    }

    /**
     * @param mixed $operadorRel
     */
    public function setOperadorRel($operadorRel): void
    {
        $this->operadorRel = $operadorRel;
    }



}