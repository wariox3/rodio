<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CeldaRepository")
 */
class Celda
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_celda_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCeldaPk;

    /**
     * @ORM\Column(name="codigo_panal_fk", type="integer")
     */
    private $codigoPanalFk;

    /**
     * @ORM\Column(name="celda", type="string", length=20, nullable=true)
     */
    private $celda;

    /**
     * @ORM\Column(name="celular", type="string", length=100, nullable=true)
     */
    private $celular;

    /**
     * @ORM\Column(name="correo", type="string", length=150, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(name="responsable", type="string", length=200, nullable=true)
     */
    private $responsable;

    /**
     * @ORM\Column(name="llave", type="string", length=200, nullable=true)
     */
    private $llave;

    /**
     * @ORM\Column(name="limitar_anuncio", type="boolean", options={"default" : false}, nullable=true)
     */
    private $limitarAnuncio = false;

    /**
     * @ORM\Column(name="coeficiente", type="float", options={"default" : 0})
     */
    private $coeficiente = 0.0;

    /**
     * @ORM\Column(name="area", type="float", options={"default" : 0})
     */
    private $area = 0.0;

    /**
     * @ORM\Column(name="codigo_externo", type="string", length=100, nullable=true)
     */
    private $codigoExterno;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panal", inversedBy="celdasPanalRel")
     * @ORM\JoinColumn(name="codigo_panal_fk", referencedColumnName="codigo_panal_pk")
     */
    private $panalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entrega", mappedBy="celdaRel")
     */
    private $entregasCeldaRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuario", mappedBy="celdaRel")
     */
    private $usuariosCeldaRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visita", mappedBy="celdaRel")
     */
    private $visitasCeldaRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReservaDetalle", mappedBy="celdaRel")
     */
    private $reservasDetallesCeldaRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CeldaUsuario", mappedBy="celdaRel")
     */
    private $celdasUsuariosCeldaRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Atencion", mappedBy="celdaRel")
     */
    private $atencionesCeldaRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReunionDetalle", mappedBy="celdaRel")
     */
    private $reunionesDetallesCeldaRel;

    /**
     * @return mixed
     */
    public function getCodigoCeldaPk()
    {
        return $this->codigoCeldaPk;
    }

    /**
     * @param mixed $codigoCeldaPk
     */
    public function setCodigoCeldaPk($codigoCeldaPk): void
    {
        $this->codigoCeldaPk = $codigoCeldaPk;
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
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular): void
    {
        $this->celular = $celular;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param mixed $responsable
     */
    public function setResponsable($responsable): void
    {
        $this->responsable = $responsable;
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
    public function getEntregasCeldaRel()
    {
        return $this->entregasCeldaRel;
    }

    /**
     * @param mixed $entregasCeldaRel
     */
    public function setEntregasCeldaRel($entregasCeldaRel): void
    {
        $this->entregasCeldaRel = $entregasCeldaRel;
    }

    /**
     * @return mixed
     */
    public function getUsuariosCeldaRel()
    {
        return $this->usuariosCeldaRel;
    }

    /**
     * @param mixed $usuariosCeldaRel
     */
    public function setUsuariosCeldaRel($usuariosCeldaRel): void
    {
        $this->usuariosCeldaRel = $usuariosCeldaRel;
    }

    /**
     * @return mixed
     */
    public function getVisitasCeldaRel()
    {
        return $this->visitasCeldaRel;
    }

    /**
     * @param mixed $visitasCeldaRel
     */
    public function setVisitasCeldaRel($visitasCeldaRel): void
    {
        $this->visitasCeldaRel = $visitasCeldaRel;
    }

    /**
     * @return mixed
     */
    public function getReservasDetallesCeldaRel()
    {
        return $this->reservasDetallesCeldaRel;
    }

    /**
     * @param mixed $reservasDetallesCeldaRel
     */
    public function setReservasDetallesCeldaRel($reservasDetallesCeldaRel): void
    {
        $this->reservasDetallesCeldaRel = $reservasDetallesCeldaRel;
    }

    /**
     * @return mixed
     */
    public function getCeldasUsuariosCeldaRel()
    {
        return $this->celdasUsuariosCeldaRel;
    }

    /**
     * @param mixed $celdasUsuariosCeldaRel
     */
    public function setCeldasUsuariosCeldaRel($celdasUsuariosCeldaRel): void
    {
        $this->celdasUsuariosCeldaRel = $celdasUsuariosCeldaRel;
    }

    /**
     * @return mixed
     */
    public function getAtencionesCeldaRel()
    {
        return $this->atencionesCeldaRel;
    }

    /**
     * @param mixed $atencionesCeldaRel
     */
    public function setAtencionesCeldaRel($atencionesCeldaRel): void
    {
        $this->atencionesCeldaRel = $atencionesCeldaRel;
    }

    /**
     * @return bool
     */
    public function isLimitarAnuncio(): bool
    {
        return $this->limitarAnuncio;
    }

    /**
     * @param bool $limitarAnuncio
     */
    public function setLimitarAnuncio(bool $limitarAnuncio): void
    {
        $this->limitarAnuncio = $limitarAnuncio;
    }

    /**
     * @return mixed
     */
    public function getLlave()
    {
        return $this->llave;
    }

    /**
     * @param mixed $llave
     */
    public function setLlave($llave): void
    {
        $this->llave = $llave;
    }

    /**
     * @return float
     */
    public function getCoeficiente(): float
    {
        return $this->coeficiente;
    }

    /**
     * @param float $coeficiente
     */
    public function setCoeficiente(float $coeficiente): void
    {
        $this->coeficiente = $coeficiente;
    }

    /**
     * @return float
     */
    public function getArea(): float
    {
        return $this->area;
    }

    /**
     * @param float $area
     */
    public function setArea(float $area): void
    {
        $this->area = $area;
    }

    /**
     * @return mixed
     */
    public function getCodigoExterno()
    {
        return $this->codigoExterno;
    }

    /**
     * @param mixed $codigoExterno
     */
    public function setCodigoExterno($codigoExterno): void
    {
        $this->codigoExterno = $codigoExterno;
    }

    /**
     * @return mixed
     */
    public function getReunionesDetallesCeldaRel()
    {
        return $this->reunionesDetallesCeldaRel;
    }

    /**
     * @param mixed $reunionesDetallesCeldaRel
     */
    public function setReunionesDetallesCeldaRel($reunionesDetallesCeldaRel): void
    {
        $this->reunionesDetallesCeldaRel = $reunionesDetallesCeldaRel;
    }




}