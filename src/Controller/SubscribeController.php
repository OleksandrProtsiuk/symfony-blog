<?php

namespace App\Controller;


use App\Entity\Subscribe;
use App\Form\SubscribeType;
use App\Service\SendMail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SubscribeController extends AbstractController
{
    /**
     * @Route("/subscribe/create", name="subscribe_create")
     */
    public function index(Request $request): Response
    {
        $subscribe = new Subscribe();
        $form = $this->createForm(SubscribeType::class, $subscribe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subscribe);
            $entityManager->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('subscribe/index.html.twig', [
            'subscribe_form' => $form->createView(),
        ]);
    }

    /**
     *  @Route("/subscribe", name="subscribe")
     */
    public function new()
    {
        $subscribe = new Subscribe();
        $form = $this->createForm(SubscribeType::class, $subscribe);

        return $this->render('subscribe/_form.html.twig', [
            'subscribe_form' => $form->createView(),
        ]);
    }

}
