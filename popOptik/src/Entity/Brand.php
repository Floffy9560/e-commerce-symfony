<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contactLens = null;

    /**
     * @var Collection<int, Glass>
     */
    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: Glass::class)]
    private Collection $glasses;

    public function __construct()
    {
        $this->glasses = new ArrayCollection();
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

    public function getContactLens(): ?string
    {
        return $this->contactLens;
    }

    public function setContactLens(?string $contactLens): static
    {
        $this->contactLens = $contactLens;
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
            $glass->setBrand($this);
        }
        return $this;
    }

    public function removeGlass(Glass $glass): static
    {
        if ($this->glasses->removeElement($glass)) {
            if ($glass->getBrand() === $this) {
                $glass->setBrand(null);
            }
        }
        return $this;
    }
}
