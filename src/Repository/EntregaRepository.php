<?php


namespace App\Repository;

use App\Entity\Celda;
use App\Entity\Entrega;
use App\Entity\Panal;
use App\Entity\Usuario;
use App\Utilidades\Firebase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EntregaRepository extends ServiceEntityRepository
{
    private $firebase;

    public function __construct(ManagerRegistry $registry, Firebase $firebase)
    {
        parent::__construct($registry, Entrega::class);
        $this->firebase = $firebase;
    }

    public function apiLista($codigoUsuario)
    {
        $em = $this->getEntityManager();
        $respuesta = [
            'error' => false,
            'mensajeError' => null,
            'entregasPendientes' => [],
            'entregasEntregadas' => []
        ];
        $queryBuilder = $em->createQueryBuilder()->from(Entrega::class, 'e')
            ->select('e.codigoEntregaPk')
            ->addSelect('e.fechaIngreso')
            ->addSelect('e.descripcion')
            ->addSelect('e.codigoEntregaTipoFk')
            ->leftJoin('e.celdaRel', 'c')
            ->where("c.codigoUsuarioFk = {$codigoUsuario}")
            ->andWhere("e.estadoEntregado = 0");
        $arEntregasPendientes = $queryBuilder->getQuery()->getResult();
        $queryBuilder = $em->createQueryBuilder()->from(Entrega::class, 'e')
            ->select('e.codigoEntregaPk')
            ->addSelect('e.fechaIngreso')
            ->addSelect('e.descripcion')
            ->addSelect('e.codigoEntregaTipoFk')
            ->leftJoin('e.celdaRel', 'c')
            ->where("c.codigoUsuarioFk = {$codigoUsuario}")
            ->andWhere("e.estadoEntregado = 1");
        $arEntregasEntregadas = $queryBuilder->getQuery()->getResult();
        $respuesta['entregasPendientes'] = $arEntregasPendientes;
        $respuesta['entregasEntregadas'] = $arEntregasEntregadas;
        return $respuesta;
    }

    public function apiNuevo($codigoPanal, $celda, $tipo)
    {
        $em = $this->getEntityManager();
        $arPanal = $em->getRepository(Panal::class)->find($codigoPanal);
        if($arPanal) {
            $arCelda = $em->getRepository(Celda::class)->findOneBy(['codigoPanalFk' => $codigoPanal, 'celda' => $celda]);
            if($arCelda) {
                $arEntrega = new Entrega();
                $arEntrega->setCeldaRel($arCelda);
                $arEntrega->setFechaIngreso(new \DateTime('now'));
                $arEntrega->setCodigoEntregaTipoFk($tipo);
                $em->persist($arEntrega);
                $em->flush();
                //Usuarios a los que se debe notificar
                $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['codigoCeldaFk' => $arCelda->getCodigoCeldaPk()]);
                if($arUsuario) {
                    $this->firebase->nuevaEntrega($arUsuario->getTokenFirebase(), $arEntrega->getCodigoEntregaPk());
                }
                return ['error' => false];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe la celda"
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