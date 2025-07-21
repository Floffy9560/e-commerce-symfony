<?php

namespace App\Entity;

use App\Repository\ContactLensRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactLensRepository::class)]
class ContactLens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $powerContactLensLeft = null;

    #[ORM\Column]
    private ?int $powerContactLensRight = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'contactLens')]
    private Collection $userContactLens;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'contactLenses')]
    private Collection $contactLensUser;

    public function __construct()
    {
        $this->userContactLens = new ArrayCollection();
        $this->contactLensUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPowerContactLensLeft(): ?int
    {
        return $this->powerContactLensLeft;
    }

    public function setPowerContactLensLeft(int $powerContactLensLeft): static
    {
        $this->powerContactLensLeft = $powerContactLensLeft;

        return $this;
    }

    public function getPowerContactLensRight(): ?int
    {
        return $this->powerContactLensRight;
    }

    public function setPowerContactLensRight(int $powerContactLensRight): static
    {
        $this->powerContactLensRight = $powerContactLensRight;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserContactLens(): Collection
    {
        return $this->userContactLens;
    }

    public function addUserContactLen(User $userContactLen): static
    {
        if (!$this->userContactLens->contains($userContactLen)) {
            $this->userContactLens->add($userContactLen);
            $userContactLen->addContactLen($this);
        }

        return $this;
    }

    public function removeUserContactLen(User $userContactLen): static
    {
        if ($this->userContactLens->removeElement($userContactLen)) {
            $userContactLen->removeContactLen($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getContactLensUser(): Collection
    {
        return $this->contactLensUser;
    }

    public function addContactLensUser(User $contactLensUser): static
    {
        if (!$this->contactLensUser->contains($contactLensUser)) {
            $this->contactLensUser->add($contactLensUser);
        }

        return $this;
    }

    public function removeContactLensUser(User $contactLensUser): static
    {
        $this->contactLensUser->removeElement($contactLensUser);

        return $this;
    }
}
