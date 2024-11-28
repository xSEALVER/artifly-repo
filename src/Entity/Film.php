<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $titre = null;

    #[ORM\Column(length: 20)]
    private ?string $genre = null;

    #[ORM\Column(length: 10)]
    private ?string $date_sortie = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 50)]
    private ?string $duration = null;

    #[ORM\Column(length: 255)]
    private ?string $url_image = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'film')]
    private Collection $filmReservations;

    public function __construct()
    {
        $this->filmReservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDateSortie(): ?string
    {
        return $this->date_sortie;
    }

    public function setDateSortie(string $date_sortie): static
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getUrlImage(): ?string
    {
        return $this->url_image;
    }

    public function setUrlImage(string $url_image): static
    {
        $this->url_image = $url_image;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getFilmReservations(): Collection
    {
        return $this->filmReservations;
    }

    public function addFilmReservation(Reservation $filmReservation): static
    {
        if (!$this->filmReservations->contains($filmReservation)) {
            $this->filmReservations->add($filmReservation);
            $filmReservation->setFilm($this);
        }

        return $this;
    }

    public function removeFilmReservation(Reservation $filmReservation): static
    {
        if ($this->filmReservations->removeElement($filmReservation)) {
            // set the owning side to null (unless already changed)
            if ($filmReservation->getFilm() === $this) {
                $filmReservation->setFilm(null);
            }
        }

        return $this;
    }
}
