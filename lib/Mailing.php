<?php 

namespace App;

use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Mailing
 * Manage email sending with Swiftmailer library
 */
trait Mailing
{        
    /**
     * sendEmail
     *
     * @param  string $name     Sender name
     * @param  string $email    Sender email address
     * @param  string $subject  Subject
     * @param  string $body     Message content
     * @param  array $recipient Array (recipient's email address => name). If empty use the configured superadmin in .env file)
     * @return bool True in case of success, False else
     */
    public function sendEmail(string $name, string $email, string $subject, string $body, array $recipient = []): bool
    {
        // Use .env files to create $_ENV superglobal var
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../.env', __DIR__.'/../.env.local');
        $envInput = filter_var_array($_ENV, FILTER_SANITIZE_STRING);

        if (empty($recipient)) $recipient = array($envInput['ADMIN_EMAIL'] => $envInput['ADMIN_NAME']);
        
        // Create the Transport
        $transport = (new Swift_SmtpTransport($envInput['SMTP_HOST'], 587, 'tls'))
            ->setUsername($envInput['SMTP_USERNAME'])
            ->setPassword($envInput['SMTP_PASSWORD'])
        ;

        // Create the Mailer using the created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message($subject))
            ->setFrom([$envInput['SMTP_USERNAME'] => $name])
            ->setTo($recipient) 
            ->setReplyTo($email)
            ->setBody($body)
        ;

        return $mailer->send($message);
    }

}