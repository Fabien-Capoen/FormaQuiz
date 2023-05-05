<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Trait\CopiesDuQuizTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CopiesDuQuizController extends AbstractController
{
    use CopiesDuQuizTrait;
    #[Route('/copies/du/quiz/{id}', name: 'app_copies_du_quiz')]
    public function CopieDuQuiz(Quiz $quiz): Response
    {
        $currentUser = $this->getUser();

        // Nous voulons vérifier si l'utilisateur courant est en capacité d'intéragir avec le Quiz.
        $isAllowed =
            $quiz->getCopies() === $currentUser ||
            $this->isGranted("ROLE_ELEVE") ||
            $this->isGranted("ROLE_PROF") ||
            $currentUser->getFormation() === $quiz->getFormation();

        if (!$isAllowed) {
            throw $this->createAccessDeniedException();
        }

        $objects = $this->getCopiesDuQuiz($quiz);
        return $this->render("copies_du_quiz/CopiesDuQuiz.twig", [
            "controller_name"=>"Copies du quiz",
            "quiz" => $quiz,
//            "objects" => $objects,
            "isAllowed" => $isAllowed,
        ]);
    }
}
