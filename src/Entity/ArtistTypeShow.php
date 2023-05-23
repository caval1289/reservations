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

    #[ORM\ManyToOne(inversedBy: 'artistTypeShows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ArtistType $artistetype = null;

    #[ORM\ManyToOne(inversedBy: 'artistTypeShows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Show $show = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtistetype(): ?ArtistType
    {
        return $this->artistetype;
    }

    public function setArtistetype(?ArtistType $artistetype): self
    {
        $this->artistetype = $artistetype;

        return $this;
    }

    public function getshow(): ?Show
    {
        return $this->show;
    }

    public function setshow(?Show $show): self
    {
        $this->show = $show;

        return $this;
    }


    public function __toString()
    {
        return $this->getArtistetype()->getType();

    }


}
