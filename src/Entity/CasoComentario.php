<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CasoComentarioRepository")
 */
class CasoComentario
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_caso_comentario_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCasoComentarioPk;

    /**
     * @ORM\Column(name="codigo_caso_fk", type="integer", nullable=false)
     */
    private $codigoCasoFk;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Caso", inversedBy="casosComentariosCasoRel")
     * @ORM\JoinColumn(name="codigo_caso_fk", referencedColumnName="codigo_caso_pk")
     */
    private $casoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="casosComentariosUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @return mixed
     */
    public function getCodigoCasoComentarioPk()
    {
        return $this->codigoCasoComentarioPk;
    }

    /**
     * @param mixed $codigoCasoComentarioPk
     */
    public function setCodigoCasoComentarioPk($codigoCasoComentarioPk): void
    {
        $this->codigoCasoComentarioPk = $codigoCasoComentarioPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCasoFk()
    {
        return $this->codigoCasoFk;
    }

    /**
     * @param mixed $codigoCasoFk
     */
    public function setCodigoCasoFk($codigoCasoFk): void
    {
        $this->codigoCasoFk = $codigoCasoFk;
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
    public function getCasoRel()
    {
        return $this->casoRel;
    }

    /**
     * @param mixed $casoRel
     */
    public function setCasoRel($casoRel): void
    {
        $this->casoRel = $casoRel;
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