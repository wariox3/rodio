<?php

namespace App\Repository;

use App\Entity\CeldaUsuario;
use App\Entity\Control;
use App\Entity\Usuario;
use App\Utilidades\Firebase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ControlRepository  extends ServiceEntityRepository
{
    private $firebase;


    public function __construct(ManagerRegistry $registry, Firebase $firebase)
    {
        parent::__construct($registry, Control::class);
        $this->firebase = $firebase;
    }

    public function apiNuevo($codigoUsuario, $codigoPuesto, $fechaControl)
    {
        $em = $this->getEntityManager();
        $usuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($usuario) {
            if($fechaControl){
                $fechaControl = date_create($fechaControl);
                $arControl = new Control();
                $arControl->setCodigoPuestoFk($codigoPuesto);
                $arControl->setUsuarioRel($usuario);
                $arControl->setFecha(new \DateTime('now'));
                $arControl->setFechaControl($fechaControl);
                $em->persist($arControl);
                $em->flush();
                //Usuarios a los que se debe notificar
                $this->firebase->control($usuario->getTokenFirebase());
                return ['error' => false];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "La fecha control no existe"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }

    public function apiReportar($codigoUsuario, $codigoControl, $estadoRepote)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arControl = $em->getRepository(Control::class)->find($codigoControl);
            if($arControl){
                $arControl->setEstadoRepote($estadoRepote);
                $arControl->setFechaReporte(new \DateTime('now'));
                $em->persist($arControl);
                $em->flush();
                return ['error' => false];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe el control"
                ];
            }

        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }

    public function apiPendiente($codigoUsuario)
    {
        $em = $this->getEntityManager();
        $usuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($usuario) {
            $queryBuilder = $em->createQueryBuilder()->from(Control::class, 'c')
                ->select('c.codigoControlPk')
                ->addSelect('c.fecha')
                ->andWhere("c.estadoRepote = 'p'")
                ->andWhere("c.codigoUsuarioFk = {$usuario->getCodigoUsuarioPk()} ")
                ->orderBy("c.codigoControlPk", "DESC");

            $arControles = $queryBuilder->getQuery()->getResult();
            return [
                'error' => false,
                'controles' => $arControles
            ];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }
}