<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
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
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="menu", cascade={"persist", "remove"})
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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
 * @return Collection|Category[]
 */
public function getCategories(): Collection
{
    return $this->categories;
}

public function addCategory(Category $category): self
{
    if (!$this->categories->contains($category)) {
        $this->categories[] = $category;
        $category->setMenu($this);
    }

    return $this;
}

public function removeCategory(Category $category): self
{
    if ($this->categories->removeElement($category)) {
        // set the owning side to null (unless already changed)
        if ($category->getMenu() === $this) {
            $category->setMenu(null);
        }
    }

    return $this;
}


}
