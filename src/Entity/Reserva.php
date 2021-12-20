<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservaRepository")
 */
class Reserva
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_reserva_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoReservaPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=200, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_panal_fk", type="integer")
     */
    private $codigoPanalFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panal", inversedBy="reservasPanalRel")
     * @ORM\JoinColumn(name="codigo_panal_fk", referencedColumnName="codigo_panal_pk")
     */
    private $panalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReservaDetalle", mappedBy="reservaRel")
     */
    private $reservasDetallesReservaRel;

    /**
     * @return mixed
     */
    public function getCodigoReservaPk()
    {
        return $this->codigoReservaPk;
    }

    /**
     * @param mixed $codigoReservaPk
     */
    public function setCodigoReservaPk($codigoReservaPk): void
    {
        $this->codigoReservaPk = $codigoReservaPk;
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
    public function getReservasDetallesReservaRel()
    {
        return $this->reservasDetallesReservaRel;
    }

    /**
     * @param mixed $reservasDetallesReservaRel
     */
    public function setReservasDetallesReservaRel($reservasDetallesReservaRel): void
    {
        $this->reservasDetallesReservaRel = $reservasDetallesReservaRel;
    }



}