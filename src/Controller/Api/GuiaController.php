<?php


namespace App\Controller\Api;

use App\Entity\Caso;
use App\Entity\Despacho;
use App\Entity\Guia;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;

class GuiaController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/api/guia/nuevo")
     */
    public function nuevo(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $codigoUsuario = $raw['codigoUsuario']?? null;
            $codigoTercero = $raw['codigoTercero'] ?? null;
            $codigoOperacion = $raw['codigoOperacion'] ?? null;
            $codigoGuiaTipo = $raw['codigoGuiaTipo'] ?? null;
            $codigoProducto = $raw['codigoProducto'] ?? null;
            $codigoEmpaque = $raw['codigoEmpaque'] ?? null;
            $codigoServicio = $raw['codigoServicio'] ?? null;
            $remitente = $raw['remitente'] ?? null;
            $codigoCiudadDestino = $raw['codigoCiudadDestino'] ?? null;
            $nombreDestinatario = $raw['nombreDestinatario'] ?? null;
            $direccionDestinatario = $raw['direccionDestinatario'] ?? null;
            $telefonoDestinatario = $raw['telefonoDestinatario'] ?? null;
            $unidades = $raw['unidades'] ?? 0;
            $pesoReal = $raw['pesoReal'] ?? 0;
            $pesoVolumen = $raw['pesoVolumen'] ?? 0;
            $pesoFacturado = $raw['pesoFacturado'] ?? 0;
            $declarado = $raw['declarado'] ?? 0;
            $flete = $raw['flete'] ?? 0;
            $manejo = $raw['manejo'] ?? 0;
            if ($codigoUsuario) {
                if ($codigoTercero) {
                    if ($codigoOperacion) {
                        if($codigoGuiaTipo && $codigoProducto && $codigoEmpaque && $codigoServicio) {
                            if($remitente) {
                                if ($codigoCiudadDestino) {
                                    if ($nombreDestinatario && $direccionDestinatario && $telefonoDestinatario) {
                                        if ($unidades && $pesoReal && $pesoVolumen && $pesoFacturado && $declarado && $flete && $manejo) {
                                            return $em->getRepository(Guia::class)->apiNuevo($codigoUsuario, $raw);
                                        } else {
                                            return [
                                                'error' => true,
                                                'errorMensaje' => "Falta el parámetro unidades, pesoReal, pesoVolumen, pesoFacturado, declarado, flete o manejo"
                                            ];
                                        }
                                    } else {
                                        return [
                                            'error' => true,
                                            'errorMensaje' => "Falta el parámetro nombreDestinatario, direccionDestinatario o telefonoDestinatario"
                                        ];
                                    }
                                } else {
                                    return [
                                        'error' => true,
                                        'errorMensaje' => "Falta el parámetro codigoCiudadDestino"
                                    ];
                                }
                            } else {
                                return [
                                    'error' => true,
                                    'errorMensaje' => "Falta el parámetro remitente"
                                ];
                            }
                        } else {
                            return [
                                'error' => true,
                                'errorMensaje' => "Falta el parámetro guiaTipo, codigoProducto, codigoEmpaque, codigoServicio"
                            ];
                        }
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "Falta el parámetro codigoOperacion"
                        ];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "Falta el parámetro codigoTercero "
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "Falta el parámetro codigoUsuario "
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => true,
                'errorMensaje' => "Ocurrio un error en la api " . $e->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Post("/api/guia/ingreso")
     */
    public function ingreso(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoGuia = $raw['codigoGuia']?? null;
        if($codigoUsuario && $codigoGuia) {
            return $em->getRepository(Guia::class)->apiIngreso($codigoUsuario, $codigoGuia);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/guia/ingreso/detalle")
     */
    public function ingresoDetalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoGuia = $raw['codigoGuia']?? null;
        if($codigoUsuario && $codigoGuia) {
            return $em->getRepository(Guia::class)->apiIngresoDetalle($codigoUsuario, $codigoGuia);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/guia/salida")
     */
    public function salida(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoGuia = $raw['codigoGuia']?? null;
        if($codigoUsuario && $codigoGuia) {
            return $em->getRepository(Guia::class)->apiSalida($codigoUsuario, $codigoGuia);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }
    }

    /**
     * @Rest\Post("/api/guia/salida/detalle")
     */
    public function salidaDetalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoGuia = $raw['codigoGuia']?? null;
        if($codigoUsuario && $codigoGuia) {
            return $em->getRepository(Guia::class)->apiSalidaDetalle($codigoUsuario, $codigoGuia);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/guia/tercero/buscar")
     */
    public function terceroBuscar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $nombre = $raw['nombre']?? null;
        $cliente = $raw['cliente']?? null;
        if($codigoUsuario && $nombre) {
            return $em->getRepository(Guia::class)->apiTerceroBuscar($codigoUsuario, $nombre, $cliente);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

    /**
     * @Rest\Post("/api/guia/tercero/detalle")
     */
    public function terceroDetalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoUsuario = $raw['codigoUsuario']?? null;
        $codigoTercero = $raw['codigoTercero']?? null;
        if($codigoUsuario && $codigoTercero) {
            return $em->getRepository(Guia::class)->apiTerceroDetalle($codigoUsuario, $codigoTercero);
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'];
        }
    }

}