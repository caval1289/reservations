<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\JoinColumn;



#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[ORM\Table(name:"locations")]
#[UniqueEntity(fields:["slug"])]

class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $slug = null;

    #[ORM\Column(length: 60)]
    private ?string $designation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adress = null;

    //Est-ce qu'on fait comme cela
    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(onDelete: 'RESTRICT')]
    private ?Locality $locality = null;    

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Show::class)]
    private Collection $shows;

    #[ORM\OneToMany(mappedBy: 'the_location', targetEntity: Representation::class)]
    private Collection $representations;

    public function __construct()
    {
        $this->shows = new ArrayCollection();
        $this->representations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getLocality(): ?locality
    {
        return $this->locality;
    }

    public function setLocality(?locality $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Show>
     */
    public function getShows(): Collection
    {
        return $this->shows;
    }

    public function addShow(Show $show): self
    {
        if (!$this->shows->contains($show)) {
            $this->shows->add($show);
            $show->setLocation($this);
        }

        return $this;
    }

    public function removeShow(Show $show): self
    {
        if ($this->shows->removeElement($show)) {
            // set the owning side to null (unless already changed)
            if ($show->getLocation() === $this) {
                $show->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Representation>
     */
    public function getRepresentations(): Collection
    {
        return $this->representations;
    }

    public function addRepresentation(Representation $representation): self
    {
        if (!$this->representations->contains($representation)) {
            $this->representations->add($representation);
            $representation->setTheLocation($this);
        }

        return $this;
    }

    public function removeRepresentation(Representation $representation): self
    {
        if ($this->representations->removeElement($representation)) {
            // set the owning side to null (unless already changed)
            if ($representation->getTheLocation() === $this) {
                $representation->setTheLocation(null);
            }
        }

        return $this;
    }
}
