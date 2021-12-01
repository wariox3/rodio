<?php


namespace App\Repository;

use App\Entity\Archivo;
use App\Entity\Efecto;
use App\Entity\Evento;
use App\Entity\EventoTipo;
use App\Entity\Operador;
use App\Entity\Usuario;
use App\Utilidades\Cromo;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventoRepository extends ServiceEntityRepository
{
    private $space;
    private $cromo;

    public function __construct(ManagerRegistry $registry, SpaceDO $space, Cromo $cromo)
    {
        parent::__construct($registry, Evento::class);
        $this->space = $space;
        $this->cromo = $cromo;
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

    public function apiNuevo($operador, $codigoTipo, $codigoEfecto, $codigoUsuario, $codigoPuesto, $comentario, $arrArchivos)
    {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arOperador = $em->getRepository(Operador::class)->find($operador);
            if($arOperador) {
                $arEventoTipo = $em->getRepository(EventoTipo::class)->find($codigoTipo);
                if($arEventoTipo) {
                    $arEfecto = $em->getRepository(Efecto::class)->find($codigoEfecto);
                    if($arEfecto) {
                        $arEvento = new Evento();
                        $arEvento->setFecha(new \DateTime('now'));
                        $arEvento->setCodigoPuestoFk($codigoPuesto);
                        $arEvento->setComentario($comentario);
                        $arEvento->setOperadorRel($arOperador);
                        $arEvento->setEventoTipoRel($arEventoTipo);
                        $arEvento->setEfectoRel($arEfecto);
                        $em->persist($arEvento);
                        $em->flush();
                        if($arrArchivos) {
                            foreach ($arrArchivos as $arrArchivo) {
                                $arArchivo = new Archivo();
                                $arArchivo->setCodigoArchivoTipoFk($arrArchivo['tipo']);
                                $arArchivo->setCodigoModeloFk('Evento');
                                $arArchivo->setCodigo($arEvento->getCodigoEventoPk());
                                $arArchivo->setNombre($arrArchivo['nombre']);
                                $arArchivo->setRuta($this->space->subir("evento/{$arrArchivo['tipo']}", $arrArchivo['nombre'], $arrArchivo['base64']));
                                $em->persist($arArchivo);
                            }
                        }
                        $em->flush();
                        if($arOperador->isSincronizar()) {
                            $arrPuesto = explode("_", $codigoPuesto);
                            $arr = [
                                "efecto" => $codigoEfecto,
                                "puesto" => $arrPuesto[1],
                                "tipo" => $codigoTipo,
                            ];
                            $this->cromo->post($arOperador, '/api/turno/evento/nuevo', $arr);
                        }
                        return [
                            'error' => false,
                            'codigoEvento' => $arEvento->getCodigoEventoPk()
                        ];
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "No existe el efecto"
                        ];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "No existe el tipo"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe el operador"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No existe el usuario"
            ];
        }
    }

    public function sincronizar() {

    }

}