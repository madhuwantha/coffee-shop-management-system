<?php

namespace App\Entity;

use App\Repository\ProfilePictureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfilePictureRepository::class)
 */
class ProfilePicture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="profilePictures")
     */
    private $path;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?User
    {
        return $this->path;
    }

    public function setPath(?User $path): self
    {
        $this->path = $path;

        return $this;
    }
}
