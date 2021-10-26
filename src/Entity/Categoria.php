<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriaRepository")
 */
class Categoria
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="codigo_catagoria_pk", type="string", length=10, unique=true)
     * @Assert\Length( max = 10, maxMessage="El campo no puede contener más de 10 caracteres")
     */
    private $codigoCatagoriaPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\Length( max = 255, maxMessage = "El campo no puede contener más de {{ limit }} caracteres")
     */
    private $nombre;

    /**
     * @ORM\Column(name="url_imagen", type="string", length=500, nullable=true)
     */
    private $urlImagen;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Oferta", mappedBy="categoriaRel")
     */
    private $ofertasCategoriaRel;

    /**
     * @return mixed
     */
    public function getCodigoCatagoriaPk()
    {
        return $this->codigoCatagoriaPk;
    }

    /**
     * @param mixed $codigoCatagoriaPk
     */
    public function setCodigoCatagoriaPk($codigoCatagoriaPk): void
    {
        $this->codigoCatagoriaPk = $codigoCatagoriaPk;
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

    /**
     * @return mixed
     */
    public function getOfertasCategoriaRel()
    {
        return $this->ofertasCategoriaRel;
    }

    /**
     * @param mixed $ofertasCategoriaRel
     */
    public function setOfertasCategoriaRel($ofertasCategoriaRel): void
    {
        $this->ofertasCategoriaRel = $ofertasCategoriaRel;
    }




}