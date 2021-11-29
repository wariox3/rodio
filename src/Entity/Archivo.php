<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArchivoRepository")
 */
class Archivo
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_reserva_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoArchivoPk;

    /**
     * @ORM\Column(name="codigo_archivo_tipo_fk", type="string", length=20, nullable=true)
     */
    private $codigoArchivoTipoFk;

    /**
     * @ORM\Column(name="codigo_modelo_fk", type="string", length=20, nullable=true)
     */
    private $codigoModeloFk;

    /**
     * @ORM\Column(name="codigo", type="integer")
     */
    private $codigo;

    /**
     * @ORM\Column(name="nombre", type="string", length=500, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="ruta", type="string", length=500, nullable=true)
     */
    private $ruta;

    /**
     * @return mixed
     */
    public function getCodigoArchivoPk()
    {
        return $this->codigoArchivoPk;
    }

    /**
     * @param mixed $codigoArchivoPk
     */
    public function setCodigoArchivoPk($codigoArchivoPk): void
    {
        $this->codigoArchivoPk = $codigoArchivoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoArchivoTipoFk()
    {
        return $this->codigoArchivoTipoFk;
    }

    /**
     * @param mixed $codigoArchivoTipoFk
     */
    public function setCodigoArchivoTipoFk($codigoArchivoTipoFk): void
    {
        $this->codigoArchivoTipoFk = $codigoArchivoTipoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo): void
    {
        $this->codigo = $codigo;
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
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * @param mixed $ruta
     */
    public function setRuta($ruta): void
    {
        $this->ruta = $ruta;
    }

    /**
     * @return mixed
     */
    public function getCodigoModeloFk()
    {
        return $this->codigoModeloFk;
    }

    /**
     * @param mixed $codigoModeloFk
     */
    public function setCodigoModeloFk($codigoModeloFk): void
    {
        $this->codigoModeloFk = $codigoModeloFk;
    }



}