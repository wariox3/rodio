<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChatRepository")
 */
class Chat
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_chat_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoChatPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="codigo_oferta_fk", type="integer", nullable=false)
     */
    private $codigoOfertaFk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer")
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Oferta", inversedBy="chatsOfertaRel")
     * @ORM\JoinColumn(name="codigo_oferta_fk", referencedColumnName="codigo_oferta_pk")
     */
    private $ofertaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="chatsUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @return mixed
     */
    public function getCodigoChatPk()
    {
        return $this->codigoChatPk;
    }

    /**
     * @param mixed $codigoChatPk
     */
    public function setCodigoChatPk($codigoChatPk): void
    {
        $this->codigoChatPk = $codigoChatPk;
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
    public function getCodigoOfertaFk()
    {
        return $this->codigoOfertaFk;
    }

    /**
     * @param mixed $codigoOfertaFk
     */
    public function setCodigoOfertaFk($codigoOfertaFk): void
    {
        $this->codigoOfertaFk = $codigoOfertaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioFk()
    {
        return $this->codigoUsuarioFk;
    }

    /**
     * @param mixed $codigoUsuarioFk
     */
    public function setCodigoUsuarioFk($codigoUsuarioFk): void
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;
    }

    /**
     * @return mixed
     */
    public function getOfertaRel()
    {
        return $this->ofertaRel;
    }

    /**
     * @param mixed $ofertaRel
     */
    public function setOfertaRel($ofertaRel): void
    {
        $this->ofertaRel = $ofertaRel;
    }

    /**
     * @return mixed
     */
    public function getUsuarioRel()
    {
        return $this->usuarioRel;
    }

    /**
     * @param mixed $usuarioRel
     */
    public function setUsuarioRel($usuarioRel): void
    {
        $this->usuarioRel = $usuarioRel;
    }



}