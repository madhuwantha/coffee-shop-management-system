<?php

namespace App\Entity;

use App\Repository\NextCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NextCategoryRepository::class)
 */
class NextCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

//    /**
//     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="nextCategories")
//     */
//    private $parent_category;
//
//    /**
//     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="nextCategories")
//     */
//    private $child_category;

    public function getId(): ?int
    {
        return $this->id;
    }

//    public function getParentCategory(): ?Category
//    {
//        return $this->parent_category;
//    }
//
//    public function setParentCategory(?Category $parent_category): self
//    {
//        $this->parent_category = $parent_category;
//
//        return $this;
//    }
//
//    public function getChildCategory(): ?Category
//    {
//        return $this->child_category;
//    }
//
//    public function setChildCategory(?Category $child_category): self
//    {
//        $this->child_category = $child_category;
//
//        return $this;
//    }
}
