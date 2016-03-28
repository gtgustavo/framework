<?php

namespace App\Helpers\Mailer;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Mail
{
    private static function connect()
    {
        // Create the Transport

        $transport = Swift_SmtpTransport::newInstance(getenv('MAIL_HOST'), getenv('MAIL_PORT'), getenv('MAIL_ENCRYPTION'));

        $transport->setUsername(getenv('MAIL_USERNAME'));

        $transport->setPassword(getenv('MAIL_PASSWORD'));

        return $transport;
    }

    public static function send($motive, $email, $body)
    {
        $transport = self::connect();

        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);

        // Create the message
        $message = Swift_Message::newInstance();

        // Give the message a subject
        $message->setSubject($motive);

        // Set the From address with an associative array
        $message->setFrom(array('you@yourdomain.com' => getenv('MAIL_COMPANY')));

        // Set the To addresses with an associative array
        $message->setTo(array($email));

        // Give it a body
        $message->setBody($body,'text/html');

        // Send the message!
        $result = $mailer->send($message);

        return $result;
    }
}