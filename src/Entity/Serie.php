<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

//use que l'on rentre à la main
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //Par annotations EXEMPLE POUR L'ECF
    /**
     *
     * @Assert\NotBlank(message="Please provide a title")
     * @Assert\Length(min="2", max="255", minMessage="Length is too short", maxMessage="Length is too long")
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $overview = null;

    //PAR ATTRIBUTE
    #[Assert\Choice(choices: ['Cancelled','Ended','Returning'])]
    #[ORM\Column(length: 50)]
    private ?string $status = null;

    //Met une fourchette sur les votes (entre 0 et 10)
    #[Assert\Range(notInRangeMessage: 'You are not in range', min: 0, max: 10)]
    #[ORM\Column(type: Types::DECIMAL, precision: 2, scale: 1)]
    private ?string $vote = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $popularity = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $firstAirDate = null;

    //Permet de mettre une condition que la date doit etre apres ou égale la premiere date de diffusion
    #[Assert\GreaterThanOrEqual(propertyPath: 'firstAirDate')]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $lastAirDate = null;

    #[ORM\Column(length: 255)]
    private ?string $backdrop = null;

    //Juste pour montrer une regex, on attend une image qui finit par .jpg
    #[Assert\Regex(pattern: '/^.+\.(jpg|jpeg|png|gif|bmp)$/',message: 'The poster is not an image')]
    #[ORM\Column(length: 255)]
    private ?string $poster = null;

    #[ORM\Column]
    private ?int $tmdbId = null;

    //Correspond à la création de l'entrée pas la création de la série
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreated = null;

    //Correspond à la modification de l'entrée pas la modification de la série
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateModified = null;

    //orphan commenté car on a fait une suppression manuelle
    #[ORM\OneToMany(mappedBy: 'serie', targetEntity: Season::class, /*orphanRemoval: true*/)]
    private Collection $seasons;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getVote(): ?string
    {
        return $this->vote;
    }

    public function setVote(string $vote): self
    {
        $this->vote = $vote;

        return $this;
    }

    public function getPopularity(): ?string
    {
        return $this->popularity;
    }

    public function setPopularity(string $popularity): self
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getFirstAirDate(): ?\DateTimeInterface
    {
        return $this->firstAirDate;
    }

    public function setFirstAirDate(\DateTimeInterface $firstAirDate): self
    {
        $this->firstAirDate = $firstAirDate;

        return $this;
    }

    public function getLastAirDate(): ?\DateTimeInterface
    {
        return $this->lastAirDate;
    }

    public function setLastAirDate(\DateTimeInterface $lastAirDate): self
    {
        $this->lastAirDate = $lastAirDate;

        return $this;
    }

    public function getBackdrop(): ?string
    {
        return $this->backdrop;
    }

    public function setBackdrop(string $backdrop): self
    {
        $this->backdrop = $backdrop;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    public function setTmdbId(int $tmdbId): self
    {
        $this->tmdbId = $tmdbId;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(?\DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * @return Collection<int, Season>
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(Season $season): self
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons->add($season);
            $season->setSerie($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): self
    {
        if ($this->seasons->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getSerie() === $this) {
                $season->setSerie(null);
            }
        }

        return $this;
    }
}
