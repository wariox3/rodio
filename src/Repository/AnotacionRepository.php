<?php


namespace App\Repository;

use App\Entity\Anotacion;
use App\Entity\Archivo;
use App\Entity\Usuario;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AnotacionRepository extends ServiceEntityRepository
{
    private $space;
    public function __construct(ManagerRegistry $registry, SpaceDO $space)
    {
        parent::__construct($registry, Anotacion::class);
        $this->space = $space;
    }

    public function apiLista($codigoPuesto)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Anotacion::class, 'a')
            ->select('a.codigoAnotacionPk')
            ->addSelect('a.fecha')
            ->addSelect('a.comentario')
            ->where("a.codigoPuestoFk = {$codigoPuesto}");
        $arAnotaciones = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'anotaciones' => $arAnotaciones
        ];
        return $respuesta;
    }

    public function apiNuevo($codigoUsuario, $codigoPuesto, $comentario, $arrArchivos)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arAnotacion = new Anotacion();
            $arAnotacion->setUsuarioRel($arUsuario);
            $arAnotacion->setFecha(new \DateTime('now'));
            $arAnotacion->setCodigoPuestoFk($codigoPuesto);
            $arAnotacion->setComentario($comentario);
            $em->persist($arAnotacion);
            $em->flush();
            if($arrArchivos) {
                foreach ($arrArchivos as $arrArchivo) {
                    $arArchivo = new Archivo();
                    $arArchivo->setCodigoArchivoTipoFk($arrArchivo['tipo']);
                    $arArchivo->setCodigoModeloFk('Anotacion');
                    $arArchivo->setCodigo($arAnotacion->getCodigoAnotacionPk());
                    $arArchivo->setNombre($arrArchivo['nombre']);
                    $arArchivo->setRuta($this->space->subir("anotacion/{$arrArchivo['tipo']}", $arrArchivo['nombre'], $arrArchivo['base64']));
                    $em->persist($arArchivo);
                }
            }
            $em->flush();
            return [
                'error' => false,
                'codigoAnotacion' => $arAnotacion->getCodigoAnotacionPk()
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }
}