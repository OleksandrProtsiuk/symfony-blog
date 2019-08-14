<?php

namespace App\Entity\DTO;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Subscribe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=120)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min="5", max="120")
     * @Assert\Email(checkHost="true", mode="html5")
     */
    public $email;
}
