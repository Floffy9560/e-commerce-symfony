<?php

namespace App\Entity;

use App\Repository\MailingOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MailingOfferRepository::class)]
class MailingOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $rappelAchatLunette = null;

    /**
     * ✅ Une seule relation ManyToMany avec User
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'mailingOffers')]
    #[ORM\JoinTable(name: 'mailing_offer_user')] // table pivot explicite
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRappelAchatLunette(): ?\DateTime
    {
        return $this->rappelAchatLunette;
    }

    public function setRappelAchatLunette(?\DateTime $rappelAchatLunette): static
    {
        $this->rappelAchatLunette = $rappelAchatLunette;
        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);
        return $this;
    }
}
