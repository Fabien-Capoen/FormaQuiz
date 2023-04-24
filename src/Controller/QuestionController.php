<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/question/create/{id}', name: 'app_question_create')]
    public function index(
        EntityManagerInterface $manager,
        Request $request,
        Quiz $currentQuiz,
    ): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){
            $question->setQuiz($currentQuiz);
            $manager->persist($question);
            $manager->flush();

            return $this->redirectToRoute('app_quiz_suivi', ['id'=>$question->getQuiz()->getId()]);
        }

        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController', "form"=>$form,
        ]);
    }

}
