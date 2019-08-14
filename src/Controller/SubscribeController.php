<?php

namespace App\Controller;


use App\Entity\DTO\Subscribe;
use App\Form\SubscribeType;
use App\Service\SendMail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SubscribeController extends AbstractController
{
    /**
     * @Route("/subscribe", name="subscribe")
     */
    public function index(Request $request, SendMail $sendMail): Response
    {
        $subscribe = new Subscribe();
        $form = $this->createForm(SubscribeType::class, $subscribe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sendMail->newsletter($subscribe);
        }
        return $this->render('subscribe/_form.html.twig', [
            'subscribe_form' => $form->createView(),
        ]);
    }
}
