<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route("/accueil", name: "app_accueil", methods: ["get"])]
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

        return $this->render("accueil/accueil.html.twig", [
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
        return $this->render("accueil/accueil.html.twig", [
            "quizs" => $quizs,
            "isUser" => true,
            "titre" => "Tous les tickets",
        ]);
    }
}
