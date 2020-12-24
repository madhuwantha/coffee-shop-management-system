<?php

namespace App\Entity;

use App\Repository\SliderImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SliderImageRepository::class)
 */
class SliderImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity=CoffeeShop::class, inversedBy="sliderImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shop;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getShop(): ?CoffeeShop
    {
        return $this->shop;
    }

    public function setShop(?CoffeeShop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }
}
