<?php

namespace App\Utilidades;

class Firebase
{

    public function __construct()
    {

    }

    public function nuevaVisita($destinatario, $codigoVisita) {
        $url = "https://fcm.googleapis.com/fcm/send";
        $arreglo = [
            'to' => $destinatario,
            'notification' => [
                'title' => "visita",
                'body' => "notificacion"
            ],
            'data' => [
                'codigoVisita' => $codigoVisita
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
            $error =  'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }

    public function nuevaEntrega($destinatario, $codigoEntrega) {
        $url = "https://fcm.googleapis.com/fcm/send";
        $arreglo = [
            'to' => $destinatario,
            'notification' => [
                'title' => "entrega",
                'body' => "notificacion"
            ],
            'data' => [
                'codigoEntrega' => $codigoEntrega
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
            $error =  'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }
}