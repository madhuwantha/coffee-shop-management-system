<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GalleryRepository::class)
 */
class Gallery
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
     * @ORM\OneToMany(targetEntity=GalleryImage::class, mappedBy="gallery",  cascade={"persist", "remove"})
     */
    private $galleryImages;

    /**
     * @ORM\OneToMany(targetEntity=GalleryVideo::class, mappedBy="gallery", cascade={"persist", "remove"})
     */
    private $galleryVideos;

    /**
     * @ORM\OneToOne(targetEntity=CoffeeShop::class, cascade={"persist", "remove"})
     */
    private $coffee_shop;

    public function __construct()
    {
        $this->galleryImages = new ArrayCollection();
        $this->galleryVideos = new ArrayCollection();
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
     * @return Collection|GalleryImage[]
     */
    public function getGalleryImages(): Collection
    {
        return $this->galleryImages;
    }

    public function addGalleryImage(GalleryImage $galleryImage): self
    {
        if (!$this->galleryImages->contains($galleryImage)) {
            $this->galleryImages[] = $galleryImage;
            $galleryImage->setGallery($this);
        }

        return $this;
    }

    public function removeGalleryImage(GalleryImage $galleryImage): self
    {
        if ($this->galleryImages->removeElement($galleryImage)) {
            // set the owning side to null (unless already changed)
            if ($galleryImage->getGallery() === $this) {
                $galleryImage->setGallery(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GalleryVideo[]
     */
    public function getGalleryVideos(): Collection
    {
        return $this->galleryVideos;
    }

    public function addGalleryVideo(GalleryVideo $galleryVideo): self
    {
        if (!$this->galleryVideos->contains($galleryVideo)) {
            $this->galleryVideos[] = $galleryVideo;
            $galleryVideo->setGallery($this);
        }

        return $this;
    }

    public function removeGalleryVideo(GalleryVideo $galleryVideo): self
    {
        if ($this->galleryVideos->removeElement($galleryVideo)) {
            // set the owning side to null (unless already changed)
            if ($galleryVideo->getGallery() === $this) {
                $galleryVideo->setGallery(null);
            }
        }

        return $this;
    }

    public function getCoffeeShop(): ?CoffeeShop
    {
        return $this->coffee_shop;
    }

    public function setCoffeeShop(?CoffeeShop $coffee_shop): self
    {
        $this->coffee_shop = $coffee_shop;

        return $this;
    }
}
