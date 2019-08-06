<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Repository\ReactionRepository;

class AppExtention extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('reactions', [$this, 'calculateReactions']),
        ];
    }

    public function calculateReactions(int $post_id, ReactionRepository $reactionRepository, string $legend = NUll)
    {
        if(NULL !== $legend) {
            return $reactionRepository->countPostReactionsByLegend($legend, $post_id);
        } else {
            return $reactionRepository->countPostReactionsById($post_id);
        }
    }
}
