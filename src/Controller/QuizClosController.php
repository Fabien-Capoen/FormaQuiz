<?php

namespace App\Controller;

use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizClosController extends AbstractController
{
    #[Route('/quiz/clos', name: 'app_quiz_clos')]
    public function index(EntityManagerInterface $manager): Response
    {
        if ($this->isGranted ('ROLE_PROF')){
            return $this->accueilProf($manager);
        } elseif ($this->isGranted ('ROLE_ELEVE')) {
            return $this->accueilEleve($manager);
        }
        return new RedirectResponse($this->generateUrl("app_login"));
    }

    private function accueilProf(EntityManagerInterface $manager): Response
    {
        $quizs = $manager->getRepository(Quiz::class)->findAllQuizs();
        return $this->render("quiz_clos/QuizClos.twig", [
            "quizs" => $quizs["results"],
            "isUser" => true,
            "titre" => "Tous les tickets",
        ]);
    }

    private function accueilEleve(): Response
    {
        $currentUser = $this->getUser();
        $formation = $currentUser->getFormation();
        $quizs = $formation->getQuiz();
        return $this->render("quiz_clos/QuizClos.twig", [
            "quizs" => $quizs,
            "isUser" => true,
            "titre" => "Tous les tickets",
        ]);
    }
}
