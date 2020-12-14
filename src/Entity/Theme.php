<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 */
class Theme
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=CoffeeShop::class, mappedBy="theme")
     */
    private $coffeeShops;

    public function __construct()
    {
        $this->coffeeShops = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|CoffeeShop[]
     */
    public function getCoffeeShops(): Collection
    {
        return $this->coffeeShops;
    }

    public function addCoffeeShop(CoffeeShop $coffeeShop): self
    {
        if (!$this->coffeeShops->contains($coffeeShop)) {
            $this->coffeeShops[] = $coffeeShop;
            $coffeeShop->setTheme($this);
        }

        return $this;
    }

    public function removeCoffeeShop(CoffeeShop $coffeeShop): self
    {
        if ($this->coffeeShops->removeElement($coffeeShop)) {
            // set the owning side to null (unless already changed)
            if ($coffeeShop->getTheme() === $this) {
                $coffeeShop->setTheme(null);
            }
        }

        return $this;
    }
}
