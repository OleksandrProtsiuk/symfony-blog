<?php

namespace App\Controller;

use App\Entity\DTO\Search;
use App\Form\SearchPostType;
use App\Repository\CommentRepository;
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
        CommentRepository $commentRepository,
        Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchPostType::class, $search);
        $form->handleRequest($request);
        $result = [];
       foreach($postRepository->search($search->title) as $post) {
            array_push($result, $post );
        }
       if(true === $search->comment){
           foreach ($commentRepository->search($search->title) as $comment) {
               array_push($result, $comment->getPost() );
           }
       }

        return $this->render('search/result.html.twig', ['results' => $result]);
    }
}
