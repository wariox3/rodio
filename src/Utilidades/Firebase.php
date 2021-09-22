<?php

namespace App\Utilidades;

class Firebase
{

    public function __construct()
    {

    }

    public function nuevaVisita($destinatario, $codigoVisita, $visitante) {
        $url = "https://fcm.googleapis.com/fcm/send";
        $arreglo = [
            'to' => $destinatario,
            'notification' => [
                'title' => "Tienes una nueva visita",
                'body' => "Te visita {$visitante} debes autorizar su ingreso"
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

    public function nuevaEntrega($destinatario, $codigoEntrega, $tipoEntrega) {
        $url = "https://fcm.googleapis.com/fcm/send";
        $arreglo = [
            'to' => $destinatario,
            'notification' => [
                'title' => "Tienes una nueva entrega",
                'body' => "En hora buena le ha llegado un {$tipoEntrega} paquete debes autorizar el recibido"
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