<?php

namespace App\Twig;

use App\Repository\PostRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Repository\ReactionRepository;

class AppExtention extends AbstractExtension
{
    private $postRepository;
    private $reactionRepository;

    public function __construct(PostRepository $repository, ReactionRepository $reactionRepository)
    {
        $this->postRepository = $repository;
        $this->reactionRepository = $reactionRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('reactions', [$this, 'calculateReactions']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('rate', [$this, 'ratePostByPositiveReactions']),
        ];
    }

    public function calculateReactions(int $postId, ReactionRepository $reactionRepository, string $legend = null)
    {
        if (null !== $legend) {
            return $reactionRepository->countPostReactionsByLegend($legend, $postId);
        } else {
            return $reactionRepository->countPostReactionsById($postId);
        }
    }

    public function ratePostByPositiveReactions($posts)
    {
        $result = [];
        $res = [];
        foreach ($posts as $p) {
            $res[$p->getId()] =
                $this->reactionRepository->countPostReactionsByLegend('good', $p->getId()) +
                $this->reactionRepository->countPostReactionsByLegend('very good', $p->getId());
        }
        arsort($res);
        array_reverse($res);

        foreach (array_keys($res) as $r) {
            array_push($result, $this->postRepository->find($r));
        }
        return $result;
    }
}
