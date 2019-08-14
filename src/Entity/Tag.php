<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 *@UniqueEntity("name")
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
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min="3", max="255")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Post", inversedBy="tags")
     */
    private $post;

    public function __construct()
    {
        $this->post = new ArrayCollection();
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
        return $this->post;
    }

    public function addPostId(Post $postId): self
    {
        if (!$this->post->contains($postId)) {
            $this->post[] = $postId;
        }

        return $this;
    }

    public function removePostId(Post $postId): self
    {
        if ($this->post->contains($postId)) {
            $this->post->removeElement($postId);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->id.'';
    }

    /**
     * @return Collection|Post[]
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Post $post): self
    {
        if (!$this->post->contains($post)) {
            $this->post[] = $post;
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->post->contains($post)) {
            $this->post->removeElement($post);
        }

        return $this;
    }
}
