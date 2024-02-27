<?php

namespace App\Entity;

use App\Repository\BiologicalDataRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BiologicalDataRepository::class)]
class BiologicalData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'biologicalData', targetEntity: Bracelet::class)]
    private Collection $braceletId;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\Column(length: 255)]
    private ?string $measurementType = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    public function __construct()
    {
        $this->braceletId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Bracelet>
     */
    public function getBraceletId(): Collection
    {
        return $this->braceletId;
    }

    public function addBraceletId(Bracelet $braceletId): static
    {
        if (!$this->braceletId->contains($braceletId)) {
            $this->braceletId->add($braceletId);
            $braceletId->setBiologicalData($this);
        }

        return $this;
    }

    public function removeBraceletId(Bracelet $braceletId): static
    {
        if ($this->braceletId->removeElement($braceletId)) {
            // set the owning side to null (unless already changed)
            if ($braceletId->getBiologicalData() === $this) {
                $braceletId->setBiologicalData(null);
            }
        }

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getMeasurementType(): ?string
    {
        return $this->measurementType;
    }

    public function setMeasurementType(string $measurementType): static
    {
        $this->measurementType = $measurementType;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }
}
