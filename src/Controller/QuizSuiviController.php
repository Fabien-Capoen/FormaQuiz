<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Trait\QuizSuiviTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizSuiviController extends AbstractController
{
    use QuizSuiviTrait;
    #[Route('/quiz/suivi/{id}', name: 'app_quiz_suivi')]
    public function suivi(Quiz $quiz): Response
    {

        $currentUser = $this->getUser();

        // Nous voulons vérifier si l'utilisateur courant est en capacité d'intéragir avec le ticket.
        $isAllowed =
            $quiz->getQuestions() === $currentUser ||
            $this->isGranted("ROLE_ELEVE") ||
            $this->isGranted("ROLE_PROF") ||
            $currentUser->getFormation() === $quiz->getFormation();

        if (!$isAllowed) {
            throw $this->createAccessDeniedException();
        }

        $objects = $this->getQuizSuivi($quiz);
        return $this->render("quiz_suivi/index.html.twig", [
            "quiz" => $quiz,
//            "objects" => $objects,
            "isAllowed" => $isAllowed,
        ]);
    }
}
