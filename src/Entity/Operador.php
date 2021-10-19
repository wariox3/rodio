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


}