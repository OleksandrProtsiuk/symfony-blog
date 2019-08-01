<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ReactionRepository")
 * @UniqueEntity(
 *     fields={"post_id", "user_id"},
 *     errorPath="post_id",
 *     errorPath="user_id",
 *     message="No more reactions for this post!"
 * )
 */
class Reaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('very bad', 'bad', 'like', 'good', 'very good')")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min="2", max="120")
     */
    private $legend;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="reactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLegend(): ?string
    {
        return $this->legend;
    }

    const VERY_BAD = 'very bad';
    const BAD = 'bad';
    const LIKE = 'like';
    const GOOD = 'good';
    const VERY_GOOD = 'very good';

    public function setLegend(string $legend): self
    {
        if (!in_array($legend, [self::VERY_BAD, self::BAD, self::LIKE, self::GOOD, self::VERY_GOOD])) {
            throw new \InvalidArgumentException('Invalid legend');
        }
        $this->legend = $legend;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getPostId(): ?Post
    {
        return $this->post_id;
    }

    public function setPostId(?Post $post_id): self
    {
        $this->post_id = $post_id;

        return $this;
    }
}
