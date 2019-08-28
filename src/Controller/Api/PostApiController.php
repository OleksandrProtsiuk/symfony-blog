<?php

namespace App\Controller\Api;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api")
 */
class PostApiController extends AbstractController
{

    /**
     * @Rest\Get("/posts", name="api_posts")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function posts(Request $request, PostRepository $repository)
    {
        return $this->json($repository->getBySlugOrId($request->get('id')));
    }

    /**
     * @Rest\Post("/post/new", name="api_post_new")
     * @param Request $request
     */
    public function create(Request $request, UserRepository $userRepository)
    {
        $data = json_decode($request->getContent(), true);

        $post = new Post();
        $post->setUser($userRepository->find($data['user']));

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        $form->submit($data);
        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->json(['Ok'], 200);
        }
        return $this->json([
            'errors' => $form->getErrors($form),
        ], 400);
    }
}
