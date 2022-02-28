<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DireccionRepository")
 */
class Direccion
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_direccion_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoDireccionPk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer")
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="celular", type="string", length=50)
     */
    private $celular;

    /**
     * @ORM\Column(name="correo", type="string", length=150, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(name="celda", type="string", length=20, nullable=true)
     */
    private $celda;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="direccionesUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movimiento", mappedBy="direccionRel")
     */
    private $movimientosDireccionRel;

    /**
     * @return mixed
     */
    public function getCodigoDireccionPk()
    {
        return $this->codigoDireccionPk;
    }

    /**
     * @param mixed $codigoDireccionPk
     */
    public function setCodigoDireccionPk($codigoDireccionPk): void
    {
        $this->codigoDireccionPk = $codigoDireccionPk;
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
    public function getMovimientosDireccionRel()
    {
        return $this->movimientosDireccionRel;
    }

    /**
     * @param mixed $movimientosDireccionRel
     */
    public function setMovimientosDireccionRel($movimientosDireccionRel): void
    {
        $this->movimientosDireccionRel = $movimientosDireccionRel;
    }


}