<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="items")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=ItemImage::class, mappedBy="item")
     */
    private $itemImages;

    public function __construct()
    {
        $this->itemImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|ItemImage[]
     */
    public function getItemImages(): Collection
    {
        return $this->itemImages;
    }

    public function addItemImage(ItemImage $itemImage): self
    {
        if (!$this->itemImages->contains($itemImage)) {
            $this->itemImages[] = $itemImage;
            $itemImage->setItem($this);
        }

        return $this;
    }

    public function removeItemImage(ItemImage $itemImage): self
    {
        if ($this->itemImages->removeElement($itemImage)) {
            // set the owning side to null (unless already changed)
            if ($itemImage->getItem() === $this) {
                $itemImage->setItem(null);
            }
        }

        return $this;
    }
}
