<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $appointmentDate = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $appointmentHour = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userAppointment = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    private ?User $userRDV = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppointmentDate(): ?\DateTime
    {
        return $this->appointmentDate;
    }

    public function setAppointmentDate(?\DateTime $appointmentDate): static
    {
        $this->appointmentDate = $appointmentDate;

        return $this;
    }

    public function getAppointmentHour(): ?\DateTime
    {
        return $this->appointmentHour;
    }

    public function setAppointmentHour(\DateTime $appointmentHour): static
    {
        $this->appointmentHour = $appointmentHour;

        return $this;
    }

    public function getUserAppointment(): ?User
    {
        return $this->userAppointment;
    }

    public function setUserAppointment(?User $userAppointment): static
    {
        $this->userAppointment = $userAppointment;

        return $this;
    }

    public function getUserRDV(): ?User
    {
        return $this->userRDV;
    }

    public function setUserRDV(?User $userRDV): static
    {
        $this->userRDV = $userRDV;

        return $this;
    }
}
