<?php


namespace App\Repository;

use App\Entity\Anotacion;
use App\Entity\AnotacionTipo;
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
            ->addSelect('at.nombre as anotacionTipoNombre')
            ->leftJoin('a.anotacionTipoRel', 'at')
            ->where("a.codigoPuestoFk = {$codigoPuesto}")
            ->orderBy('a.fecha','DESC');
        $arAnotaciones = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'anotaciones' => $arAnotaciones
        ];
        return $respuesta;
    }

    public function apiDetalle($codigoAnotacion)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Anotacion::class, 'a')
            ->select('a.codigoAnotacionPk')
            ->addSelect('a.fecha')
            ->addSelect('a.comentario')
            ->addSelect('a.comentario')
            ->addSelect('at.nombre as tipo')
            ->leftJoin('a.anotacionTipoRel', 'at')
            ->where("a.codigoAnotacionPk = {$codigoAnotacion}");
        $arAnotaciones = $queryBuilder->getQuery()->getResult();

        $queryBuilder = $em->createQueryBuilder()->from(Archivo::class, 'a')
            ->select('a.codigoArchivoPk')
            ->addSelect('a.nombre')
            ->addSelect("CONCAT('{$_ENV['ALMACENAMIENTO_URL']}', a.url) as url")
            ->addSelect('a.codigoArchivoTipoFk as tipo')
            ->where("a.codigoModeloFk = 'Anotacion' ")
            ->andWhere("a.codigo = {$codigoAnotacion}");
        $arArchivos = $queryBuilder->getQuery()->getResult();
        $respuesta = [
            'error' => false,
            'anotacion' => $arAnotaciones,
            'archivos' => $arArchivos
        ];
        return $respuesta;
    }

    public function apiNuevo($codigoUsuario, $codigoPuesto, $comentario, $tipo, $arrArchivos)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if ($arUsuario) {
            if ($tipo) {
                $arAnotacionTipo = $em->getRepository(AnotacionTipo::class)->find($tipo);
                if ($arAnotacionTipo) {
                    $arAnotacion = new Anotacion();
                    $arAnotacion->setAnotacionTipoRel($arAnotacionTipo);
                    $arAnotacion->setUsuarioRel($arUsuario);
                    $arAnotacion->setFecha(new \DateTime('now'));
                    $arAnotacion->setCodigoPuestoFk($codigoPuesto);
                    $arAnotacion->setComentario($comentario);
                    $em->persist($arAnotacion);
                    $em->flush();
                    if ($arrArchivos) {
                        foreach ($arrArchivos as $arrArchivo) {
                            $arArchivo = new Archivo();
                            $arArchivo->setCodigoArchivoTipoFk($arrArchivo['tipo']);
                            $arArchivo->setCodigoModeloFk('Anotacion');
                            $arArchivo->setCodigo($arAnotacion->getCodigoAnotacionPk());
                            $arArchivo->setNombre($arrArchivo['nombre']);
                            $archivo = $this->space->subir("anotacion", $arrArchivo['base64']);
                            $arArchivo->setUrl($archivo['url']);
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
                        'errorMensaje' => "El tipo de anotación no existe"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "El código tipo no puede estas vacío"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }
}