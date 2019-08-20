<?php

namespace App\Service;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SendMail extends AbstractController
{
    private $mailer;
    private $postRepository;

    public function __construct(\Swift_Mailer $mailer, PostRepository $postRepository)
    {
        $this->mailer = $mailer;
        $this->postRepository = $postRepository;
    }
    
    public function newsletter($email, $greet = null)
    {
        if ($greet) {
            $view = 'emails/greet_newsletter.html.twig';
        } else {
            $view = 'emails/newsletter.html.twig';
        }
        $message = (new \Swift_Message('Z-Blog News'))
            ->setFrom('pavlo@zibrov.com')
            ->setTo($email)
            ->setBody(
                $this->renderView($view,[
                    'posts' => $this->postRepository->newsletter(),
            ]),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
