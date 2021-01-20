<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity=MessageState::class, inversedBy="messages")
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity=MessageReceived::class, mappedBy="message")
     */
    private $messageReceivers;


    private $messageReceiver;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isReplyTo;

    /**
     * @ORM\ManyToOne(targetEntity=Message::class, inversedBy="messages")
     */
    private $replyTo;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="replyTo")
     */
    private $messages;

    /**
     * @return mixed
     */
    public function getMessageReceiver()
    {
        return $this->messageReceiver;
    }

    /**
     * @param mixed $messageReceiver
     */
    public function setMessageReceiver($messageReceiver): void
    {
        $this->messageReceiver = $messageReceiver;
    }

    public function __construct()
    {
        $this->messageReceivers = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getState(): ?MessageState
    {
        return $this->state;
    }

    public function setState(?MessageState $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection|MessageReceived[]
     */
    public function getMessageReceivers(): Collection
    {
        return $this->messageReceivers;
    }

    public function addMessageReceived(MessageReceived $messageReceived): self
    {
        if (!$this->messageReceivers->contains($messageReceived)) {
            $this->messageReceivers[] = $messageReceived;
            $messageReceived->setMessage($this);
        }

        return $this;
    }

    public function removeMessageReceived(MessageReceived $messageReceived): self
    {
        if ($this->messageReceivers->removeElement($messageReceived)) {
            // set the owning side to null (unless already changed)
            if ($messageReceived->getMessage() === $this) {
                $messageReceived->setMessage(null);
            }
        }

        return $this;
    }

    public function getIsReplyTo(): ?bool
    {
        return $this->isReplyTo;
    }

    public function setIsReplyTo(bool $isReplyTo): self
    {
        $this->isReplyTo = $isReplyTo;

        return $this;
    }

    public function getReplyTo(): ?self
    {
        return $this->replyTo;
    }

    public function setReplyTo(?self $replyTo): self
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(self $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setReplyTo($this);
        }

        return $this;
    }

    public function removeMessage(self $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getReplyTo() === $this) {
                $message->setReplyTo(null);
            }
        }

        return $this;
    }
}
