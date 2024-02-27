<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $role = 'ROLE_USER'; // Set default role to ROLE_USER

    #[ORM\ManyToOne(inversedBy: 'userId')]
    private ?Bracelet $bracelet = null;

    #[ORM\OneToMany(mappedBy: 'patientUserId', targetEntity: ProfessionalAccess::class)]
    private Collection $professionalAccesses;

    #[ORM\OneToMany(mappedBy: 'patientUserId', targetEntity: Appointment::class)]
    private Collection $appointments;

    public function __construct()
    {
        $this->professionalAccesses = new ArrayCollection();
        $this->appointments = new ArrayCollection();
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
    
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

   public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role ? 'ROLE_' . strtoupper($this->role) : null;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getBracelet(): ?Bracelet
    {
        return $this->bracelet;
    }

    public function setBracelet(?Bracelet $bracelet): static
    {
        $this->bracelet = $bracelet;

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
            $professionalAccess->setPatientUserId($this);
        }

        return $this;
    }

    public function removeProfessionalAccess(ProfessionalAccess $professionalAccess): static
    {
        if ($this->professionalAccesses->removeElement($professionalAccess)) {
            // set the owning side to null (unless already changed)
            if ($professionalAccess->getPatientUserId() === $this) {
                $professionalAccess->setPatientUserId(null);
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
            $appointment->setPatientUserId($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): static
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getPatientUserId() === $this) {
                $appointment->setPatientUserId(null);
            }
        }

        return $this;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return [$this->role];
    }

    

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

   
}
