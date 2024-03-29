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
        if($arOperador) {
            if($arOperador->getPuntoServicioCromo()) {
                if($arOperador->getUsuarioServicio() && $arOperador->getClaveServicio()) {
                    $datosJson = json_encode($parametros);
                    $url = $arOperador->getPuntoServicioCromo() . $ruta;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $datosJson);
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_USERPWD, "{$arOperador->getUsuarioServicio()}:{$arOperador->getClaveServicio()}");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($datosJson))
                    );
                    $respuesta = json_decode(curl_exec($ch), true);
                    curl_close($ch);
                    if($respuesta) {
                        return $respuesta;
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "El punto de servicio no respondio"
                        ];
                    }
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "El operador no tiene punto de servicio"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "No se especifico un operador en la api"
            ];
        }
    }

}