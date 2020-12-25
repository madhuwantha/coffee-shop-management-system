<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
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
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="customer")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=ProfilePicture::class, mappedBy="path")
     */
    private $profilePictures;

    /**
     * @ORM\OneToMany(targetEntity=CoffeeShop::class, mappedBy="owner")
     */
    private $coffeeShops;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->profilePictures = new ArrayCollection();
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

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProfilePicture[]
     */
    public function getProfilePictures(): Collection
    {
        return $this->profilePictures;
    }

    public function addProfilePicture(ProfilePicture $profilePicture): self
    {
        if (!$this->profilePictures->contains($profilePicture)) {
            $this->profilePictures[] = $profilePicture;
            $profilePicture->setPath($this);
        }

        return $this;
    }

    public function removeProfilePicture(ProfilePicture $profilePicture): self
    {
        if ($this->profilePictures->removeElement($profilePicture)) {
            // set the owning side to null (unless already changed)
            if ($profilePicture->getPath() === $this) {
                $profilePicture->setPath(null);
            }
        }

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
            $coffeeShop->setOwner($this);
        }

        return $this;
    }

    public function removeCoffeeShop(CoffeeShop $coffeeShop): self
    {
        if ($this->coffeeShops->removeElement($coffeeShop)) {
            // set the owning side to null (unless already changed)
            if ($coffeeShop->getOwner() === $this) {
                $coffeeShop->setOwner(null);
            }
        }

        return $this;
    }
}
