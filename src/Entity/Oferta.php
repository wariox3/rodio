<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfertaRepository")
 */
class Oferta
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_oferta_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoOfertaPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="descripcion", type="string", length=200)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="precio", type="float", options={"default" : 0})
     */
    private $precio = 0.0;

    /**
     * @ORM\Column(name="codigo_panal_fk", type="integer")
     */
    private $codigoPanalFk;

    /**
     * @ORM\Column(name="url_imagen", type="string", length=500, nullable=true)
     */
    private $urlImagen;

    /**
     * @ORM\Column(name="codigo_categoria_fk", type="string", length=10, nullable=true)
     */
    private $codigoCategoriaFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panal", inversedBy="ofertasPanalRel")
     * @ORM\JoinColumn(name="codigo_panal_fk", referencedColumnName="codigo_panal_pk")
     */
    private $panalRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoria", inversedBy="ofertasCategoriaRel")
     * @ORM\JoinColumn(name="codigo_categoria_fk", referencedColumnName="codigo_catagoria_pk")
     */
    private $categoriaRel;

    /**
     * @return mixed
     */
    public function getCodigoOfertaPk()
    {
        return $this->codigoOfertaPk;
    }

    /**
     * @param mixed $codigoOfertaPk
     */
    public function setCodigoOfertaPk($codigoOfertaPk): void
    {
        $this->codigoOfertaPk = $codigoOfertaPk;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return float
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * @param float $precio
     */
    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
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
    public function getCodigoPanalFk()
    {
        return $this->codigoPanalFk;
    }

    /**
     * @param mixed $codigoPanalFk
     */
    public function setCodigoPanalFk($codigoPanalFk): void
    {
        $this->codigoPanalFk = $codigoPanalFk;
    }

    /**
     * @return mixed
     */
    public function getPanalRel()
    {
        return $this->panalRel;
    }

    /**
     * @param mixed $panalRel
     */
    public function setPanalRel($panalRel): void
    {
        $this->panalRel = $panalRel;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getCodigoCategoriaFk()
    {
        return $this->codigoCategoriaFk;
    }

    /**
     * @param mixed $codigoCategoriaFk
     */
    public function setCodigoCategoriaFk($codigoCategoriaFk): void
    {
        $this->codigoCategoriaFk = $codigoCategoriaFk;
    }

    /**
     * @return mixed
     */
    public function getCategoriaRel()
    {
        return $this->categoriaRel;
    }

    /**
     * @param mixed $categoriaRel
     */
    public function setCategoriaRel($categoriaRel): void
    {
        $this->categoriaRel = $categoriaRel;
    }



}