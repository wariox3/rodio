<?php

namespace App\Utilidades;

class SpaceDO
{

    public function __construct()
    {

    }

    public function subir($clase, $nombre, $textoBase64) {
        $nombreArchivo = rand(100000, 999999) . "_" . $nombre;
        $destinoLocal = "/var/www/html/temporal/{$nombreArchivo}";
        $destinoDO = "rodio/$clase/{$nombreArchivo}";
        $datosBase64 = explode(',', $textoBase64);
        $base64 = $datosBase64[0];
        if(isset($datosBase64[1])) {
            $base64 = $datosBase64[1];
        }
        $base64 = base64_decode($base64);
        file_put_contents($destinoLocal, $base64);
        $spaces = Spaces($_ENV['DO_CLAVE_ACCESO'], $_ENV['DO_CLAVE_SECRETA']);
        $my_space = $spaces->space("semantica", "sfo3");
        $my_space->uploadFile($destinoLocal, $destinoDO, "public");
        unlink($destinoLocal);
        return [
            'url' => "{$destinoDO}"
        ];
    }

    public function eliminar($url) {
        $spaces = Spaces($_ENV['DO_CLAVE_ACCESO'], $_ENV['DO_CLAVE_SECRETA']);
        $my_space = $spaces->space("semantica", "sfo3");
        $my_space->deleteFile($url);
        return true;
    }
}