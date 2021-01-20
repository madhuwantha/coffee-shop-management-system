<?php

namespace App\Entity;

use App\Repository\OpenHourRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OpenHourRepository::class)
 */
class OpenHour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CoffeeShop::class, inversedBy="openHours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shop;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $start;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $end;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $day;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShop(): ?CoffeeShop
    {
        return $this->shop;
    }

    public function setShop(?CoffeeShop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getStart(): ?string
    {
        return $this->start;
    }

    public function setStart(string $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?string
    {
        return $this->end;
    }

    public function setEnd(string $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }
}
