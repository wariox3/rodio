<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperadorRepository")
 */
class Operador
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_operador_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoOperadorPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="sincronizar", type="boolean", options={"default" : false}, nullable=true)
     */
    private $sincronizar = false;

    /**
     * @ORM\Column(name="punto_servicio_cromo", type="string", length=200, nullable=true)
     */
    private $puntoServicioCromo;

    /**
     * @ORM\Column(name="punto_servicio_cromo_token", type="string", length=100, nullable=true)
     */
    private $puntoServicioCromoToken;

    /**
     * @ORM\Column(name="token", type="string", length=100, nullable=true)
     */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuario", mappedBy="operadorRel")
     */
    private $usuariosOperadorRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Control", mappedBy="operadorRel")
     */
    private $controlesOperadorRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Formulario", mappedBy="operadorRel")
     */
    private $formulariosOperadorRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evento", mappedBy="operadorRel")
     */
    private $eventosOperadorRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Puesto", mappedBy="operadorRel")
     */
    private $puestosOperadorRel;

    /**
     * @return mixed
     */
    public function getCodigoOperadorPk()
    {
        return $this->codigoOperadorPk;
    }

    /**
     * @param mixed $codigoOperadorPk
     */
    public function setCodigoOperadorPk($codigoOperadorPk): void
    {
        $this->codigoOperadorPk = $codigoOperadorPk;
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
     * @return bool
     */
    public function isSincronizar(): bool
    {
        return $this->sincronizar;
    }

    /**
     * @param bool $sincronizar
     */
    public function setSincronizar(bool $sincronizar): void
    {
        $this->sincronizar = $sincronizar;
    }

    /**
     * @return mixed
     */
    public function getPuntoServicioCromo()
    {
        return $this->puntoServicioCromo;
    }

    /**
     * @param mixed $puntoServicioCromo
     */
    public function setPuntoServicioCromo($puntoServicioCromo): void
    {
        $this->puntoServicioCromo = $puntoServicioCromo;
    }

    /**
     * @return mixed
     */
    public function getUsuariosOperadorRel()
    {
        return $this->usuariosOperadorRel;
    }

    /**
     * @param mixed $usuariosOperadorRel
     */
    public function setUsuariosOperadorRel($usuariosOperadorRel): void
    {
        $this->usuariosOperadorRel = $usuariosOperadorRel;
    }

    /**
     * @return mixed
     */
    public function getControlesOperadorRel()
    {
        return $this->controlesOperadorRel;
    }

    /**
     * @param mixed $controlesOperadorRel
     */
    public function setControlesOperadorRel($controlesOperadorRel): void
    {
        $this->controlesOperadorRel = $controlesOperadorRel;
    }

    /**
     * @return mixed
     */
    public function getFormulariosOperadorRel()
    {
        return $this->formulariosOperadorRel;
    }

    /**
     * @param mixed $formulariosOperadorRel
     */
    public function setFormulariosOperadorRel($formulariosOperadorRel): void
    {
        $this->formulariosOperadorRel = $formulariosOperadorRel;
    }

    /**
     * @return mixed
     */
    public function getEventosOperadorRel()
    {
        return $this->eventosOperadorRel;
    }

    /**
     * @param mixed $eventosOperadorRel
     */
    public function setEventosOperadorRel($eventosOperadorRel): void
    {
        $this->eventosOperadorRel = $eventosOperadorRel;
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
    public function getPuestosOperadorRel()
    {
        return $this->puestosOperadorRel;
    }

    /**
     * @param mixed $puestosOperadorRel
     */
    public function setPuestosOperadorRel($puestosOperadorRel): void
    {
        $this->puestosOperadorRel = $puestosOperadorRel;
    }

    /**
     * @return mixed
     */
    public function getPuntoServicioCromoToken()
    {
        return $this->puntoServicioCromoToken;
    }

    /**
     * @param mixed $puntoServicioCromoToken
     */
    public function setPuntoServicioCromoToken($puntoServicioCromoToken): void
    {
        $this->puntoServicioCromoToken = $puntoServicioCromoToken;
    }



}