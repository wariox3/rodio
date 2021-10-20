<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CeldaUsuarioRepository")
 */
class CeldaUsuario
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_celda_usuario_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCeldaUaurioPk;

    /**
     * @ORM\Column(name="codigo_celda_fk", type="integer")
     */
    private $codigoCeldaFk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer")
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="validado", type="boolean", options={"default" : false}, nullable=true)
     */
    private $validado = false;

    /**
     * @ORM\Column(name="llave", type="string", length=10, nullable=true)
     */
    private $llave;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Celda", inversedBy="celdasUsuariosCeldaRel")
     * @ORM\JoinColumn(name="codigo_celda_fk", referencedColumnName="codigo_celda_pk")
     */
    private $celdaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="celdasUsuariosUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @return mixed
     */
    public function getCodigoCeldaUaurioPk()
    {
        return $this->codigoCeldaUaurioPk;
    }

    /**
     * @param mixed $codigoCeldaUaurioPk
     */
    public function setCodigoCeldaUaurioPk($codigoCeldaUaurioPk): void
    {
        $this->codigoCeldaUaurioPk = $codigoCeldaUaurioPk;
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
     * @return bool
     */
    public function isValidado(): bool
    {
        return $this->validado;
    }

    /**
     * @param bool $validado
     */
    public function setValidado(bool $validado): void
    {
        $this->validado = $validado;
    }

    /**
     * @return mixed
     */
    public function getLlave()
    {
        return $this->llave;
    }

    /**
     * @param mixed $llave
     */
    public function setLlave($llave): void
    {
        $this->llave = $llave;
    }


}