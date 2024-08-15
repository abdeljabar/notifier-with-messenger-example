<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    #[Route("/send-email-notification", name: "send_email_notification")]
    public function sendEmailNotification(NotifierInterface $notifier): JsonResponse
    {
        $emailMessage = new EmailMessage('Notification Subject', 'This is the content of the email notification.');
        $recipient = new Recipient('user@example.com');
        $notifier->send($emailMessage, $recipient);

        return $this->json(['status' => 'Email notification sent']);
    }

    #[Route("/send-chat-notification", name:"send_chat_notification")]
    public function sendChatNotification(NotifierInterface $notifier): JsonResponse
    {
        $chatMessage = new ChatMessage('This is the content of the chat notification.');
        $notifier->send($chatMessage);

        return $this->json(['status' => 'Chat notification sent']);
    }

    #[Route("/send-sms-notification", name: "send_sms_notification")]
    public function sendSmsNotification(NotifierInterface $notifier): JsonResponse
    {
        $smsMessage = new SmsMessage('+212669904766', 'This is the content of the SMS notification.');
        $notifier->send($smsMessage);

        return $this->json(['status' => 'SMS notification sent']);
    }
}
