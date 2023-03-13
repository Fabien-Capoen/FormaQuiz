<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column]
    private ?float $note_max = null;

    #[ORM\Column]
    private ?bool $reponse1 = null;

    #[ORM\Column]
    private ?bool $reponse2 = null;

    #[ORM\Column]
    private ?bool $reponse3 = null;

    #[ORM\Column]
    private ?bool $reponse4 = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Reponse::class)]
    private Collection $reponses;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuestionType $questionType = null;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getNoteMax(): ?float
    {
        return $this->note_max;
    }

    public function setNoteMax(float $note_max): self
    {
        $this->note_max = $note_max;

        return $this;
    }

    public function isReponse1(): ?bool
    {
        return $this->reponse1;
    }

    public function setReponse1(bool $reponse1): self
    {
        $this->reponse1 = $reponse1;

        return $this;
    }

    public function isReponse2(): ?bool
    {
        return $this->reponse2;
    }

    public function setReponse2(bool $reponse2): self
    {
        $this->reponse2 = $reponse2;

        return $this;
    }

    public function isReponse3(): ?bool
    {
        return $this->reponse3;
    }

    public function setReponse3(bool $reponse3): self
    {
        $this->reponse3 = $reponse3;

        return $this;
    }

    public function isReponse4(): ?bool
    {
        return $this->reponse4;
    }

    public function setReponse4(bool $reponse4): self
    {
        $this->reponse4 = $reponse4;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestion() === $this) {
                $reponse->setQuestion(null);
            }
        }

        return $this;
    }

    public function getQuestionType(): ?QuestionType
    {
        return $this->questionType;
    }

    public function setQuestionType(?QuestionType $questionType): self
    {
        $this->questionType = $questionType;

        return $this;
    }
}
