<?php

namespace App\Entity;

use App\Repository\CoffeeShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoffeeShopRepository::class)
 */
class CoffeeShop
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
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="coffeeShops")
     */
    private $theme;

    /**
     * @ORM\OneToOne(targetEntity=Menu::class, cascade={"persist", "remove"})
     */
    private $menu;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=SliderImage::class, mappedBy="shop")
     */
    private $sliderImages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=ContactDetails::class, mappedBy="shop")
     */
    private $contactDetails;


    public function __construct()
    {
        $this->sliderImages = new ArrayCollection();
        $this->contactDetails = new ArrayCollection();
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|SliderImage[]
     */
    public function getSliderImages(): Collection
    {
        return $this->sliderImages;
    }

    public function addSliderImage(SliderImage $sliderImage): self
    {
        if (!$this->sliderImages->contains($sliderImage)) {
            $this->sliderImages[] = $sliderImage;
            $sliderImage->setShop($this);
        }

        return $this;
    }

    public function removeSliderImage(SliderImage $sliderImage): self
    {
        if ($this->sliderImages->removeElement($sliderImage)) {
            // set the owning side to null (unless already changed)
            if ($sliderImage->getShop() === $this) {
                $sliderImage->setShop(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|ContactDetails[]
     */
    public function getContactDetails(): Collection
    {
        return $this->contactDetails;
    }

    public function addContactDetail(ContactDetails $contactDetail): self
    {
        if (!$this->contactDetails->contains($contactDetail)) {
            $this->contactDetails[] = $contactDetail;
            $contactDetail->setShop($this);
        }

        return $this;
    }

    public function removeContactDetail(ContactDetails $contactDetail): self
    {
        if ($this->contactDetails->removeElement($contactDetail)) {
            // set the owning side to null (unless already changed)
            if ($contactDetail->getShop() === $this) {
                $contactDetail->setShop(null);
            }
        }

        return $this;
    }

}
