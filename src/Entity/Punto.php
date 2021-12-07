<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PuntoRepository")
 */
class Punto
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_punto_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoPuntoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_ronda_fk", type="integer")
     */
    private $codigoRondaFk;

    /**
     * @ORM\Column(name="codigo_punto_interface", type="integer", nullable=true)
     */
    private $codigoPuntoInterface;

    /**
     * @ORM\Column(name="token", type="string", length=60)
     */
    private $token;

    /**
     * @ORM\Column(name="tiempo", type="time", nullable=true)
     */
    private $tiempo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ronda", inversedBy="puntosRondaRel")
     * @ORM\JoinColumn(name="codigo_ronda_fk", referencedColumnName="codigo_ronda_pk")
     */
    private $rondaRel;

    /**
     * @return mixed
     */
    public function getCodigoPuntoPk()
    {
        return $this->codigoPuntoPk;
    }

    /**
     * @param mixed $codigoPuntoPk
     */
    public function setCodigoPuntoPk($codigoPuntoPk): void
    {
        $this->codigoPuntoPk = $codigoPuntoPk;
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
    public function getCodigoRondaFk()
    {
        return $this->codigoRondaFk;
    }

    /**
     * @param mixed $codigoRondaFk
     */
    public function setCodigoRondaFk($codigoRondaFk): void
    {
        $this->codigoRondaFk = $codigoRondaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoPuntoInterface()
    {
        return $this->codigoPuntoInterface;
    }

    /**
     * @param mixed $codigoPuntoInterface
     */
    public function setCodigoPuntoInterface($codigoPuntoInterface): void
    {
        $this->codigoPuntoInterface = $codigoPuntoInterface;
    }

    /**
     * @return mixed
     */
    public function getRondaRel()
    {
        return $this->rondaRel;
    }

    /**
     * @param mixed $rondaRel
     */
    public function setRondaRel($rondaRel): void
    {
        $this->rondaRel = $rondaRel;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * @param mixed $tiempo
     */
    public function setTiempo($tiempo): void
    {
        $this->tiempo = $tiempo;
    }



}