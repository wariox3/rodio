<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_usuario_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoUsuarioPk;

    /**
     * @ORM\Column(name="usuario", type="string", length=50)
     */
    private $usuario;

    /**
     * @ORM\Column(name="clave", type="string", length=50)
     */
    private $clave;

    /**
     * @ORM\Column(name="codigo_panal_fk", type="integer", nullable=true)
     */
    private $codigoPanalFk;

    /**
     * @ORM\Column(name="codigo_celda_fk", type="integer", nullable=true)
     */
    private $codigoCeldaFk;

    /**
     * @ORM\Column(name="codigo_operador_fk", type="integer", nullable=true)
     */
    private $codigoOperadorFk;

    /**
     * @ORM\Column(name="celular", type="string", length=50)
     */
    private $celular;

    /**
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */
    private $codigoCiudadFk;

    /**
     * @ORM\Column(name="url_imagen", type="string", length=250)
     */
    private $urlImagen;

    /**
     * @ORM\Column(name="token_firebase", type="string", length=500, nullable=true)
     */
    private $tokenFirebase;

    /**
     * @ORM\Column(name="codigo_puesto_fk", type="integer", nullable=true)
     */
    private $codigoPuestoFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panal", inversedBy="usuariosPanalRel")
     * @ORM\JoinColumn(name="codigo_panal_fk", referencedColumnName="codigo_panal_pk")
     */
    private $panalRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Celda", inversedBy="usuariosCeldaRel")
     * @ORM\JoinColumn(name="codigo_celda_fk", referencedColumnName="codigo_celda_pk")
     */
    private $celdaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciudad", inversedBy="usuariosCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_fk", referencedColumnName="codigo_ciudad_pk")
     */
    private $ciudadRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Operador", inversedBy="usuariosOperadorRel")
     * @ORM\JoinColumn(name="codigo_operador_fk", referencedColumnName="codigo_operador_pk")
     */
    private $operadorRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Publicacion", mappedBy="usuarioRel")
     */
    private $publicacionesUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reporte", mappedBy="usuarioRel")
     */
    private $reportesUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentario", mappedBy="usuarioRel")
     */
    private $comentariosUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reaccion", mappedBy="usuarioRel")
     */
    private $reaccionesUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Celda", mappedBy="usuarioRel")
     */
    private $celdasUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visita", mappedBy="usuarioAutorizaRel")
     */
    private $visitasUsuarioAutorizaRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CeldaUsuario", mappedBy="usuarioRel")
     */
    private $celdasUsuariosUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VotacionCelda", mappedBy="usuarioRel")
     */
    private $votacionesCeldasUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Anotacion", mappedBy="usuarioRel")
     */
    private $anotacionesUsuarioRel;

    /**
     * @return mixed
     */
    public function getCodigoUsuarioPk()
    {
        return $this->codigoUsuarioPk;
    }

    /**
     * @param mixed $codigoUsuarioPk
     */
    public function setCodigoUsuarioPk($codigoUsuarioPk): void
    {
        $this->codigoUsuarioPk = $codigoUsuarioPk;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave): void
    {
        $this->clave = $clave;
    }

    /**
     * @return mixed
     */
    public function getPublicacionesUsuarioRel()
    {
        return $this->publicacionesUsuarioRel;
    }

    /**
     * @param mixed $publicacionesUsuarioRel
     */
    public function setPublicacionesUsuarioRel($publicacionesUsuarioRel): void
    {
        $this->publicacionesUsuarioRel = $publicacionesUsuarioRel;
    }

    /**
     * @return mixed
     */
    public function getCeldasUsuarioRel()
    {
        return $this->celdasUsuarioRel;
    }

    /**
     * @param mixed $celdasUsuarioRel
     */
    public function setCeldasUsuarioRel($celdasUsuarioRel): void
    {
        $this->celdasUsuarioRel = $celdasUsuarioRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoCeldaFk()
    {
        return $this->codigoCeldaFk;
    }

    /**
     * @param mixed $codigoCeldaFk
     */
    public function setCodigoCeldaFk($codigoCeldaFk): void
    {
        $this->codigoCeldaFk = $codigoCeldaFk;
    }

    /**
     * @return mixed
     */
    public function getCeldaRel()
    {
        return $this->celdaRel;
    }

    /**
     * @param mixed $celdaRel
     */
    public function setCeldaRel($celdaRel): void
    {
        $this->celdaRel = $celdaRel;
    }

    /**
     * @return mixed
     */
    public function getVisitasUsuarioAutorizaRel()
    {
        return $this->visitasUsuarioAutorizaRel;
    }

    /**
     * @param mixed $visitasUsuarioAutorizaRel
     */
    public function setVisitasUsuarioAutorizaRel($visitasUsuarioAutorizaRel): void
    {
        $this->visitasUsuarioAutorizaRel = $visitasUsuarioAutorizaRel;
    }

    /**
     * @return mixed
     */
    public function getComentariosUsuarioRel()
    {
        return $this->comentariosUsuarioRel;
    }

    /**
     * @param mixed $comentariosUsuarioRel
     */
    public function setComentariosUsuarioRel($comentariosUsuarioRel): void
    {
        $this->comentariosUsuarioRel = $comentariosUsuarioRel;
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
    public function getReaccionesUsuarioRel()
    {
        return $this->reaccionesUsuarioRel;
    }

    /**
     * @param mixed $reaccionesUsuarioRel
     */
    public function setReaccionesUsuarioRel($reaccionesUsuarioRel): void
    {
        $this->reaccionesUsuarioRel = $reaccionesUsuarioRel;
    }

    /**
     * @return mixed
     */
    public function getTokenFirebase()
    {
        return $this->tokenFirebase;
    }

    /**
     * @param mixed $tokenFirebase
     */
    public function setTokenFirebase($tokenFirebase): void
    {
        $this->tokenFirebase = $tokenFirebase;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadFk()
    {
        return $this->codigoCiudadFk;
    }

    /**
     * @param mixed $codigoCiudadFk
     */
    public function setCodigoCiudadFk($codigoCiudadFk): void
    {
        $this->codigoCiudadFk = $codigoCiudadFk;
    }

    /**
     * @return mixed
     */
    public function getCiudadRel()
    {
        return $this->ciudadRel;
    }

    /**
     * @param mixed $ciudadRel
     */
    public function setCiudadRel($ciudadRel): void
    {
        $this->ciudadRel = $ciudadRel;
    }

    /**
     * @return mixed
     */
    public function getCeldasUsuariosUsuarioRel()
    {
        return $this->celdasUsuariosUsuarioRel;
    }

    /**
     * @param mixed $celdasUsuariosUsuarioRel
     */
    public function setCeldasUsuariosUsuarioRel($celdasUsuariosUsuarioRel): void
    {
        $this->celdasUsuariosUsuarioRel = $celdasUsuariosUsuarioRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoOperadorFk()
    {
        return $this->codigoOperadorFk;
    }

    /**
     * @param mixed $codigoOperadorFk
     */
    public function setCodigoOperadorFk($codigoOperadorFk): void
    {
        $this->codigoOperadorFk = $codigoOperadorFk;
    }

    /**
     * @return mixed
     */
    public function getOperadorRel()
    {
        return $this->operadorRel;
    }

    /**
     * @param mixed $operadorRel
     */
    public function setOperadorRel($operadorRel): void
    {
        $this->operadorRel = $operadorRel;
    }

    /**
     * @return mixed
     */
    public function getVotacionesCeldasUsuarioRel()
    {
        return $this->votacionesCeldasUsuarioRel;
    }

    /**
     * @param mixed $votacionesCeldasUsuarioRel
     */
    public function setVotacionesCeldasUsuarioRel($votacionesCeldasUsuarioRel): void
    {
        $this->votacionesCeldasUsuarioRel = $votacionesCeldasUsuarioRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoPuestoFk()
    {
        return $this->codigoPuestoFk;
    }

    /**
     * @param mixed $codigoPuestoFk
     */
    public function setCodigoPuestoFk($codigoPuestoFk): void
    {
        $this->codigoPuestoFk = $codigoPuestoFk;
    }

    /**
     * @return mixed
     */
    public function getReportesUsuarioRel()
    {
        return $this->reportesUsuarioRel;
    }

    /**
     * @param mixed $reportesUsuarioRel
     */
    public function setReportesUsuarioRel($reportesUsuarioRel): void
    {
        $this->reportesUsuarioRel = $reportesUsuarioRel;
    }

    /**
     * @return mixed
     */
    public function getAnotacionesUsuarioRel()
    {
        return $this->anotacionesUsuarioRel;
    }

    /**
     * @param mixed $anotacionesUsuarioRel
     */
    public function setAnotacionesUsuarioRel($anotacionesUsuarioRel): void
    {
        $this->anotacionesUsuarioRel = $anotacionesUsuarioRel;
    }



}