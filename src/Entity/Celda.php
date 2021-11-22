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
     * @ORM\Column(name="celular", type="string", length=20, nullable=true)
     */
    private $celular;

    /**
     * @ORM\Column(name="correo", type="string", length=150, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(name="propietario", type="string", length=200, nullable=true)
     */
    private $propietario;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Reserva", mappedBy="celdaRel")
     */
    private $reservasCeldaRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CeldaUsuario", mappedBy="celdaRel")
     */
    private $celdasUsuariosCeldaRel;

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
    public function getPropietario()
    {
        return $this->propietario;
    }

    /**
     * @param mixed $propietario
     */
    public function setPropietario($propietario): void
    {
        $this->propietario = $propietario;
    }

    /**
     * @return mixed
     */
    public function getReservasCeldaRel()
    {
        return $this->reservasCeldaRel;
    }

    /**
     * @param mixed $reservasCeldaRel
     */
    public function setReservasCeldaRel($reservasCeldaRel): void
    {
        $this->reservasCeldaRel = $reservasCeldaRel;
    }


}