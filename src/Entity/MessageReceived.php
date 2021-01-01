<?php

namespace App\Entity;

use App\Repository\MessageReceivedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageReceivedRepository::class)
 */
class MessageReceived
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messageReceiveds")
     */
    private $reciever;

    /**
     * @ORM\ManyToOne(targetEntity=Message::class, inversedBy="messageReceiveds")
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReciever(): ?User
    {
        return $this->reciever;
    }

    public function setReciever(?User $reciever): self
    {
        $this->reciever = $reciever;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        return $this;
    }
}
