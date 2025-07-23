<?php

namespace App\Entity;

use App\Entity\UserInfo;
use App\Repository\UserRepository;
use App\Repository\UserInfoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['userInfo'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'smallint')]
    #[Assert\NotBlank(message: 'Le jour de naissance est obligatoire.')]
    #[Assert\Range(
        notInRangeMessage: 'Le jour de naissance doit être compris entre {{ min }} et {{ max }}.',
        min: 1,
        max: 31
    )]
    private ?int $dayOfBirth = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le mois de naissance est obligatoire.')]
    #[Assert\Choice(
        choices: [
            'janvier',
            'février',
            'mars',
            'avril',
            'mai',
            'juin',
            'juillet',
            'août',
            'septembre',
            'octobre',
            'novembre',
            'décembre'
        ],
        message: 'Le mois de naissance doit être un mois valide.'
    )]
    private ?string $monthOfBirth = null;

    #[ORM\Column(type: 'smallint')]
    #[Assert\NotBlank(message: 'L’année de naissance est obligatoire.')]
    #[Assert\Range(
        notInRangeMessage: 'L’année de naissance doit être comprise entre {{ min }} et {{ max }}.',
        min: 1900,
        max: 2100
    )]
    private ?int $yearOfBirth = null;


    /**
     * @var string The hashed password
     */

    #[ORM\Column]
    private ?string $password = null;


    /**
     * Une seule relation OneToOne vers UserInfo
     * cascade persist pour sauvegarder automatiquement UserInfo
     */
    #[Assert\Valid]
    #[ORM\OneToOne(targetEntity: UserInfo::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "id_user_infos", referencedColumnName: "id", nullable: false)]
    private ?UserInfo $userInfo = null;


    /**
     * ✅ OneToMany : un user peut avoir plusieurs RDV
     */
    #[ORM\OneToMany(targetEntity: Appointment::class, mappedBy: 'userAppointment')]
    private Collection $appointments;

    /**
     * ✅ ManyToMany Items
     */
    #[ORM\ManyToMany(targetEntity: Item::class, mappedBy: 'userItems')]
    private Collection $items;

    /**
     * ✅ ManyToMany MailingOffer
     */
    #[ORM\ManyToMany(targetEntity: MailingOffer::class, mappedBy: 'userOffer')]
    private Collection $mailingOffers;

    /**
     * ✅ ManyToMany GiftCard
     */
    #[ORM\ManyToMany(targetEntity: GiftCard::class, mappedBy: 'users')]
    private Collection $giftCards;

    /**
     * ✅ ManyToMany ContactLens
     */
    #[ORM\ManyToMany(targetEntity: ContactLens::class, mappedBy: 'contactLensUser')]
    private Collection $contactLenses;

    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * @var Collection<int, Cart>
     */
    #[ORM\OneToMany(targetEntity: Cart::class, mappedBy: 'usercart')]
    private Collection $carts;

    #[ORM\Column(type: 'json')]
    private array $roles = [];


    public function __construct()
    {
        $this->appointments = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->mailingOffers = new ArrayCollection();
        $this->giftCards = new ArrayCollection();
        $this->contactLenses = new ArrayCollection();
        $this->carts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayOfBirth(): ?int
    {
        return $this->dayOfBirth;
    }

    public function setDayOfBirth(int $dayOfBirth): static
    {
        $this->dayOfBirth = $dayOfBirth;
        return $this;
    }

    public function getMonthOfBirth(): ?string
    {
        return $this->monthOfBirth;
    }

    public function setMonthOfBirth(string $monthOfBirth): static
    {
        $this->monthOfBirth = $monthOfBirth;
        return $this;
    }

    public function getYearOfBirth(): ?int
    {
        return $this->yearOfBirth;
    }

    public function setYearOfBirth(int $yearOfBirth): static
    {
        $this->yearOfBirth = $yearOfBirth;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        if (empty($password)) {
            throw new \InvalidArgumentException("Le mot de passe ne peut pas être vide.");
        }
        $this->password = $password;
        return $this;
    }

    public function getUserInfo(): ?UserInfo
    {
        return $this->userInfo;
    }

    public function setUserInfo(UserInfo $userInfo): static
    {
        if ($userInfo->getUserAccount() !== $this) {
            $userInfo->setUserAccount($this);
        }
        $this->userInfo = $userInfo;
        return $this;
    }



    /** @return Collection<int, Appointment> */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): static
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments->add($appointment);
            $appointment->setUserAppointment($this);
        }
        return $this;
    }

    public function removeAppointment(Appointment $appointment): static
    {
        if ($this->appointments->removeElement($appointment)) {
            if ($appointment->getUserAppointment() === $this) {
                $appointment->setUserAppointment(null);
            }
        }
        return $this;
    }

    /** @return Collection<int, Item> */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->addUserItem($this);
        }
        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            $item->removeUserItem($this);
        }
        return $this;
    }

    /** @return Collection<int, MailingOffer> */
    public function getMailingOffers(): Collection
    {
        return $this->mailingOffers;
    }

    public function addMailingOffer(MailingOffer $mailingOffer): static
    {
        if (!$this->mailingOffers->contains($mailingOffer)) {
            $this->mailingOffers->add($mailingOffer);
            $mailingOffer->addUserOffer($this);
        }
        return $this;
    }

    public function removeMailingOffer(MailingOffer $mailingOffer): static
    {
        if ($this->mailingOffers->removeElement($mailingOffer)) {
            $mailingOffer->removeUserOffer($this);
        }
        return $this;
    }

    /** @return Collection<int, GiftCard> */
    public function getGiftCards(): Collection
    {
        return $this->giftCards;
    }

    public function addGiftCard(GiftCard $giftCard): static
    {
        if (!$this->giftCards->contains($giftCard)) {
            $this->giftCards->add($giftCard);
            $giftCard->addUserGift($this);
        }
        return $this;
    }

    public function removeGiftCard(GiftCard $giftCard): static
    {
        if ($this->giftCards->removeElement($giftCard)) {
            $giftCard->removeUserGift($this);
        }
        return $this;
    }

    /** @return Collection<int, ContactLens> */
    public function getContactLenses(): Collection
    {
        return $this->contactLenses;
    }

    public function addContactLens(ContactLens $contactLens): static
    {
        if (!$this->contactLenses->contains($contactLens)) {
            $this->contactLenses->add($contactLens);
            $contactLens->addContactLensUser($this);
        }
        return $this;
    }

    public function removeContactLens(ContactLens $contactLens): static
    {
        if ($this->contactLenses->removeElement($contactLens)) {
            $contactLens->removeContactLensUser($this);
        }
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
            $cart->setUsercart($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): static
    {
        if ($this->carts->removeElement($cart)) {
            if ($cart->getUsercart() === $this) {
                $cart->setUsercart(null);
            }
        }

        return $this;
    }

    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // garantit au moins ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Méthode imposée par UserInterface (efface les données sensibles temporaires)
     */
    public function eraseCredentials(): void
    {
        // Rien à faire pour le moment
    }

    /**
     * getUserIdentifier remplace getUsername depuis Symfony 5.3
     * On récupère l'email depuis UserInfo
     */
    public function getUserIdentifier(): string
    {
        return $this->userInfo?->getEmail() ?? '';
    }

    public function setEmail(?string $email): self
    {
        if ($this->userInfo) {
            $this->userInfo->setEmail($email);
        }
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->userInfo?->getFirstname();
    }

    public function getLastname(): ?string
    {
        return $this->userInfo?->getLastname();
    }

    public function getFullname(): ?string
    {
        if (!$this->userInfo) {
            return null;
        }
        return $this->userInfo?->getFirstname() . ' ' . $this->userInfo->getLastname();
    }
    public function getEmail(): ?string
    {
        return $this->userInfo?->getEmail();
    }
}
