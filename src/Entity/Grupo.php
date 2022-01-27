<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GrupoRepository")
 */
class Grupo
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="codigo_grupo_pk", type="string", length=10, unique=true)
     * @Assert\Length( max = 10, maxMessage="El campo no puede contener más de 10 caracteres")
     */
    private $codigoGrupoPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\Length( max = 255, maxMessage = "El campo no puede contener más de {{ limit }} caracteres")
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_linea_fk", type="string", length=10, nullable=true)
     */
    private $codigoLineaFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Linea", inversedBy="gruposLineaRel")
     * @ORM\JoinColumn(name="codigo_linea_fk", referencedColumnName="codigo_linea_pk")
     */
    private $lineaRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="grupoRel")
     */
    private $itemesGrupoRel;

    /**
     * @return mixed
     */
    public function getCodigoGrupoPk()
    {
        return $this->codigoGrupoPk;
    }

    /**
     * @param mixed $codigoGrupoPk
     */
    public function setCodigoGrupoPk($codigoGrupoPk): void
    {
        $this->codigoGrupoPk = $codigoGrupoPk;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getCodigoLineaFk()
    {
        return $this->codigoLineaFk;
    }

    /**
     * @param mixed $codigoLineaFk
     */
    public function setCodigoLineaFk($codigoLineaFk): void
    {
        $this->codigoLineaFk = $codigoLineaFk;
    }

    /**
     * @return mixed
     */
    public function getLineaRel()
    {
        return $this->lineaRel;
    }

    /**
     * @param mixed $lineaRel
     */
    public function setLineaRel($lineaRel): void
    {
        $this->lineaRel = $lineaRel;
    }

    /**
     * @return mixed
     */
    public function getItemesGrupoRel()
    {
        return $this->itemesGrupoRel;
    }

    /**
     * @param mixed $itemesGrupoRel
     */
    public function setItemesGrupoRel($itemesGrupoRel): void
    {
        $this->itemesGrupoRel = $itemesGrupoRel;
    }



}