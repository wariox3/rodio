<?php

namespace App\Repository;

use App\Entity\Caso;
use App\Entity\CasoTipo;
use App\Entity\Chat;
use App\Entity\Oferta;
use App\Entity\Usuario;
use App\Utilidades\Firebase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ChatRepository  extends ServiceEntityRepository
{
    private $firebase;

    public function __construct(ManagerRegistry $registry, Firebase $firebase)
    {
        parent::__construct($registry, Chat::class);
        $this->firebase = $firebase;
    }

    public function apiNuevo($codigoUsuario, $codigoOferta) {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario) {
            $arOferta = $em->getRepository(Oferta::class)->find($codigoOferta);
            if($arOferta) {
                if($arOferta->getCodigoOfertaPk() != $codigoUsuario) {
                    $queryBuilder = $em->createQueryBuilder()->from(Chat::class, 'c')
                        ->select('c.codigoChatPk')
                        ->where("c.codigoOfertaFk = {$codigoOferta}")
                        ->andWhere("c.codigoUsuarioEmisorFk = {$codigoUsuario}");
                    $arChats = $queryBuilder->getQuery()->getOneOrNullResult();
                    if($arChats) {
                        return [
                            'error' => false,
                            'nuevo' => false,
                            'codigoChat' => $arChats['codigoChatPk']
                        ];
                    } else {
                        $arChat = new Chat();
                        $arChat->setUsuarioEmisorRel($arUsuario);
                        $arChat->setOfertaRel($arOferta);
                        $arChat->setFecha(new \DateTime('now'));
                        $em->persist($arChat);
                        $em->flush();
                        return [
                            'error' => false,
                            'nuevo' => true,
                            'codigoChat' => $arChat->getCodigoChatPk()
                        ];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "El mismo usuario no se puede contactar"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "La oferta no existe"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "El usuario no existe"
            ];
        }

    }

    public function apiLista($codigoUsuario) {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Chat::class, 'c')
            ->select('c.codigoChatPk')
            ->addSelect('c.codigoUsuarioFk')
            ->addSelect('o.codigoUsuarioFk as ofertaCodigoUsuarioFk')
            ->leftJoin('c.ofertaRel', 'o')
            ->andWhere("c.codigoUsuarioFk = {$codigoUsuario} or o.codigoUsuarioFk = {$codigoUsuario}");
        $arChats = $queryBuilder->getQuery()->getResult();
        return [
            'error' => false,
            'chats' => $arChats
        ];

    }
}