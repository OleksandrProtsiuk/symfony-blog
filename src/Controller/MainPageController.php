<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class MainPageController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index(PostRepository $postRepository): Response {
        $adapter = new DoctrineORMAdapter($postRepository->pagination());

        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(1);
        if (isset($_GET['page'])) {
            $pager->setCurrentPage($_GET['page']);
        }

        return $this->render('main_page/index.html.twig', [
            'pager' => $pager,
        ]);
    }
}
