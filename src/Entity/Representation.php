<?php

namespace App\Entity;

use App\Repository\RepresentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: RepresentationRepository::class)]
#[ORM\Table(name:"representations")]

class Representation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'representions')]
    #[ORM\JoinColumn(onDelete: 'RESTRICT')]
    private ?Show $the_show = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $schedule = null;

    #[ORM\ManyToOne(inversedBy: 'representations')]
    private ?Location $the_location = null;

    #[ORM\OneToMany(mappedBy: 'representation', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'representation', targetEntity: RepresentationUser::class, orphanRemoval: true)]
    private Collection $representationUsers;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->representationUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheShow(): ?Show
    {
        return $this->the_show;
    }

    public function setTheShow(?Show $the_show): self
    {
        $this->the_show = $the_show;

        return $this;
    }

    public function getSchedule(): ?\DateTimeInterface
    {
        return $this->schedule;
    }

    public function setSchedule(\DateTimeInterface $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getTheLocation(): ?Location
    {
        return $this->the_location;
    }

    public function setTheLocation(?Location $the_location): self
    {
        $this->the_location = $the_location;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setRepresentation($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRepresentation() === $this) {
                $reservation->setRepresentation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RepresentationUser>
     */
    public function getRepresentationUsers(): Collection
    {
        return $this->representationUsers;
    }

    public function addRepresentationUser(RepresentationUser $representationUser): self
    {
        if (!$this->representationUsers->contains($representationUser)) {
            $this->representationUsers->add($representationUser);
            $representationUser->setRepresentation($this);
        }

        return $this;
    }

    public function removeRepresentationUser(RepresentationUser $representationUser): self
    {
        if ($this->representationUsers->removeElement($representationUser)) {
            // set the owning side to null (unless already changed)
            if ($representationUser->getRepresentation() === $this) {
                $representationUser->setRepresentation(null);
            }
        }

        return $this;
    }
}
