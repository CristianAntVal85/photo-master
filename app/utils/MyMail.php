<?php

namespace dwes\app\utils;

use dwes\app\exceptions\MailException;
use dwes\core\App;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;

class MyMail
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public function send($mailFrom, $nombre, $asunto, $texto): void
    {
        $config = App::get('config')['mailer'];
        foreach (['smtp_server', 'smtp_port', 'smtp_security', 'username', 'password', 'email', 'name'] as $key) {
            if (!isset($config[$key]) || $config[$key] === '') {
                throw new MailException("Falta configurar el parámetro de correo: $key.");
            }
        }

        if (
            !filter_var($mailFrom, FILTER_VALIDATE_EMAIL)
            || !filter_var($config['email'], FILTER_VALIDATE_EMAIL)
        ) {
            throw new MailException('La dirección de correo indicada no es válida.');
        }

        if (!is_numeric($config['smtp_port']) || (int) $config['smtp_port'] < 1 || (int) $config['smtp_port'] > 65535) {
            throw new MailException('El puerto SMTP configurado no es válido.');
        }

        if (!in_array($config['smtp_security'], ['tls', 'ssl'], true)) {
            throw new MailException('La seguridad SMTP debe ser tls o ssl.');
        }

        try {
            $this->mail->isSMTP();
            $this->mail->SMTPDebug = 0;
            $this->mail->Host = $config['smtp_server'];
            $this->mail->SMTPAuth = true;
            $this->mail->Port = (int) $config['smtp_port'];
            $this->mail->Username = $config['username'];
            $this->mail->Password = $config['password'];
            $this->mail->CharSet = PHPMailer::CHARSET_UTF8;
            $this->mail->isHTML(false);
            $this->mail->SMTPSecure = $config['smtp_security'] === 'tls'
                ? PHPMailer::ENCRYPTION_STARTTLS
                : PHPMailer::ENCRYPTION_SMTPS;
            $this->mail->setFrom($config['email'], $config['name']);
            $this->mail->addAddress($config['email'], $config['name']);
            $this->mail->addReplyTo($mailFrom, $nombre);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $texto;
            $this->mail->send();
        } catch (PHPMailerException $exception) {
            throw new MailException('No se ha podido enviar el mensaje.', 0, $exception);
        }
    }
}
