<?php

namespace App\Entity;

use App\Repository\ArtistTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;




#[ORM\Entity(repositoryClass: ArtistTypeRepository::class)]
/**
 * @ORM\Entity(repositoryClass="ArtistTypeRepository")
 * @ORM\Table(name="artist_type",uniqueConstraints={
 *       @ORM\UniqueConstraint(name="artist_type_idx", columns={"artist_id", "type_id"})})
 * @UniqueEntity(
 *      fields={"artist","type"},
 *      message="This artist is already defined for this type of job in the database."
 * )
 */

class ArtistType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: "artists")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[ORM\ManyToMany(targetEntity: Show::class, mappedBy: 'artistTypes')]
    private Collection $shows;

    #[ORM\ManyToOne(inversedBy: 'artistTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artist $artist = null;

    #[ORM\OneToMany(mappedBy: 'artistetype', targetEntity: ArtistTypeShow::class, orphanRemoval: true)]
    private Collection $artistTypeShows;

    public function __construct()
    {
        $this->shows = new ArrayCollection();
        $this->artistTypeShows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

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
            $show->addArtistType($this);
        }

        return $this;
    }

    public function removeShow(Show $show): self
    {
        if ($this->shows->removeElement($show)) {
            $show->removeArtistType($this);
        }

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }
    public function getArtistType(Artist $artist): Type
        {
        

            if ($this->artist === $artist) {
                return $this->type;
            }
    
            return null;
            
    
            
        }

    /**
     * @return Collection<int, ArtistTypeShow>
     */
    public function getArtistTypeShows(): Collection
    {
        return $this->artistTypeShows;
    }

    public function addArtistTypeShow(ArtistTypeShow $artistTypeShow): self
    {
        if (!$this->artistTypeShows->contains($artistTypeShow)) {
            $this->artistTypeShows->add($artistTypeShow);
            $artistTypeShow->setArtistetype($this);
        }

        return $this;
    }

    public function removeArtistTypeShow(ArtistTypeShow $artistTypeShow): self
    {
        if ($this->artistTypeShows->removeElement($artistTypeShow)) {
            // set the owning side to null (unless already changed)
            if ($artistTypeShow->getArtistetype() === $this) {
                $artistTypeShow->setArtistetype(null);
            }
        }

        return $this;
    }
    


// public function __toString()
// {
//     return $this->getArtist() . ' - ' . $this->getType();
// }
 


public function __toString()
{
    $artistName = $this->getArtist() ? $this->getArtist()->getFirstName() . ' ' . $this->getArtist()->getLastName() : 'Unknown Artist';
    $typeName = $this->getType() ; 
    
    return $artistName . ' - ' . $typeName;
}



}
