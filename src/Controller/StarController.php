<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StarController extends AbstractController
{
    /**
     * @Route("/star", name="star")
     */
    public function index()
    {
        return $this->render('star/index.html.twig', [
            'controller_name' => 'StarController',
        ]);
    }
}
