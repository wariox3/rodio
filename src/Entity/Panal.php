<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PanalRepository")
 */
class Panal
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_panal_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoPanalPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Celda", mappedBy="panalRel")
     */
    private $celdasPanalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuario", mappedBy="panalRel")
     */
    private $usuariosPanalRel;

    /**
     * @return mixed
     */
    public function getCodigoPanalPk()
    {
        return $this->codigoPanalPk;
    }

    /**
     * @param mixed $codigoPanalPk
     */
    public function setCodigoPanalPk($codigoPanalPk): void
    {
        $this->codigoPanalPk = $codigoPanalPk;
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
    public function getCeldasPanalRel()
    {
        return $this->celdasPanalRel;
    }

    /**
     * @param mixed $celdasPanalRel
     */
    public function setCeldasPanalRel($celdasPanalRel): void
    {
        $this->celdasPanalRel = $celdasPanalRel;
    }

    /**
     * @return mixed
     */
    public function getUsuariosPanalRel()
    {
        return $this->usuariosPanalRel;
    }

    /**
     * @param mixed $usuariosPanalRel
     */
    public function setUsuariosPanalRel($usuariosPanalRel): void
    {
        $this->usuariosPanalRel = $usuariosPanalRel;
    }



}