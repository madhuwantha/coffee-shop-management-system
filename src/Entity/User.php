<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User extends Image implements UserInterface
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
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="customer")
     */
    private $orders;


    /**
     * @ORM\OneToMany(targetEntity=CoffeeShop::class, mappedBy="owner")
     */
    private $coffeeShops;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="sender")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity=MessageReceived::class, mappedBy="reciever")
     */
    private $messageReceiveds;

    /**
     * @ORM\OneToMany(targetEntity=ProfilePicture::class, mappedBy="user",cascade={"persist", "remove"})
     */
    private $profilePictures;


    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public $isAdmin;


    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->coffeeShops = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->messageReceiveds = new ArrayCollection();
        $this->profilePictures = new ArrayCollection();
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
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|CoffeeShop[]
     */
    public function getCoffeeShops(): Collection
    {
        return $this->coffeeShops;
    }

    public function addCoffeeShop(CoffeeShop $coffeeShop): self
    {
        if (!$this->coffeeShops->contains($coffeeShop)) {
            $this->coffeeShops[] = $coffeeShop;
            $coffeeShop->setOwner($this);
        }

        return $this;
    }

    public function removeCoffeeShop(CoffeeShop $coffeeShop): self
    {
        if ($this->coffeeShops->removeElement($coffeeShop)) {
            // set the owning side to null (unless already changed)
            if ($coffeeShop->getOwner() === $this) {
                $coffeeShop->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MessageReceived[]
     */
    public function getMessageReceiveds(): Collection
    {
        return $this->messageReceiveds;
    }

    public function addMessageReceived(MessageReceived $messageReceived): self
    {
        if (!$this->messageReceiveds->contains($messageReceived)) {
            $this->messageReceiveds[] = $messageReceived;
            $messageReceived->setReciever($this);
        }

        return $this;
    }

    public function removeMessageReceived(MessageReceived $messageReceived): self
    {
        if ($this->messageReceiveds->removeElement($messageReceived)) {
            // set the owning side to null (unless already changed)
            if ($messageReceived->getReciever() === $this) {
                $messageReceived->setReciever(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProfilePicture[]
     */
    public function getProfilePictures(): Collection
    {
        return $this->profilePictures;
    }

    public function addProfilePicture(ProfilePicture $profilePicture): self
    {
        if (!$this->profilePictures->contains($profilePicture)) {
            $this->profilePictures[] = $profilePicture;
            $profilePicture->setUser($this);
        }

        return $this;
    }

    public function removeProfilePicture(ProfilePicture $profilePicture): self
    {
        if ($this->profilePictures->removeElement($profilePicture)) {
            // set the owning side to null (unless already changed)
            if ($profilePicture->getUser() === $this) {
                $profilePicture->setUser(null);
            }
        }

        return $this;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

}
