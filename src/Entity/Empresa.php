<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmpresaRepository")
 */
class Empresa
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_empresa_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoEmpresaPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=60, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="direccion", type="string", length=60, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(name="telefono", type="string", length=60, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(name="nit", type="string", length=20, nullable=true)
     */
    private $nit;

    /**
     * @ORM\Column(name="digito_verificacion", type="string", length=1, nullable=true)
     */
    private $digitoVerificacion;

    /**
     * @ORM\Column(name="abreviatura", type="string", length=60, nullable=true)
     */
    private $abreviatura;

    /**
     * @ORM\Column(name="logo", type="blob", nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=5, name="extension", nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(name="url_servicio", type="string", length=500, nullable=true)
     */
    private $urlServicio;

    /**
     * @ORM\Column(name="pago", type="boolean", options={"default":true})
     */
    private $pago = true;

    /**
     * @ORM\Column(name="certificado_laboral", type="boolean", options={"default":true})
     */
    private $certificadoLaboral = true;

    /**
     * @ORM\Column(name="certificado_retiro", type="boolean", options={"default":true})
     */
    private $certificadoRetiro = true;

    /**
     * @ORM\Column(name="programacion", type="boolean", options={"default":true})
     */
    private $programacion = true;

    /**
     * @ORM\Column(name="ciudad", type="string", length=60, nullable=true)
     */
    private $ciudad;

    /**
     * @ORM\Column(name="codigo_item", type="integer", length=60, nullable=true)
     */
    private $codigoItem;

    /**
     * @return mixed
     */
    public function getCodigoEmpresaPk()
    {
        return $this->codigoEmpresaPk;
    }

    /**
     * @param mixed $codigoEmpresaPk
     */
    public function setCodigoEmpresaPk($codigoEmpresaPk): void
    {
        $this->codigoEmpresaPk = $codigoEmpresaPk;
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
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * @param mixed $nit
     */
    public function setNit($nit): void
    {
        $this->nit = $nit;
    }

    /**
     * @return mixed
     */
    public function getDigitoVerificacion()
    {
        return $this->digitoVerificacion;
    }

    /**
     * @param mixed $digitoVerificacion
     */
    public function setDigitoVerificacion($digitoVerificacion): void
    {
        $this->digitoVerificacion = $digitoVerificacion;
    }

    /**
     * @return mixed
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * @param mixed $abreviatura
     */
    public function setAbreviatura($abreviatura): void
    {
        $this->abreviatura = $abreviatura;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return mixed
     */
    public function getUrlServicio()
    {
        return $this->urlServicio;
    }

    /**
     * @param mixed $urlServicio
     */
    public function setUrlServicio($urlServicio): void
    {
        $this->urlServicio = $urlServicio;
    }

    /**
     * @return bool
     */
    public function isPago(): bool
    {
        return $this->pago;
    }

    /**
     * @param bool $pago
     */
    public function setPago(bool $pago): void
    {
        $this->pago = $pago;
    }

    /**
     * @return bool
     */
    public function isCertificadoLaboral(): bool
    {
        return $this->certificadoLaboral;
    }

    /**
     * @param bool $certificadoLaboral
     */
    public function setCertificadoLaboral(bool $certificadoLaboral): void
    {
        $this->certificadoLaboral = $certificadoLaboral;
    }

    /**
     * @return bool
     */
    public function isCertificadoRetiro(): bool
    {
        return $this->certificadoRetiro;
    }

    /**
     * @param bool $certificadoRetiro
     */
    public function setCertificadoRetiro(bool $certificadoRetiro): void
    {
        $this->certificadoRetiro = $certificadoRetiro;
    }

    /**
     * @return bool
     */
    public function isProgramacion(): bool
    {
        return $this->programacion;
    }

    /**
     * @param bool $programacion
     */
    public function setProgramacion(bool $programacion): void
    {
        $this->programacion = $programacion;
    }

    /**
     * @return mixed
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * @param mixed $ciudad
     */
    public function setCiudad($ciudad): void
    {
        $this->ciudad = $ciudad;
    }

    /**
     * @return mixed
     */
    public function getCodigoItem()
    {
        return $this->codigoItem;
    }

    /**
     * @param mixed $codigoItem
     */
    public function setCodigoItem($codigoItem): void
    {
        $this->codigoItem = $codigoItem;
    }


}
