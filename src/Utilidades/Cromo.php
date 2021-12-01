<?php

namespace App\Utilidades;

use App\Entity\Operador;

class Cromo
{

    public function __construct()
    {

    }

    /**
     * @param $arOperador Operador
     * @param $parametros
     */
    public function post($arOperador, $ruta, $parametros) {
        if($arOperador->getPuntoServicioCromo()) {
            if($arOperador->getToken()) {
                $datosJson = json_encode($parametros);
                $url = $arOperador->getPuntoServicioCromo() . $ruta;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datosJson);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "X-AUTH-TOKEN: {$arOperador->getToken()}",
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($datosJson))
                );
                $respuesta = json_decode(curl_exec($ch));
                curl_close($ch);
            }
        }
    }

}