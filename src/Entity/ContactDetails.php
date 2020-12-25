<?php

namespace App\Entity;

use App\Repository\ContactDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactDetailsRepository::class)
 */
class ContactDetails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="text")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phone_number;


    /**
     * @ORM\OneToOne(targetEntity=CoffeeShop::class, mappedBy="contactDetail", cascade={"persist", "remove"})
     */
    private $coffeeShop;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="contactDetails", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $address;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getCoffeeShop(): ?CoffeeShop
    {
        return $this->coffeeShop;
    }

    public function setCoffeeShop(CoffeeShop $coffeeShop): self
    {
        // set the owning side of the relation if necessary
        if ($coffeeShop->getContactDetail() !== $this) {
            $coffeeShop->setContactDetail($this);
        }

        $this->coffeeShop = $coffeeShop;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}
