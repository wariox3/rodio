<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoTipoRepository")
 */
class EventoTipo
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_evento_tipo_pk", type="string", length=10)
     */
    private $codigoEventoTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evento", mappedBy="eventoTipoRel")
     */
    private $eventosEventoTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoEventoTipoPk()
    {
        return $this->codigoEventoTipoPk;
    }

    /**
     * @param mixed $codigoEventoTipoPk
     */
    public function setCodigoEventoTipoPk($codigoEventoTipoPk): void
    {
        $this->codigoEventoTipoPk = $codigoEventoTipoPk;
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
    public function getEventosEventoTipoRel()
    {
        return $this->eventosEventoTipoRel;
    }

    /**
     * @param mixed $eventosEventoTipoRel
     */
    public function setEventosEventoTipoRel($eventosEventoTipoRel): void
    {
        $this->eventosEventoTipoRel = $eventosEventoTipoRel;
    }


}