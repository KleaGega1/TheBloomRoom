<?php

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    /**
     * @var PHPMailer
     */
    private $mailer;
    
    public function __construct($exceptions = true)
    {
        $this->mailer = new PHPMailer($exceptions);
        $this->setupMailer();
    }
    
    private function setupMailer()
    {
        $this->mailer->isSMTP();
        
        $this->mailer->Host = $_ENV['MAIL_HOST'] ?? 'smtp.example.com';
        $this->mailer->SMTPAuth = $_ENV['MAIL_AUTH'] ?? true;
        $this->mailer->Username = $_ENV['MAIL_USERNAME'] ?? '';
        $this->mailer->Password = $_ENV['MAIL_PASSWORD'] ?? '';
        $this->mailer->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = $_ENV['MAIL_PORT'] ?? 587;
        
        $fromEmail = $_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@example.com';
        $fromName = $_ENV['MAIL_FROM_NAME'] ?? 'Your Application';
        $this->mailer->setFrom($fromEmail, $fromName);
        
        $this->mailer->CharSet = PHPMailer::CHARSET_UTF8;
    }
    
    public function send($to, $subject, $body, $isHtml = true)
    {
        $this->mailer->clearAllRecipients();
        $this->mailer->clearAttachments();
        
        $this->mailer->Subject = $subject;
        
        $this->mailer->Body = $body;
        $this->mailer->isHTML($isHtml);
        
        // Add recipients
        if (is_array($to)) {
            foreach ($to as $email => $name) {
                if (is_numeric($email)) {
                    $this->mailer->addAddress($name);
                } else {
                    $this->mailer->addAddress($email, $name);
                }
            }
        } else {
            $this->mailer->addAddress($to);
        }
        
        // Send email
        return $this->mailer->send();
    }
    
    public function sendHtml($to, $subject, $htmlBody, $plainTextBody = '')
    {
        $this->mailer->clearAllRecipients();
        $this->mailer->clearAttachments();
        
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $htmlBody;
        $this->mailer->isHTML(true);
        
        if (!empty($plainTextBody)) {
            $this->mailer->AltBody = $plainTextBody;
        } else {
            $this->mailer->AltBody = strip_tags($htmlBody);
        }
        
        if (is_array($to)) {
            foreach ($to as $email => $name) {
                if (is_numeric($email)) {
                    $this->mailer->addAddress($name);
                } else {
                    $this->mailer->addAddress($email, $name);
                }
            }
        } else {
            $this->mailer->addAddress($to);
        }
        
        return $this->mailer->send();
    }
    
    public function sendTemplate($to, $subject, $template, $data = [])
    {
        extract($data);
        ob_start();
        
        if (file_exists($template)) {
            include $template;
        } else {
            throw new Exception("Email template not found: {$template}");
        }
        
        $htmlBody = ob_get_clean();
        
        return $this->sendHtml($to, $subject, $htmlBody, '');
    }
    
    public function setSMTP($host, $port, $username, $password, $encryption = PHPMailer::ENCRYPTION_STARTTLS, $auth = true)
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = $host;
        $this->mailer->Port = $port;
        $this->mailer->SMTPAuth = $auth;
        $this->mailer->Username = $username;
        $this->mailer->Password = $password;
        $this->mailer->SMTPSecure = $encryption;
        
        return $this;
    }
    
    public function setFrom($email, $name = '')
    {
        $this->mailer->setFrom($email, $name);
        return $this;
    }
    
    public function setReplyTo($email, $name = '')
    {
        $this->mailer->addReplyTo($email, $name);
        return $this;
    }
    
    public function getMailer()
    {
        return $this->mailer;
    }
    
    public function setDebug($level = SMTP::DEBUG_SERVER)
    {
        $this->mailer->SMTPDebug = $level;
        return $this;
    }
}