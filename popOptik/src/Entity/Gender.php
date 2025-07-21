<?php

namespace App\Entity;

use App\Repository\GenderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenderRepository::class)]
class Gender
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $gender = null;

    /**
     * @var Collection<int, Glass>
     */
    #[ORM\OneToMany(mappedBy: 'gender', targetEntity: Glass::class)]
    private Collection $glasses;

    public function __construct()
    {
        $this->glasses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return Collection<int, Glass>
     */
    public function getGlasses(): Collection
    {
        return $this->glasses;
    }

    public function addGlass(Glass $glass): static
    {
        if (!$this->glasses->contains($glass)) {
            $this->glasses->add($glass);
            $glass->setGender($this);
        }
        return $this;
    }

    public function removeGlass(Glass $glass): static
    {
        if ($this->glasses->removeElement($glass)) {
            if ($glass->getGender() === $this) {
                $glass->setGender(null);
            }
        }
        return $this;
    }
}
