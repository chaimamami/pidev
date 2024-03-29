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

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    private ?User $patientUserId = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    private ?HealthProfessional $professionalUserId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTime = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatientUserId(): ?User
    {
        return $this->patientUserId;
    }

    public function setPatientUserId(?User $patientUserId): static
    {
        $this->patientUserId = $patientUserId;

        return $this;
    }

    public function getProfessionalUserId(): ?HealthProfessional
    {
        return $this->professionalUserId;
    }

    public function setProfessionalUserId(?HealthProfessional $professionalUserId): static
    {
        $this->professionalUserId = $professionalUserId;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): static
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
