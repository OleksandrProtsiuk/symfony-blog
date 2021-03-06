<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Reaction;
use App\Form\CommentType;
use App\Form\PostType;
use App\Form\ReactionType;
use App\Repository\PostRepository;
use App\Repository\ReactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/posts")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            foreach ($post->getTags() as $t) {
                $t->addPost($post);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($t);
                $entityManager->flush();
            }
            return $this->redirectToRoute('main_page');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="post_show", methods={"GET", "POST"})
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function show(
        $slug,
        PostRepository $postRepository,
        Request $request
    ): Response {
        $post = $postRepository->getBySlugOrId($slug);

        $comment = new Comment();
        $reaction = new Reaction();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        $reaction_form = $this->createForm(ReactionType::class, $reaction);
        $reaction_form->handleRequest($request);

        if ($reaction_form->isSubmitted() && $reaction_form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reaction);
            $entityManager->flush();
        }
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'reaction_form' => $reaction_form->createView(),
            ]);
    }

    /**
     * @Route("/{slug}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($post->getTags() as $t) {
            $entityManager->persist($t->removePost($post));
        }
        $entityManager->flush();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($post->getTags() as $t) {
                $t->addPost($post);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($t);
                $entityManager->flush();
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('main_page');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('main_page');
    }
}
