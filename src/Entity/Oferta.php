<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfertaRepository")
 */
class Oferta
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_oferta_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoOfertaPk;



}