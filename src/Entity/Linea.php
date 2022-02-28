<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LineaRepository")
 */
class Linea
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="codigo_linea_pk", type="string", length=10, unique=true)
     */
    private $codigoLineaPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;


    /**
     * @ORM\Column(name="url_imagen", type="string", length=500, nullable=true)
     */
    private $urlImagen;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Grupo", mappedBy="lineaRel")
     */
    private $gruposLineaRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="lineaRel")
     */
    private $itemesLineaRel;

    /**
     * @return mixed
     */
    public function getCodigoLineaPk()
    {
        return $this->codigoLineaPk;
    }

    /**
     * @param mixed $codigoLineaPk
     */
    public function setCodigoLineaPk($codigoLineaPk): void
    {
        $this->codigoLineaPk = $codigoLineaPk;
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
    public function getGruposLineaRel()
    {
        return $this->gruposLineaRel;
    }

    /**
     * @param mixed $gruposLineaRel
     */
    public function setGruposLineaRel($gruposLineaRel): void
    {
        $this->gruposLineaRel = $gruposLineaRel;
    }

    /**
     * @return mixed
     */
    public function getItemesLineaRel()
    {
        return $this->itemesLineaRel;
    }

    /**
     * @param mixed $itemesLineaRel
     */
    public function setItemesLineaRel($itemesLineaRel): void
    {
        $this->itemesLineaRel = $itemesLineaRel;
    }

    /**
     * @return mixed
     */
    public function getUrlImagen()
    {
        return $this->urlImagen;
    }

    /**
     * @param mixed $urlImagen
     */
    public function setUrlImagen($urlImagen): void
    {
        $this->urlImagen = $urlImagen;
    }


}