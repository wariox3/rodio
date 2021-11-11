<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperadorRepository")
 */
class Operador
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_operador_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoOperadorPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="punto_servicio_semantica", type="string", length=200, nullable=true)
     */
    private $puntoServicioSemantica;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuario", mappedBy="operadorRel")
     */
    private $usuariosOperadorRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Control", mappedBy="operadorRel")
     */
    private $controlesOperadorRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Formulario", mappedBy="operadorRel")
     */
    private $formulariosOperadorRel;

    /**
     * @return mixed
     */
    public function getCodigoOperadorPk()
    {
        return $this->codigoOperadorPk;
    }

    /**
     * @param mixed $codigoOperadorPk
     */
    public function setCodigoOperadorPk($codigoOperadorPk): void
    {
        $this->codigoOperadorPk = $codigoOperadorPk;
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
    public function getPuntoServicioSemantica()
    {
        return $this->puntoServicioSemantica;
    }

    /**
     * @param mixed $puntoServicioSemantica
     */
    public function setPuntoServicioSemantica($puntoServicioSemantica): void
    {
        $this->puntoServicioSemantica = $puntoServicioSemantica;
    }

    /**
     * @return mixed
     */
    public function getUsuariosOperadorRel()
    {
        return $this->usuariosOperadorRel;
    }

    /**
     * @param mixed $usuariosOperadorRel
     */
    public function setUsuariosOperadorRel($usuariosOperadorRel): void
    {
        $this->usuariosOperadorRel = $usuariosOperadorRel;
    }

    /**
     * @return mixed
     */
    public function getControlesOperadorRel()
    {
        return $this->controlesOperadorRel;
    }

    /**
     * @param mixed $controlesOperadorRel
     */
    public function setControlesOperadorRel($controlesOperadorRel): void
    {
        $this->controlesOperadorRel = $controlesOperadorRel;
    }

    /**
     * @return mixed
     */
    public function getFormulariosOperadorRel()
    {
        return $this->formulariosOperadorRel;
    }

    /**
     * @param mixed $formulariosOperadorRel
     */
    public function setFormulariosOperadorRel($formulariosOperadorRel): void
    {
        $this->formulariosOperadorRel = $formulariosOperadorRel;
    }



}