<?php

namespace App\Controller;

use App\Entity\Copie;
use App\Entity\Formation;
use App\Entity\QuestionType;
use App\Entity\Quiz;
use App\Entity\Status;
use App\Form\CopieType;
use App\Form\QuizType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DevController extends AbstractController
{
    #[Route('/dev/questiontype/create', name: 'app_dev_type_create')]
    public function index(
        EntityManagerInterface $entityManager,
    ): Response{
        $questionType = new QuestionType();
        $questionType
            ->setLibelle("QCM");
        $entityManager->persist($questionType);
        $entityManager->flush();

        return $this->render('provisoire/provisoire.html.twig');
    }
    #[Route('/dev/status/create', name: 'app_dev_status_create')]
    public function Status(
        EntityManagerInterface $entityManager,
    ): Response{
        $status = new Status();
        $status
            ->setLibelle("Clos");
        $entityManager->persist($status);
        $entityManager->flush();

        return $this->render('provisoire/provisoire.html.twig');
    }

    #[Route('/dev/formation/create', name: 'app_dev_formation_create')]
    public function Formation(
        EntityManagerInterface $entityManager,
    ): Response{
        $formation = new Formation();
        $formation
            ->setLibelle("BTS SIO");
        $entityManager->persist($formation);
        $entityManager->flush();

        return $this->render('provisoire/provisoire.html.twig');
    }


    #[Route('/dev/quiz/create', name: 'app_dev_quiz_create')]
    public function quiz(
        EntityManagerInterface $manager,
        Request $request,
    ): Response{
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);
        $currentUser = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()){
            $quiz->setUser($currentUser);
            $manager->persist($quiz);
            $manager->flush();

            return $this->redirectToRoute('app_quiz_suivi', ['id'=>$quiz->getId() ]);
        }

        return $this->render('quiz/index.html.twig', [
            'controller_name' => "Création d'un quiz", "form"=>$form,
        ]);
    }
}
