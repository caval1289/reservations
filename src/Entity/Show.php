<?php

namespace App\Entity;

use App\Repository\ShowRepository;
use App\Entity\ArtistType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\EntityManagerInterface;




#[ORM\Entity(repositoryClass: ShowRepository::class)]
#[ORM\Table(name: "shows")]
#[UniqueEntity(fields: ["slug"])]
class Show
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "Le titre doit faire au moins {{ limit }} caractères",
        maxMessage: "Le titre ne peut pas faire plus de {{ limit }} caractères"
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poster_url = null;

    #[ORM\ManyToOne(inversedBy: 'shows')]
    #[ORM\JoinColumn(onDelete: 'RESTRICT')]
    #[Assert\NotBlank(
        message: "Veuillez sélectionner une location"
    )]
    private ?Location $location = null;

    #[ORM\Column]
    #[Assert\NotNull(
        message: "Veuillez indiquer si le spectacle est réservable ou non"
    )]
    private ?bool $bookable = null;

    #[ORM\Column(type: Types::FLOAT, precision: 12, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero(
        message: "Le prix ne peut pas être négatif"
    )]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'the_show', targetEntity: Representation::class, orphanRemoval: true)]

    private Collection $representations;

    #[ORM\ManyToMany(targetEntity: ArtistType::class, inversedBy: 'shows')]
    #[Assert\Valid()]
    private Collection $artistTypes;

    private $entityManager;

    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->representations = new ArrayCollection();
        $this->artistTypes = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPosterUrl(): ?string
    {
        return $this->poster_url;
    }

    public function setPosterUrl(?string $poster_url): self
    {
        $this->poster_url = $poster_url;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function isBookable(): ?bool
    {
        return $this->bookable;
    }

    public function setBookable(bool $bookable): self
    {
        $this->bookable = $bookable;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Representation>
     */
    public function getRepresentations(): Collection
    {
        return $this->representations;
    }

    public function addRepresention(Representation $represention): self
    {
        if (!$this->representations->contains($represention)) {
            $this->representations->add($represention);
            $represention->setTheShow($this);
        }

        return $this;
    }

    public function removeRepresention(Representation $represention): self
    {
        if ($this->representations->removeElement($represention)) {
            // set the owning side to null (unless already changed)
            if ($represention->getTheShow() === $this) {
                $represention->setTheShow(null);
            }
        }

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
        }

        return $this;
    }

    public function removeArtistType(ArtistType $artistType): self
    {
        $this->artistTypes->removeElement($artistType);

        return $this;
    }

    public function setArtistTypes(Collection $artistTypes): self
    {
        $this->artistTypes = $artistTypes;
        return $this;
    }
    public function getAuthors(): array
    {
        $authors = [];

        foreach ($this->artistTypes as $collaboration) {
            if ($collaboration->getArtistType($collaboration->getArtist())->getType() == "scénographe") {
                $authors[] = $collaboration->getArtist();
            }
        }

        return $authors;
    }

    public function setAuthors(array $authors): self
    {
        if ($this->entityManager !== null) {
            $type = $this->entityManager->getRepository(Type::class)->findOneBy(['type' => 'Scénographe']);
    
            // Ajouter les nouveaux artistes et mettre à jour les existants
            foreach ($authors as $artist) {
                $existingArtistType = $this->getArtistTypeByArtist($artist);
    
                if ($existingArtistType === null) {
                    // L'artiste n'existe pas encore, donc ajoutez-le
                    $collaboration = new ArtistType();
                    $collaboration->setArtist($artist);
                    $collaboration->setType($type);
                    $this->addArtistType($collaboration);
                } else {
                    // L'artiste existe déjà, donc mettez à jour le type si besoin
                    if ($existingArtistType->getType() !== $type) {
                        $existingArtistType->setType($type);
                    }
                }
            }
        }
    
        return $this;
    }

    private function getArtistTypeByArtist(Artist $artist): ?ArtistType
    {
        foreach ($this->artistTypes as $artistType) {
            if ($artistType->getArtist() === $artist) {
                return $artistType;
            }
        }

        return null;
    }
}
