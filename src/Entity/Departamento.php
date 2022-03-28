<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartamentoRepository")
 */
class Departamento
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_departamento_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoDepartamentoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_pais_fk", type="integer", nullable=true)
     */
    private $codigoPaisFk;

    /**
     * @ORM\Column(name="codigo_interface", type="string", length=20, nullable=true)
     */
    private $codigoInterface;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pais", inversedBy="departamentosPaisRel")
     * @ORM\JoinColumn(name="codigo_pais_fk", referencedColumnName="codigo_pais_pk")
     */
    private $paisRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ciudad", mappedBy="departamentoRel")
     */
    private $ciudadesDepartamentoRel;

    /**
     * @return mixed
     */
    public function getCodigoDepartamentoPk()
    {
        return $this->codigoDepartamentoPk;
    }

    /**
     * @param mixed $codigoDepartamentoPk
     */
    public function setCodigoDepartamentoPk($codigoDepartamentoPk): void
    {
        $this->codigoDepartamentoPk = $codigoDepartamentoPk;
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
    public function getCodigoPaisFk()
    {
        return $this->codigoPaisFk;
    }

    /**
     * @param mixed $codigoPaisFk
     */
    public function setCodigoPaisFk($codigoPaisFk): void
    {
        $this->codigoPaisFk = $codigoPaisFk;
    }

    /**
     * @return mixed
     */
    public function getPaisRel()
    {
        return $this->paisRel;
    }

    /**
     * @param mixed $paisRel
     */
    public function setPaisRel($paisRel): void
    {
        $this->paisRel = $paisRel;
    }

    /**
     * @return mixed
     */
    public function getCiudadesDepartamentoRel()
    {
        return $this->ciudadesDepartamentoRel;
    }

    /**
     * @param mixed $ciudadesDepartamentoRel
     */
    public function setCiudadesDepartamentoRel($ciudadesDepartamentoRel): void
    {
        $this->ciudadesDepartamentoRel = $ciudadesDepartamentoRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoInterface()
    {
        return $this->codigoInterface;
    }

    /**
     * @param mixed $codigoInterface
     */
    public function setCodigoInterface($codigoInterface): void
    {
        $this->codigoInterface = $codigoInterface;
    }



}