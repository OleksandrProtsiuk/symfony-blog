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

    public function calculateReactions(int $postId, ReactionRepository $reactionRepository, string $legend = null)
    {
        if (null !== $legend) {
            return $reactionRepository->countPostReactionsByLegend($legend, $postId);
        } else {
            return $reactionRepository->countPostReactionsById($postId);
        }
    }
}
