<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;


    #[ORM\ManyToOne(inversedBy: 'quiz')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;


    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: Copie::class)]
    private Collection $copies;

    #[ORM\ManyToMany(targetEntity: Formation::class, inversedBy: 'quiz')]
    private Collection $formation;

    #[ORM\ManyToOne(inversedBy: 'quiz')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->copies = new ArrayCollection();
        $this->formation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }


    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }


    /**
     * @return Collection<int, Copie>
     */
    public function getCopies(): Collection
    {
        return $this->copies;
    }

    public function addCopy(Copie $copy): self
    {
        if (!$this->copies->contains($copy)) {
            $this->copies->add($copy);
            $copy->setQuiz($this);
        }

        return $this;
    }

    public function removeCopy(Copie $copy): self
    {
        if ($this->copies->removeElement($copy)) {
            // set the owning side to null (unless already changed)
            if ($copy->getQuiz() === $this) {
                $copy->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormation(): Collection
    {
        return $this->formation;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formation->contains($formation)) {
            $this->formation->add($formation);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        $this->formation->removeElement($formation);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
