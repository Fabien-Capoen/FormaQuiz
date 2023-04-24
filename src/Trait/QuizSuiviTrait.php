<?php

namespace App\Trait;

use App\Entity\Quiz;
use Doctrine\Common\Collections\Collection;

trait QuizSuiviTrait
{
    public function getQuizSuivi(Quiz $quiz): array {
        // Nous récupérons les questions correspondant au Quiz
        $questions = $quiz->getQuestions();

        $elementsSuivi = array_merge(
            $questions->toArray()
        );
        return $elementsSuivi;
    }
}