<?php

namespace App\Controller;
use App\Entity\Copie;
use App\Entity\Quiz;
use App\Trait\CopieCorrection;
use App\Trait\QuizSuiviTrait;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CopieCorrectionController extends AbstractController
{
    use QuizSuiviTrait;
    #[Route('/copie/correction/{id}', name: 'app_copie_correction')]
    public function CopieCorrection(Copie $copie): Response
    {
        $currentUser = $this->getUser();

        // Nous voulons vérifier si l'utilisateur courant est en capacité d'intéragir avec le Quiz.
        $isAllowed =
            $copie->getQuiz()->getQuestions() === $currentUser ||
            $this->isGranted("ROLE_ELEVE") ||
            $this->isGranted("ROLE_PROF") ||
            $currentUser->getFormation() === $copie->getQuiz()->getFormation();

        if (!$isAllowed) {
            throw $this->createAccessDeniedException();
        }
/*       sert à afficher le résultat d'un array
         $copie->getReponses()->toArray()
        die;
         */



        return $this->render("copie_correction/CopieCorrection.html.twig", [
            "controller_name"=> "Correction de la copie",
            "questions" => $copie->getQuiz()->getQuestions(),
//            "objects" => $objects,
            "isAllowed" => $isAllowed,
            "reponses" => $copie->getReponses(),
            "copie" => $copie,
            "quizNoteMax" => $copie->getQuiz()->getNoteMax(),
        ]);
    }

    #[Route('/copie/correction/flush/{id}', name: 'app_copie_correction_flush')]
    public function CopieCorrectionFlush(Copie $copie, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        $currentUser = $this->getUser();
        $copie->getId();
        $request->getContent();
        dd($request);

    }
}
