<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComentarioRepository")
 */
class Comentario
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_comentario_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoComentarioPk;

    /**
     * @ORM\Column(name="codigo_publicacion_fk", type="integer", nullable=false)
     */
    private $codigoPublicacionFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="comentario", type="string", length=250, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer", nullable=false)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Publicacion", inversedBy="comentariosPublicacionRel")
     * @ORM\JoinColumn(name="codigo_publicacion_fk", referencedColumnName="codigo_publicacion_pk")
     */
    private $publicacionRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="comentariosUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @return mixed
     */
    public function getCodigoComentarioPk()
    {
        return $this->codigoComentarioPk;
    }

    /**
     * @param mixed $codigoComentarioPk
     */
    public function setCodigoComentarioPk($codigoComentarioPk): void
    {
        $this->codigoComentarioPk = $codigoComentarioPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoPublicacionFk()
    {
        return $this->codigoPublicacionFk;
    }

    /**
     * @param mixed $codigoPublicacionFk
     */
    public function setCodigoPublicacionFk($codigoPublicacionFk): void
    {
        $this->codigoPublicacionFk = $codigoPublicacionFk;
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
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
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
    public function getPublicacionRel()
    {
        return $this->publicacionRel;
    }

    /**
     * @param mixed $publicacionRel
     */
    public function setPublicacionRel($publicacionRel): void
    {
        $this->publicacionRel = $publicacionRel;
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