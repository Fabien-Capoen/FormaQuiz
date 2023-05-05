<?php

namespace App\Trait;

use App\Entity\Quiz;
use Doctrine\Common\Collections\Collection;

trait CopiesDuQuizTrait
{
    public function getCopiesDuQuiz(Quiz $quiz): array {
        // Nous récupérons les questions correspondant au Quiz
        $copies = $quiz->getCopies();

        $elementsSuivi = array_merge(
            $copies->toArray()
        );
        return $elementsSuivi;
    }
}