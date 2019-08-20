<?php

namespace App\Twig;

use App\Entity\Post;
use App\Entity\Reaction;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtention extends AbstractExtension
{
    private $repository;

    public function __construct(RegistryInterface $registry)
    {
        $this->repository = $registry;
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

    public function calculateReactions(int $postId, string $legend = null)
    {
        $reaction = $this->repository->getRepository(Reaction::class);
        if (null !== $legend) {
            return $reaction->countPostReactionsByLegend($legend, $postId);
        } else {
            return $reaction->countPostReactionsById($postId);
        }
    }

    public function ratePostByPositiveReactions($posts)
    {
        $reaction = $this->repository->getRepository(Reaction::class);
        $result = [];
        $res = [];
        foreach ($posts as $p) {
            $res[$p->getId()] =
                $reaction->countPostReactionsByLegend('good', $p->getId()) +
                $reaction->countPostReactionsByLegend('very good', $p->getId());
        }
        arsort($res);
        array_reverse($res);

        foreach (array_keys($res) as $r) {
            array_push($result, $this->repository->getRepository(Post::class)->find($r));
        }
        return $result;
    }
}
