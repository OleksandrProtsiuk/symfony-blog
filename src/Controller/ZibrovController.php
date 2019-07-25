<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ZibrovController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $title = 'main';
        return $this->render('main.html.twig', ['title' => $title]);
    }

    /**
     * @Route("/zibrov")
     */
    public function pasha()
    {
        $greet = 'Hello, Хеллоу!.. I am Pavlo Zibrov!';

        return $this->render('zibrov.html.twig', ['greet' => $greet]);
    }
}
