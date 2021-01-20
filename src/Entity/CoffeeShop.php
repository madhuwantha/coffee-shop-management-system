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
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="coffeeShops", cascade={"persist", "remove"})
     */
    private $theme;

    /**
     * @ORM\OneToOne(targetEntity=Menu::class, cascade={"persist", "remove"})
     */
    private $menu;


    /**
     * @ORM\OneToMany(targetEntity=SliderImage::class, mappedBy="shop", cascade={"persist", "remove"})
     */
    private $sliderImages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $aboutUs;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="coffeeShops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToOne(targetEntity=ContactDetails::class, inversedBy="coffeeShop", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $contactDetail;

    /**
     * @ORM\OneToOne(targetEntity=CoverPhoto::class, cascade={"persist", "remove"})
     */
    private $coverPhoto;

    /**
     * @ORM\OneToMany(targetEntity=Item::class, mappedBy="shop", orphanRemoval=true)
     */
    private $items;

    /**
     * @ORM\OneToMany(targetEntity=OpenHour::class, mappedBy="shop", orphanRemoval=true,  cascade={"persist", "remove"})
     */
    private $openHours;


    public function __construct()
    {
        $this->sliderImages = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->openHours = new ArrayCollection();
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

    public function getAboutUs(): ?string
    {
        return $this->aboutUs;
    }

    public function setAboutUs(string $aboutUs): self
    {
        $this->aboutUs = $aboutUs;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getContactDetail(): ?ContactDetails
    {
        return $this->contactDetail;
    }

    public function setContactDetail(ContactDetails $contactDetail): self
    {
        $this->contactDetail = $contactDetail;

        return $this;
    }

    public function getCoverPhoto(): ?CoverPhoto
    {
        return $this->coverPhoto;
    }

    public function setCoverPhoto(?CoverPhoto $coverPhoto): self
    {
        $this->coverPhoto = $coverPhoto;

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
            $item->setShop($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getShop() === $this) {
                $item->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OpenHour[]
     */
    public function getOpenHours(): Collection
    {
        return $this->openHours;
    }

    public function addOpenHour(OpenHour $openHour): self
    {
        if (!$this->openHours->contains($openHour)) {
            $this->openHours[] = $openHour;
            $openHour->setShop($this);
        }

        return $this;
    }

    public function removeOpenHour(OpenHour $openHour): self
    {
        if ($this->openHours->removeElement($openHour)) {
            // set the owning side to null (unless already changed)
            if ($openHour->getShop() === $this) {
                $openHour->setShop(null);
            }
        }

        return $this;
    }

}
