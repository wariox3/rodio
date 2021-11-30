<?php

namespace App\Repository;

use App\Entity\CeldaUsuario;
use App\Entity\Control;
use App\Entity\Operador;
use App\Entity\Usuario;
use App\Utilidades\Firebase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ControlRepository extends ServiceEntityRepository
{
    private $firebase;


    public function __construct(ManagerRegistry $registry, Firebase $firebase)
    {
        parent::__construct($registry, Control::class);
        $this->firebase = $firebase;
    }

    public function apiNuevo($operador, $arrPuestos, $fechaControl)
    {
        $em = $this->getEntityManager();
        $arOperador = $em->getRepository(Operador::class)->find($operador);
        if ($arOperador) {
            $fechaControl = date_create($fechaControl);
            foreach ($arrPuestos as $arPuesto) {
                $arControl = new Control();
                $arControl->setCodigoPuestoFk($arPuesto['codigoPuestoFk']);
                $arControl->setFecha(new \DateTime('now'));
                $arControl->setFechaControl($fechaControl);
                $arControl->setOperadorRel($arOperador);
                $em->persist($arControl);
                //Usuarios a los que se debe notificar

                $arUsuarios = $em->getRepository(Usuario::class)->findBy(['codigoOperadorFk' => $operador, 'codigoPuestoFk' => $arPuesto['codigoPuestoFk']]);
                foreach ($arUsuarios as $arUsuario) {
                    $this->firebase->control($arUsuario->getTokenFirebase());
                }
            }
            $em->flush();
            return ['error' => false];
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El operador no existe"
            ];
        }
    }

    public function apiReportar($codigoUsuario, $codigoControl, $estadoRepote)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if ($arUsuario) {
            $arControl = $em->getRepository(Control::class)->find($codigoControl);
            if ($arControl) {
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
        if ($usuario) {
            if($usuario->getCodigoPuestoFk()){
                $queryBuilder = $em->createQueryBuilder()->from(Control::class, 'c')
                    ->select('c.codigoControlPk')
                    ->addSelect('c.fecha')
                    ->andWhere("c.estadoRepote = 'p'")
                    ->andWhere("c.codigoOperadorFk = {$usuario->getCodigoOperadorFk()} ")
                    ->andWhere("c.codigoPuestoFk = {$usuario->getCodigoPuestoFk()} ")
                    ->orderBy("c.codigoControlPk", "DESC");

                $arControles = $queryBuilder->getQuery()->getResult();
                return [
                    'error' => false,
                    'controles' => $arControles
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