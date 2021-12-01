<?php


namespace App\Repository;

use App\Entity\Anotacion;
use App\Entity\Archivo;
use App\Entity\Evento;
use App\Entity\Usuario;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventoRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Evento::class);
        $this->space = $space;
    }

    public function apiLista($codigoPuesto)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Evento::class, 'e')
            ->select('e.codigoEventoPk')
            ->addSelect('e.fecha')
            ->addSelect('e.comentario')
            ->where("e.codigoPuestoFk = {$codigoPuesto}");
        $arEventos = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'eventos' => $arEventos
        ];
        return $respuesta;
    }

    public function apiNuevo($codigoUsuario, $codigoPuesto, $comentario, $arrArchivos)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arEvento = new Evento();
            $arEvento->setFecha(new \DateTime('now'));
            $arEvento->setCodigoPuestoFk($codigoPuesto);
            $arEvento->setComentario($comentario);
            $em->persist($arEvento);
            $em->flush();
            if($arrArchivos) {
                foreach ($arrArchivos as $arrArchivo) {
                    $arArchivo = new Archivo();
                    $arArchivo->setCodigoArchivoTipoFk($arrArchivo['tipo']);
                    $arArchivo->setCodigoModeloFk('Evento');
                    $arArchivo->setCodigo($arEvento->getCodigoEventoPk());
                    $arArchivo->setNombre($arrArchivo['nombre']);
                    $arArchivo->setRuta($this->space->subir("anotacion/{$arrArchivo['tipo']}", $arrArchivo['nombre'], $arrArchivo['base64']));
                    $em->persist($arArchivo);
                }
            }
            $em->flush();
            return [
                'error' => false,
                'codigoEvento' => $arEvento->getCodigoEventoPk()
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }

}