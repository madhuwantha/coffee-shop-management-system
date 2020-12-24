<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $line_one;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $line_two;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     */
    private $postal_code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLineOne(): ?string
    {
        return $this->line_one;
    }

    public function setLineOne(?string $line_one): self
    {
        $this->line_one = $line_one;

        return $this;
    }

    public function getLineTwo(): ?string
    {
        return $this->line_two;
    }

    public function setLineTwo(?string $line_two): self
    {
        $this->line_two = $line_two;

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

    public function getPostalCode(): ?Integer
    {
        return $this->postal_code;
    }

    public function setPostalCode(Integer $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }
}
