<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PuestoRepository")
 */
class Puesto
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_puesto_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoPuestoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_operador_fk", type="integer")
     */
    private $codigoOperadorFk;

    /**
     * @ORM\Column(name="codigo_puesto_interface", type="integer", nullable=true)
     */
    private $codigoPuestoInterface;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Operador", inversedBy="puestosOperadorRel")
     * @ORM\JoinColumn(name="codigo_operador_fk", referencedColumnName="codigo_operador_pk")
     */
    private $operadorRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ronda", mappedBy="puestoRel")
     */
    private $rondasPuestoRel;

    /**
     * @return mixed
     */
    public function getCodigoPuestoPk()
    {
        return $this->codigoPuestoPk;
    }

    /**
     * @param mixed $codigoPuestoPk
     */
    public function setCodigoPuestoPk($codigoPuestoPk): void
    {
        $this->codigoPuestoPk = $codigoPuestoPk;
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
    public function getCodigoPuestoInterface()
    {
        return $this->codigoPuestoInterface;
    }

    /**
     * @param mixed $codigoPuestoInterface
     */
    public function setCodigoPuestoInterface($codigoPuestoInterface): void
    {
        $this->codigoPuestoInterface = $codigoPuestoInterface;
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

    /**
     * @return mixed
     */
    public function getRondasPuestoRel()
    {
        return $this->rondasPuestoRel;
    }

    /**
     * @param mixed $rondasPuestoRel
     */
    public function setRondasPuestoRel($rondasPuestoRel): void
    {
        $this->rondasPuestoRel = $rondasPuestoRel;
    }


}