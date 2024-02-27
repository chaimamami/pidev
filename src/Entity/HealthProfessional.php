<?php

namespace App\Entity;

use App\Repository\HealthProfessionalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HealthProfessionalRepository::class)]
class HealthProfessional
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $specialty = null;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: ProfessionalAccess::class)]
    private Collection $professionalAccesses;

    #[ORM\OneToMany(mappedBy: 'professionalUserId', targetEntity: Appointment::class)]
    private Collection $appointments;

    #[ORM\ManyToOne(inversedBy: 'healthProfessionals')]
    private ?Hospital $hospitalId = null;

    #[ORM\Column(length: 255)]
    private ?string $dashboardType = null;

    #[ORM\OneToMany(mappedBy: 'healthProfessional', targetEntity: BiologicalData::class)]
    private Collection $biologicalData;

    
    public function __construct()
    {
        $this->professionalAccesses = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->biologicalData = new ArrayCollection();
    }

    

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSpecialty(): ?string
    {
        return $this->specialty;
    }

    public function setSpecialty(string $specialty): static
    {
        $this->specialty = $specialty;

        return $this;
    }

    /**
     * @return Collection<int, ProfessionalAccess>
     */
    public function getProfessionalAccesses(): Collection
    {
        return $this->professionalAccesses;
    }

    public function addProfessionalAccess(ProfessionalAccess $professionalAccess): static
    {
        if (!$this->professionalAccesses->contains($professionalAccess)) {
            $this->professionalAccesses->add($professionalAccess);
            $professionalAccess->setUserId($this);
        }

        return $this;
    }

    public function removeProfessionalAccess(ProfessionalAccess $professionalAccess): static
    {
        if ($this->professionalAccesses->removeElement($professionalAccess)) {
            // set the owning side to null (unless already changed)
            if ($professionalAccess->getUserId() === $this) {
                $professionalAccess->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Appointment>
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): static
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments->add($appointment);
            $appointment->setProfessionalUserId($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): static
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getProfessionalUserId() === $this) {
                $appointment->setProfessionalUserId(null);
            }
        }

        return $this;
    }

    public function getHospitalId(): ?Hospital
    {
        return $this->hospitalId;
    }

    public function setHospitalId(?Hospital $hospitalId): static
    {
        $this->hospitalId = $hospitalId;

        return $this;
    }

    public function getDashboardType(): ?string
    {
        return $this->dashboardType;
    }

    public function setDashboardType(string $dashboardType): static
    {
        $this->dashboardType = $dashboardType;

        return $this;
    }

    /**
     * @return Collection<int, BiologicalData>
     */
    public function getBiologicalData(): Collection
    {
        return $this->biologicalData;
    }

    public function addBiologicalData(BiologicalData $biologicalData): static
    {
        if (!$this->biologicalData->contains($biologicalData)) {
            $this->biologicalData->add($biologicalData);
            $biologicalData->setHealthProfessional($this);
        }

        return $this;
    }

    public function removeBiologicalData(BiologicalData $biologicalData): static
    {
        if ($this->biologicalData->removeElement($biologicalData)) {
            // set the owning side to null (unless already changed)
            if ($biologicalData->getHealthProfessional() === $this) {
                $biologicalData->setHealthProfessional(null);
            }
        }

        return $this;
    }

   
}
