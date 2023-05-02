<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
#[ORM\Table(name:"artists")]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Assert\Length(
        min: 2,
        max: 60,
        minMessage: 'Your firstname must be at least {{ limit }} characters long',
       // maxMessage: 'Your firstname cannot be longer than {{ limit }} characters',
    )]

    private ?string $firstname = null;

    #[ORM\Column(length: 60)]
    #[Assert\Length(
        min: 2,
        max: 60,
        minMessage: 'Your lastname must be at least {{ limit }} characters long',
       // maxMessage: 'Your lastname cannot be longer than {{ limit }} characters',
    )]

    private ?string $lastname = null;

    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: ArtistType::class)]
    private Collection $artistTypes;

   

    public function __construct()
    {
        $this->artistTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, ArtistType>
     */
    public function getArtistTypes(): Collection
    {
        return $this->artistTypes;
    }

    public function addArtistType(ArtistType $artistType): self
    {
        if (!$this->artistTypes->contains($artistType)) {
            $this->artistTypes->add($artistType);
            $artistType->setArtist($this);
        }

        return $this;
    }

    public function removeArtistType(ArtistType $artistType): self
    {
        if ($this->artistTypes->removeElement($artistType)) {
            // set the owning side to null (unless already changed)
            if ($artistType->getArtist() === $this) {
                $artistType->setArtist(null);
            }
        }

        return $this;
    }

        

    
}
