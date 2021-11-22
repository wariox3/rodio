<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservaItemRepository")
 */
class ReservaItem
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_reserva_item_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoReservaItemPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=200, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_panal_fk", type="integer")
     */
    private $codigoPanalFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panal", inversedBy="reservasItemesPanalRel")
     * @ORM\JoinColumn(name="codigo_panal_fk", referencedColumnName="codigo_panal_pk")
     */
    private $panalRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reserva", mappedBy="reservaItemRel")
     */
    private $reservasReservaItemRel;

    /**
     * @return mixed
     */
    public function getCodigoReservaItemPk()
    {
        return $this->codigoReservaItemPk;
    }

    /**
     * @param mixed $codigoReservaItemPk
     */
    public function setCodigoReservaItemPk($codigoReservaItemPk): void
    {
        $this->codigoReservaItemPk = $codigoReservaItemPk;
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
    public function getReservasReservaItemRel()
    {
        return $this->reservasReservaItemRel;
    }

    /**
     * @param mixed $reservasReservaItemRel
     */
    public function setReservasReservaItemRel($reservasReservaItemRel): void
    {
        $this->reservasReservaItemRel = $reservasReservaItemRel;
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



}