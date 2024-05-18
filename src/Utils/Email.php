<?php

namespace App\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class Email
 *
 * Utility class for sending emails using PHPMailer.
 */
class Email
{
    /**
     * Sends an email.
     *
     * @param string $to      Recipient email address.
     * @param string $subject Subject of the email.
     * @param string $body    Body content of the email.
     *
     * @return bool Returns true if the email was sent successfully, false otherwise.
     */
    public function send($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['SMTP_PORT'];

            // Recipients
            $mail->setFrom($_ENV['SMTP_FROM'], 'Support');
            $mail->addAddress($to);

            // Content
            $mail->Subject = $subject;
            $mail->Body = $body;

            // Send email
            return $mail->send();
        } catch (Exception $e) {
            // Log error message or handle it as needed
            // error_log($mail->ErrorInfo);
            return false;
        }
    }
}
