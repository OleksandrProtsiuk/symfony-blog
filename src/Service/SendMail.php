<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SendMail extends AbstractController
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer){

        $this->mailer = $mailer;

    }

    public function registration($user) // will be used for email-confirm of registration of new user
    {
        $message = (new \Swift_Message('Z-Blog'))
            ->setFrom('pavlo@zibrov.com')
            ->setTo($user->getMail())
            ->setBody(
                $this->renderView(
                    'emails/registration.html.twig', [
                        'name' => $user->getName(),
                ]),
                'text/html'
            );

        $this->mailer->send($message);
    }

    public function newsletter($subscribe)
    {
        $message = (new \Swift_Message('Z-Blog'))
            ->setFrom('pavlo@zibrov.com')
            ->setTo($subscribe->email)
            ->setBody(
                $this->renderView(
                    'emails/newsletter.html.twig'
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
