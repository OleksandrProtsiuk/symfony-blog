<?php

namespace App\Controller;

use App\Entity\DTO\Search;
use App\Form\SearchPostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search_form")
     */
    public function index(): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchPostType::class, $search);
        return $this->render('search/_form.html.twig', [
            'search_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search/results", name="search")
     */
    public function search(
        PostRepository $postRepository,
        Request $request
    ): Response {
        $search = new Search();
        $form = $this->createForm(SearchPostType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('search/result.html.twig', [
                'results' => $postRepository->search($search),
            ]);
        } else {
            return $this->render('search/result.html.twig', [
                'errors' => $form->getErrors($form),
            ]);
        }
    }
}
