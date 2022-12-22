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
     * @ORM\Column(name="token", type="string", length=100, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(name="usuario_servicio", type="string", length=50, nullable=true)
     */
    private $usuarioServicio;

    /**
     * @ORM\Column(name="clave_servicio", type="string", length=50, nullable=true)
     */
    private $claveServicio;

    /**
     * @ORM\Column(name="transporte", type="boolean", options={"default" : false}, nullable=true)
     */
    private $transporte = false;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Viaje", mappedBy="operadorRel")
     */
    private $viajesOperadorRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Despacho", mappedBy="operadorRel")
     */
    private $despachosOperadorRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Guia", mappedBy="operadorRel")
     */
    private $guiasOperadorRel;

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
    public function getViajesOperadorRel()
    {
        return $this->viajesOperadorRel;
    }

    /**
     * @param mixed $viajesOperadorRel
     */
    public function setViajesOperadorRel($viajesOperadorRel): void
    {
        $this->viajesOperadorRel = $viajesOperadorRel;
    }

    /**
     * @return mixed
     */
    public function getDespachosOperadorRel()
    {
        return $this->despachosOperadorRel;
    }

    /**
     * @param mixed $despachosOperadorRel
     */
    public function setDespachosOperadorRel($despachosOperadorRel): void
    {
        $this->despachosOperadorRel = $despachosOperadorRel;
    }

    /**
     * @return mixed
     */
    public function getGuiasOperadorRel()
    {
        return $this->guiasOperadorRel;
    }

    /**
     * @param mixed $guiasOperadorRel
     */
    public function setGuiasOperadorRel($guiasOperadorRel): void
    {
        $this->guiasOperadorRel = $guiasOperadorRel;
    }

    /**
     * @return mixed
     */
    public function getUsuarioServicio()
    {
        return $this->usuarioServicio;
    }

    /**
     * @param mixed $usuarioServicio
     */
    public function setUsuarioServicio($usuarioServicio): void
    {
        $this->usuarioServicio = $usuarioServicio;
    }

    /**
     * @return mixed
     */
    public function getClaveServicio()
    {
        return $this->claveServicio;
    }

    /**
     * @param mixed $claveServicio
     */
    public function setClaveServicio($claveServicio): void
    {
        $this->claveServicio = $claveServicio;
    }

    /**
     * @return bool
     */
    public function isTransporte(): bool
    {
        return $this->transporte;
    }

    /**
     * @param bool $transporte
     */
    public function setTransporte(bool $transporte): void
    {
        $this->transporte = $transporte;
    }

}