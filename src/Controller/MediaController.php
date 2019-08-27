<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use App\Service\Uploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/medias")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class MediaController extends AbstractController
{
    /**
     * @Route("/", name="media_index", methods={"GET"})
     */
    public function index(MediaRepository $mediaRepository): Response
    {
        $this->denyAccessUnlessGranted( ['ROLE_ADMIN',]);
        return $this->render('media/index.html.twig', [
            'media' => $mediaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="media_new", methods={"GET","POST"})
     */
    public function new(Request $request, Uploader $uploader): Response
    {
        $medium = new Media();
        /** @var \App\Entity\User $user */
        $medium->setUser($this->getUser());
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileName = $uploader->upload($medium->getFile());

            $entityManager = $this->getDoctrine()->getManager();
            $medium->setFileName($fileName);
            $entityManager->persist($medium);
            $entityManager->flush();

            return $this->render('media/new.html.twig', [
                'medium' => $medium,
                'form' => $form->createView(),
                'notice' => 'Success',
            ]);
        }

        return $this->render('media/new.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="media_show", methods={"GET"})
     */
    public function show(Media $medium): Response
    {
        return $this->render('media/show.html.twig', [
            'medium' => $medium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="media_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Media $medium, Uploader $uploader): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);
        $id = $medium->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $fileName = $uploader->upload($medium->getFile());

            $entityManager = $this->getDoctrine()->getManager();
            $medium->setFileName($fileName);
            $entityManager->persist($medium);
            $entityManager->flush();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show', ['id' => $id]);
        }

        return $this->render('media/edit.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="media_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Media $medium): Response
    {
        $id = $medium->getUser();
        if ($this->isCsrfTokenValid('delete'.$medium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_show', ['id' => $id]);
    }
}
