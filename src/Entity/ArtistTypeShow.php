<?php

namespace App\Entity;

use App\Repository\ArtistTypeShowRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistTypeShowRepository::class)]
class ArtistTypeShow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ArtistType $artist_type = null;

   

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Show $shows = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtistType(): ?ArtistType
    {
        return $this->artist_type;
    }

    public function setArtistType(?ArtistType $artist_type): self
    {
        $this->artist_type = $artist_type;

        return $this;
    }



    public function getShows(): ?Show
    {
        return $this->shows;
    }

    public function setShows(?Show $shows): self
    {
        $this->shows = $shows;

        return $this;
    }
}
