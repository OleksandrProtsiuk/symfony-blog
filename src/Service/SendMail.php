<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SendMail extends AbstractController
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer){

        $this->mailer = $mailer;

    }

    public function registration($name)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('pavlo@zibrov.com')
            ->setTo('')
            ->setBody(
                $this->renderView(
                    'emails/registration.html.twig',
                    ['name' => $name]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
