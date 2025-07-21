<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(nullable: true)]
    private ?int $stock = null;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'item')]
    private Collection $orders;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Glass $glass = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'items')]
    private Collection $userItems;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\ManyToMany(targetEntity: Order::class, inversedBy: 'items')]
    private Collection $orderItemUser;

    /**
     * @var Collection<int, Cart>
     */
    #[ORM\OneToMany(targetEntity: Cart::class, mappedBy: 'item')]
    private Collection $carts;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->userItems = new ArrayCollection();
        $this->orderItemUser = new ArrayCollection();
        $this->carts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->addItem($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            $order->removeItem($this);
        }

        return $this;
    }

    public function getGlass(): ?Glass
    {
        return $this->glass;
    }

    public function setGlass(?Glass $glass): static
    {
        $this->glass = $glass;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserItems(): Collection
    {
        return $this->userItems;
    }

    public function addUserItem(User $userItem): static
    {
        if (!$this->userItems->contains($userItem)) {
            $this->userItems->add($userItem);
        }

        return $this;
    }

    public function removeUserItem(User $userItem): static
    {
        $this->userItems->removeElement($userItem);

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrderItemUser(): Collection
    {
        return $this->orderItemUser;
    }

    public function addOrderItemUser(Order $orderItemUser): static
    {
        if (!$this->orderItemUser->contains($orderItemUser)) {
            $this->orderItemUser->add($orderItemUser);
        }

        return $this;
    }

    public function removeOrderItemUser(Order $orderItemUser): static
    {
        $this->orderItemUser->removeElement($orderItemUser);

        return $this;
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): static
    {
        if (!$this->carts->contains($cart)) {
            $this->carts->add($cart);
            $cart->setItem($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): static
    {
        if ($this->carts->removeElement($cart)) {
            // set the owning side to null (unless already changed)
            if ($cart->getItem() === $this) {
                $cart->setItem(null);
            }
        }

        return $this;
    }
}
