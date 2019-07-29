<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Post", inversedBy="tags")
     */
    private $post_id;

    public function __construct()
    {
        $this->post_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostId(): Collection
    {
        return $this->post_id;
    }

    public function addPostId(Post $postId): self
    {
        if (!$this->post_id->contains($postId)) {
            $this->post_id[] = $postId;
        }

        return $this;
    }

    public function removePostId(Post $postId): self
    {
        if ($this->post_id->contains($postId)) {
            $this->post_id->removeElement($postId);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->id.'';
    }
}
