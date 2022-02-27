<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PublicacionRepository")
 */
class Publicacion
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_publicacion_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoPublicacionPk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer")
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="comentario", type="string", length=250, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="codigo_panal_fk", type="integer", nullable=false)
     */
    private $codigoPanalFk;

    /**
     * @ORM\Column(name="url_imagen", type="string", length=500, nullable=true)
     */
    private $urlImagen;

    /**
     * @ORM\Column(name="reacciones", type="integer", options={"default" : 0})
     */
    private $reacciones = 0;

    /**
     * @ORM\Column(name="comentarios", type="integer", options={"default" : 0})
     */
    private $comentarios = 0;

    /**
     * @ORM\Column(name="estado_aprobado", type="boolean", options={"default" : true}, nullable=true)
     */
    private $estadoAprobado = true;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panal", inversedBy="publicacionesPanalRel")
     * @ORM\JoinColumn(name="codigo_panal_fk", referencedColumnName="codigo_panal_pk")
     */
    private $panalRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="publicacionesUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentario", mappedBy="publicacionRel")
     */
    private $comentariosPublicacionRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reaccion", mappedBy="publicacionRel")
     */
    private $reaccionesPublicacionRel;

    /**
     * @return mixed
     */
    public function getCodigoPublicacionPk()
    {
        return $this->codigoPublicacionPk;
    }

    /**
     * @param mixed $codigoPublicacionPk
     */
    public function setCodigoPublicacionPk($codigoPublicacionPk): void
    {
        $this->codigoPublicacionPk = $codigoPublicacionPk;
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
     * @return int
     */
    public function getReacciones(): int
    {
        return $this->reacciones;
    }

    /**
     * @param int $reacciones
     */
    public function setReacciones(int $reacciones): void
    {
        $this->reacciones = $reacciones;
    }

    /**
     * @return int
     */
    public function getComentarios(): int
    {
        return $this->comentarios;
    }

    /**
     * @param int $comentarios
     */
    public function setComentarios(int $comentarios): void
    {
        $this->comentarios = $comentarios;
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

    /**
     * @return mixed
     */
    public function getComentariosPublicacionRel()
    {
        return $this->comentariosPublicacionRel;
    }

    /**
     * @param mixed $comentariosPublicacionRel
     */
    public function setComentariosPublicacionRel($comentariosPublicacionRel): void
    {
        $this->comentariosPublicacionRel = $comentariosPublicacionRel;
    }

    /**
     * @return mixed
     */
    public function getReaccionesPublicacionRel()
    {
        return $this->reaccionesPublicacionRel;
    }

    /**
     * @param mixed $reaccionesPublicacionRel
     */
    public function setReaccionesPublicacionRel($reaccionesPublicacionRel): void
    {
        $this->reaccionesPublicacionRel = $reaccionesPublicacionRel;
    }

    /**
     * @return bool
     */
    public function isEstadoAprobado(): bool
    {
        return $this->estadoAprobado;
    }

    /**
     * @param bool $estadoAprobado
     */
    public function setEstadoAprobado(bool $estadoAprobado): void
    {
        $this->estadoAprobado = $estadoAprobado;
    }

}