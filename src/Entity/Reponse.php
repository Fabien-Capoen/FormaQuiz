<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    private ?Question $question = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    private ?Copie $copie = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $annotation = null;

    #[ORM\Column(nullable: true)]
    private ?float $note = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reponse = null;

    #[ORM\Column(nullable: true)]
    private ?bool $choixrep1 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $choixrep2 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $choixrep3 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $choixrep4 = null;

    #[ORM\ManyToOne(inversedBy: 'qcm_reponse')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getCopie(): ?Copie
    {
        return $this->copie;
    }

    public function setCopie(?Copie $copie): self
    {
        $this->copie = $copie;

        return $this;
    }


    public function getAnnotation(): ?string
    {
        return $this->annotation;
    }

    public function setAnnotation(?string $annotation): self
    {
        $this->annotation = $annotation;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function isChoixrep1(): ?bool
    {
        return $this->choixrep1;
    }

    public function setChoixrep1(bool $choixrep1): self
    {
        $this->choixrep1 = $choixrep1;

        return $this;
    }

    public function isChoixrep2(): ?bool
    {
        return $this->choixrep2;
    }

    public function setChoixrep2(bool $choixrep2): self
    {
        $this->choixrep2 = $choixrep2;

        return $this;
    }

    public function isChoixrep3(): ?bool
    {
        return $this->choixrep3;
    }

    public function setChoixrep3(bool $choixrep3): self
    {
        $this->choixrep3 = $choixrep3;

        return $this;
    }

    public function isChoixrep4(): ?bool
    {
        return $this->choixrep4;
    }

    public function setChoixrep4(bool $choixrep4): self
    {
        $this->choixrep4 = $choixrep4;

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
