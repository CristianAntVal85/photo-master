<?php

namespace dwes\app\controllers;

use dwes\app\exceptions\MailException;
use dwes\app\utils\MyMail;
use dwes\core\Response;

class ContactoController
{
    /**
     * Muestra el formulario de contacto con layout-with-footer
     *
     * @return void
     */
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE && session_start() === false) {
            throw new \RuntimeException('No se pudo iniciar la sesión del formulario.');
        }

        $errores = [];
        $mensaje = '';
        $captchaImageToken = bin2hex(random_bytes(8));

        if (session_status() === PHP_SESSION_ACTIVE && session_write_close() === false) {
            throw new \RuntimeException('No se pudo guardar la sesión del formulario.');
        }

        Response::renderView(
            'contact',
            'layout-with-footer',
            compact('errores', 'mensaje', 'captchaImageToken')
        );
    }

    /**
     * Procesa el envío del correo de contacto
     *
     * @return void
     */
    public function enviar()
    {
        $errores = [];
        $mensaje = '';
        $captchaImageToken = bin2hex(random_bytes(8));

        if (session_status() === PHP_SESSION_NONE && session_start() === false) {
            throw new \RuntimeException('No se pudo iniciar la sesión del formulario.');
        }

        $captchaRecibido = $_POST['captcha'] ?? '';
        if (
            !is_string($captchaRecibido)
            || trim($captchaRecibido) === ''
            || !isset($_SESSION['captchaGenerado'])
            || !is_string($_SESSION['captchaGenerado'])
            || !hash_equals($_SESSION['captchaGenerado'], trim($captchaRecibido))
        ) {
            $errores[] = 'El código de seguridad es incorrecto. Inténtelo de nuevo.';
        }
        unset($_SESSION['captchaGenerado']);

        if (session_status() === PHP_SESSION_ACTIVE && session_write_close() === false) {
            throw new \RuntimeException('No se pudo guardar la sesión del formulario.');
        }

        $campos = [];
        foreach (['nombre', 'apellidos', 'email', 'asunto', 'mensaje'] as $campo) {
            $valor = $_POST[$campo] ?? '';
            $campos[$campo] = is_string($valor) ? trim($valor) : '';
        }

        if ($campos['nombre'] === '' || $campos['email'] === '' || $campos['asunto'] === '') {
            $errores[] = 'Faltan campos por rellenar: Nombre, Email y Asunto.';
        } elseif (!filter_var($campos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'La dirección de correo indicada no es válida.';
        }

        if ($errores === []) {
            try {
                $mail = new MyMail();
                $mail->send(
                    $campos['email'],
                    trim($campos['nombre'] . ' ' . $campos['apellidos']),
                    $campos['asunto'],
                    $campos['mensaje']
                );
                $mensaje = 'Mensaje enviado correctamente.';
            } catch (MailException $mailException) {
                $mensaje = $mailException->getMessage();
                $errores[] = $mensaje;
            }
        }

        Response::renderView(
            'contact',
            'layout-with-footer',
            compact('errores', 'mensaje', 'captchaImageToken')
        );
    }
}
