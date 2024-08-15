<?php

// src/MessageHandler/NotificationHandler.php

namespace App\MessageHandler;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Message\SmsMessage;

class NotificationHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $message
     * @return void
     */
    public function __invoke($message): void
    {
        $subject = '';
        $content = '';

        if ($message instanceof ChatMessage) {
            $subject = $message->getSubject();
            $content = $message->getNotification()->getContent();
        } elseif ($message instanceof EmailMessage) {
            $subject = $message->getSubject();
            $content = $message->getHtmlBody() ?: $message->getTextBody();
        } elseif ($message instanceof SmsMessage) {
            $subject = $message->getSubject();
            $content = $message->getSms()->getContent();
        }

        $notification = new Notification($subject, $content);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }
}
