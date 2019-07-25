<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StarConrollerController extends AbstractController
{
    /**
     * @Route("/star/conroller", name="star_conroller")
     */
    public function index()
    {
        return $this->render('star_conroller/index.html.twig', [
            'controller_name' => 'StarConrollerController',
        ]);
    }
}
