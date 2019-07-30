<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    /*----Cut the Post Body for main page----*/
    private function truncate($string, $limit, $break = ".", $pad = "...") {
        if (strlen($string) <= $limit) return $string;
        if (false !== ($max = strpos($string, $break, $limit))) {
            if ($max < strlen($string) - 1) {
                $string = substr($string, 0, $max) . $pad;
            }
        }

        return $string;
    }

    /**
     * @Route("/", name="main_page")
     */
    public function index(PostRepository $postRepository,
                          UserRepository $userRepository): Response
    {
        $posts = $postRepository->findAll();
        foreach ($posts as $post){
            $truncated = $this->truncate($post->getBody(), 119);
            $post->setBody($truncated);
            $user_id = $post->getUserId();
            $post->username = $userRepository->findUsernameById($user_id);
        }

        return $this->render('main_page/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
