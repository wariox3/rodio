<?php

namespace App\Utilidades;

class SpaceDO
{

    public function __construct()
    {

    }

    public function subir($clase, $textoBase64) {
        //https://github.com/SociallyDev/Spaces-API
        $nombreArchivo = bin2hex(random_bytes((30 - (20 % 2)) / 2));;
        $datosBase64 = explode(',', $textoBase64);
        $data = $datosBase64[0];
        $extension = substr($data, 11, -7);
        $base64 = $datosBase64[1];
        $destinoLocal = "/var/www/html/temporal/{$nombreArchivo}.{$extension}";
        $destinoDO = "rodio/$clase/{$nombreArchivo}.{$extension}";
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