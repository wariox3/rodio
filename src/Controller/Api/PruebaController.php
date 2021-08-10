<?php


namespace App\Controller\Api;

use App\Entity\Comentario;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class PruebaController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/prueba")
     */
    public function prueba(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $url = "https://fcm.googleapis.com/fcm/send";
        $arreglo = [
            'to' => "evcEy0heS22idgjHWWSx7u:APA91bGei2GpcrSLzxPPaZQ7hwL4lapu4fMMN29LG7FF_YbEmgr7Kw2b80Kmd3T86vumON4WrqrdXi9E2D_LQ-HEM7KKbPR_QfXBPCxLw_1HwPGl6m5BGQ_hE1CMHC-9bH71mbEtTJQa",
            'notification' => [
                'title' => "visita",
                'body' => "Notificacion"
            ],
            'data' => [
                'codigoVisita' => 4
            ]
        ];
        $parametros = json_encode($arreglo);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);

        $headers = array();
        $headers[] = 'Authorization: key = ' . $_ENV['GM_CLAVE'];
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return ['prueba' => true];
    }
}