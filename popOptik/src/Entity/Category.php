<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80, nullable: true)]
    private ?string $name = null;  // remplace sun/optical par un seul nom plus clair

    /**
     * @var Collection<int, Glass>
     */
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Glass::class)]
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

    public function setName(?string $name): static
    {
        $this->name = $name;
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
            $glass->setCategory($this);
        }
        return $this;
    }

    public function removeGlass(Glass $glass): static
    {
        if ($this->glasses->removeElement($glass)) {
            if ($glass->getCategory() === $this) {
                $glass->setCategory(null);
            }
        }
        return $this;
    }
}
