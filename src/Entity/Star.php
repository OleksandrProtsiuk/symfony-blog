<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StarRepository")
 */
class Star
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $legend;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="stars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="stars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLegend(): ?int
    {
        return $this->legend;
    }

    public function setLegend(int $legend): self
    {
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
