<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\CeldaUsuario;
use App\Entity\Direccion;
use App\Entity\Item;
use App\Entity\Movimiento;
use App\Entity\MovimientoClase;
use App\Entity\MovimientoDetalle;
use App\Entity\Panal;
use App\Entity\Usuario;
use App\Entity\Visita;
use App\Utilidades\Firebase;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DireccionRepository extends ServiceEntityRepository
{
    private $firebase;
    private $space;

    public function __construct(ManagerRegistry $registry, Firebase $firebase, SpaceDO $space)
    {
        parent::__construct($registry, Direccion::class);
        $this->firebase = $firebase;
        $this->space = $space;
    }

    public function apiListaUsuario($codigoUsuario)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $queryBuilder = $em->createQueryBuilder()->from(Direccion::class, 'd')
                ->select('d.codigoDireccionPk')
                ->addSelect('d.codigoUsuarioFk')
                ->addSelect('d.nombre')
                ->addSelect('d.celda')
                ->addSelect('d.celular')
                ->addSelect('d.correo')
                ->where("d.codigoUsuarioFk = {$codigoUsuario}");
            $arDirecciones = $queryBuilder->getQuery()->getResult();
            if(!$arDirecciones) {
                $arDireccion = new Direccion();
                $arDireccion->setUsuarioRel($arUsuario);
                $arDireccion->setNombre($arUsuario->getNombre());
                $celda = null;
                if($arUsuario->getCeldaRel()) {
                    $celda = $arUsuario->getCeldaRel()->getCelda();
                }
                $arDireccion->setCelda($celda);
                $arDireccion->setCelular($arUsuario->getCelular());
                $arDireccion->setCorreo($arUsuario->getUsuario());
                $em->persist($arDireccion);
                $em->flush();
                $queryBuilder = $em->createQueryBuilder()->from(Direccion::class, 'd')
                    ->select('d.codigoDireccionPk')
                    ->addSelect('d.codigoUsuarioFk')
                    ->addSelect('d.nombre')
                    ->addSelect('d.celda')
                    ->addSelect('d.celular')
                    ->addSelect('d.correo')
                    ->where("d.codigoUsuarioFk = {$codigoUsuario}");
                $arDirecciones = $queryBuilder->getQuery()->getResult();
            }
            return [
                'error' => false,
                'direcciones' => $arDirecciones
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El usuario no existe"
            ];
        }


    }

    public function apiActualizar($codigoDireccion, $nombre, $celda, $celular, $correo)
    {
        $em = $this->getEntityManager();
        $arDireccion = $em->getRepository(Direccion::class)->find($codigoDireccion);
        if($arDireccion) {
            $arDireccion->setNombre($nombre);
            $arDireccion->setCelda($celda);
            $arDireccion->setCelular($celular);
            $arDireccion->setCorreo($correo);
            $em->persist($arDireccion);
            $em->flush();
            return [
                'error' => false
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "La direccion no existe"
            ];
        }


    }

    public function apiConsulta($codigoDireccion)
    {
        $em = $this->getEntityManager();
        $arDireccion = $em->getRepository(Direccion::class)->find($codigoDireccion);
        if($arDireccion) {
            return [
                'error' => false,
                'nombre' => $arDireccion->getNombre(),
                'celda' => $arDireccion->getCelda(),
                'celular' => $arDireccion->getCelular(),
                'correo' => $arDireccion->getCorreo(),
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "La direccion no existe"
            ];
        }


    }
}