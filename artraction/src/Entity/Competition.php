<?php

namespace App\Entity;

use App\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=CompetitionRepository::class)
 * * @UniqueEntity(
 *     fields={"nom"},
 *     message="This name is already in use "
 * )
 */
class Competition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")<
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="ce champs est obligatoire")<
     */
    private $theme;

    /**
     * @ORM\Column(type="date", nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")<
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date", nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")<
     */
    private $date_fin;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")<
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=OeuvreCompetition::class, mappedBy="competition")
     */
    private $oeuvreCompetitions;

    public function __construct()
    {
        $this->oeuvreCompetitions = new ArrayCollection();
    }

    public function __toString() {
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|OeuvreCompetition[]
     */
    public function getOeuvreCompetitions(): Collection
    {
        return $this->oeuvreCompetitions;
    }

    public function addOeuvreCompetition(OeuvreCompetition $oeuvreCompetition): self
    {
        if (!$this->oeuvreCompetitions->contains($oeuvreCompetition)) {
            $this->oeuvreCompetitions[] = $oeuvreCompetition;
            $oeuvreCompetition->setCompetition($this);
        }

        return $this;
    }

    public function removeOeuvreCompetition(OeuvreCompetition $oeuvreCompetition): self
    {
        if ($this->oeuvreCompetitions->removeElement($oeuvreCompetition)) {
            // set the owning side to null (unless already changed)
            if ($oeuvreCompetition->getCompetition() === $this) {
                $oeuvreCompetition->setCompetition(null);
            }
        }

        return $this;
    }
}
