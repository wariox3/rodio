<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitaRepository")
 */
class Visita
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_visita_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoVisitaPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="numero_identificacion", type="string", length=30, nullable=true)
     */
    private $numeroIdentificacion;

    /**
     * @ORM\Column(name="nombre", type="string", length=150, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="placa", type="string", length=10, nullable=true)
     */
    private $placa;

    /**
     * @ORM\Column(name="codigo_celda_fk", type="integer", nullable=true)
     */
    private $codigoCeldaFk;

    /**
     * @ORM\Column(name="codigo_panal_fk", type="integer", nullable=true)
     */
    private $codigoPanalFk;

    /**
     * @ORM\Column(name="codigo_usuario_autoriza_fk", type="integer", nullable=true)
     */
    private $codigoUsuarioAutorizaFk;

    /**
     * @ORM\Column(name="estado_autorizado", type="string", options={"default" : "P"})
     */
    private $estadoAutorizado = "P";

    /**
     * @ORM\Column(name="estado_cerrado", type="boolean", options={"default" : false}, nullable=true)
     */
    private $estadoCerrado = false;

    /**
     * @ORM\Column(name="codigo_ingreso", type="string", length=10, nullable=true)
     */
    private $codigoIngreso;

    /**
     * @ORM\Column(name="url_imagen", type="string", length=500, nullable=true)
     */
    private $urlImagen;

    /**
     * @ORM\Column(name="celda", type="string", length=20, nullable=true)
     */
    private $celda;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Celda", inversedBy="visitasCeldaRel")
     * @ORM\JoinColumn(name="codigo_celda_fk", referencedColumnName="codigo_celda_pk")
     */
    private $celdaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panal", inversedBy="visitasPanalRel")
     * @ORM\JoinColumn(name="codigo_panal_fk", referencedColumnName="codigo_panal_pk")
     */
    private $panalRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="visitasUsuarioAutorizaRel")
     * @ORM\JoinColumn(name="codigo_usuario_autoriza_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioAutorizaRel;

    /**
     * @return mixed
     */
    public function getCodigoVisitaPk()
    {
        return $this->codigoVisitaPk;
    }

    /**
     * @param mixed $codigoVisitaPk
     */
    public function setCodigoVisitaPk($codigoVisitaPk): void
    {
        $this->codigoVisitaPk = $codigoVisitaPk;
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
    public function getNumeroIdentificacion()
    {
        return $this->numeroIdentificacion;
    }

    /**
     * @param mixed $numeroIdentificacion
     */
    public function setNumeroIdentificacion($numeroIdentificacion): void
    {
        $this->numeroIdentificacion = $numeroIdentificacion;
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
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * @param mixed $placa
     */
    public function setPlaca($placa): void
    {
        $this->placa = $placa;
    }

    /**
     * @return mixed
     */
    public function getCodigoCeldaFk()
    {
        return $this->codigoCeldaFk;
    }

    /**
     * @param mixed $codigoCeldaFk
     */
    public function setCodigoCeldaFk($codigoCeldaFk): void
    {
        $this->codigoCeldaFk = $codigoCeldaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioAutorizaFk()
    {
        return $this->codigoUsuarioAutorizaFk;
    }

    /**
     * @param mixed $codigoUsuarioAutorizaFk
     */
    public function setCodigoUsuarioAutorizaFk($codigoUsuarioAutorizaFk): void
    {
        $this->codigoUsuarioAutorizaFk = $codigoUsuarioAutorizaFk;
    }


    /**
     * @return mixed
     */
    public function getCeldaRel()
    {
        return $this->celdaRel;
    }

    /**
     * @param mixed $celdaRel
     */
    public function setCeldaRel($celdaRel): void
    {
        $this->celdaRel = $celdaRel;
    }

    /**
     * @return mixed
     */
    public function getUsuarioAutorizaRel()
    {
        return $this->usuarioAutorizaRel;
    }

    /**
     * @param mixed $usuarioAutorizaRel
     */
    public function setUsuarioAutorizaRel($usuarioAutorizaRel): void
    {
        $this->usuarioAutorizaRel = $usuarioAutorizaRel;
    }

    /**
     * @return bool
     */
    public function getEstadoCerrado(): bool
    {
        return $this->estadoCerrado;
    }

    /**
     * @param bool $estadoCerrado
     */
    public function setEstadoCerrado(bool $estadoCerrado): void
    {
        $this->estadoCerrado = $estadoCerrado;
    }

    /**
     * @return string
     */
    public function getEstadoAutorizado(): string
    {
        return $this->estadoAutorizado;
    }

    /**
     * @param string $estadoAutorizado
     */
    public function setEstadoAutorizado(string $estadoAutorizado): void
    {
        $this->estadoAutorizado = $estadoAutorizado;
    }

    /**
     * @return mixed
     */
    public function getCodigoIngreso()
    {
        return $this->codigoIngreso;
    }

    /**
     * @param mixed $codigoIngreso
     */
    public function setCodigoIngreso($codigoIngreso): void
    {
        $this->codigoIngreso = $codigoIngreso;
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
    public function getCelda()
    {
        return $this->celda;
    }

    /**
     * @param mixed $celda
     */
    public function setCelda($celda): void
    {
        $this->celda = $celda;
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


}