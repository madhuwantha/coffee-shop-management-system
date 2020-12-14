<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\OneToMany(targetEntity=Item::class, mappedBy="category")
     */
    private $items;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity=NextCategory::class, mappedBy="parent_category")
     */
    private $nextCategories;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->nextCategories = new ArrayCollection();
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
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setCategory($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getCategory() === $this) {
                $item->setCategory(null);
            }
        }

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection|NextCategory[]
     */
    public function getNextCategories(): Collection
    {
        return $this->nextCategories;
    }

    public function addNextCategory(NextCategory $nextCategory): self
    {
        if (!$this->nextCategories->contains($nextCategory)) {
            $this->nextCategories[] = $nextCategory;
            $nextCategory->setParentCategory($this);
        }

        return $this;
    }

    public function removeNextCategory(NextCategory $nextCategory): self
    {
        if ($this->nextCategories->removeElement($nextCategory)) {
            // set the owning side to null (unless already changed)
            if ($nextCategory->getParentCategory() === $this) {
                $nextCategory->setParentCategory(null);
            }
        }

        return $this;
    }
}
