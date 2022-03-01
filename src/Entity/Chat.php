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
     * @ORM\Column(name="codigo_usuario_emisor_fk", type="integer")
     */
    private $codigoUsuarioEmisorFk;

    /**
     * @ORM\Column(name="codigo_usuario_receptor_fk", type="integer", nullable=true)
     */
    private $codigoUsuarioReceptorFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Oferta", inversedBy="chatsOfertaRel")
     * @ORM\JoinColumn(name="codigo_oferta_fk", referencedColumnName="codigo_oferta_pk")
     */
    private $ofertaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="chatsUsuarioEmisorRel")
     * @ORM\JoinColumn(name="codigo_usuario_emisor_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioEmisorRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="chatsUsuarioReceptorRel")
     * @ORM\JoinColumn(name="codigo_usuario_receptor_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioReceptorRel;

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
    public function getCodigoUsuarioEmisorFk()
    {
        return $this->codigoUsuarioEmisorFk;
    }

    /**
     * @param mixed $codigoUsuarioEmisorFk
     */
    public function setCodigoUsuarioEmisorFk($codigoUsuarioEmisorFk): void
    {
        $this->codigoUsuarioEmisorFk = $codigoUsuarioEmisorFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioReceptorFk()
    {
        return $this->codigoUsuarioReceptorFk;
    }

    /**
     * @param mixed $codigoUsuarioReceptorFk
     */
    public function setCodigoUsuarioReceptorFk($codigoUsuarioReceptorFk): void
    {
        $this->codigoUsuarioReceptorFk = $codigoUsuarioReceptorFk;
    }

    /**
     * @return mixed
     */
    public function getUsuarioEmisorRel()
    {
        return $this->usuarioEmisorRel;
    }

    /**
     * @param mixed $usuarioEmisorRel
     */
    public function setUsuarioEmisorRel($usuarioEmisorRel): void
    {
        $this->usuarioEmisorRel = $usuarioEmisorRel;
    }

    /**
     * @return mixed
     */
    public function getUsuarioReceptorRel()
    {
        return $this->usuarioReceptorRel;
    }

    /**
     * @param mixed $usuarioReceptorRel
     */
    public function setUsuarioReceptorRel($usuarioReceptorRel): void
    {
        $this->usuarioReceptorRel = $usuarioReceptorRel;
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



}