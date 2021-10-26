<?php


namespace App\Repository;

use App\Entity\Categoria;
use App\Entity\Oferta;
use App\Entity\Panal;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OfertaRepository extends ServiceEntityRepository
{
    private $space;

    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Oferta::class);
        $this->space = $space;
    }

    public function apiLista($codigoPanal)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Oferta::class, 'o')
            ->select('o.codigoOfertaPk')
            ->addSelect('o.fecha')
            ->addSelect('o.descripcion')
            ->addSelect('o.precio')
            ->addSelect('o.urlImagen')
            ->where("o.codigoPanalFk = {$codigoPanal}")
            ->orderBy("o.fecha", "DESC");
        $arOfertas = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'ofertas' => $arOfertas
        ];
    }

    public function apiNuevo($codigoPanal, $descripcion, $precio, $imagen, $categoria)
    {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if ($arPanal) {
            $arCategoria = $em->getRepository(Categoria::class)->find($categoria);
            if ($arCategoria) {
                $arOferta = new Oferta();
                $arOferta->setPanalRel($arPanal);
                $arOferta->setCategoriaRel($arCategoria);
                $arOferta->setFecha(new \DateTime('now'));
                $arOferta->setDescripcion($descripcion);
                $arOferta->setPrecio($precio);
                if ($imagen) {
                    if ($imagen['nombre'] && $imagen['base64']) {
                        $arOferta->setUrlImagen($this->space->subir('oferta', $imagen['nombre'], $imagen['base64']));
                    }
                }
                $em->persist($arOferta);
                $em->flush();
                return [
                    'error' => false,
                    'codigoOferta' => $arOferta->getCodigoOfertaPk()
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe la categoria"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el panal"
            ];
        }
    }
}