<?php

namespace App\Entity;

use App\Repository\ProfessionalAccessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessionalAccessRepository::class)]
class ProfessionalAccess
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'professionalAccesses')]
    private ?HealthProfessional $userId = null;

    #[ORM\ManyToOne(inversedBy: 'professionalAccesses')]
    private ?User $patientUserId = null;

    #[ORM\Column(length: 255)]
    private ?string $accessLevel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?HealthProfessional
    {
        return $this->userId;
    }

    public function setUserId(?HealthProfessional $userId): static
    {
        $this->userId = $userId;

        return $this;
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

    public function getAccessLevel(): ?string
    {
        return $this->accessLevel;
    }

    public function setAccessLevel(string $accessLevel): static
    {
        $this->accessLevel = $accessLevel;

        return $this;
    }
}
