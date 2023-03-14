<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/question/create', name: 'app_question_create')]
    public function index(
        EntityManagerInterface $manager,
        Request $request,
    ): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($question);
            $manager->flush();

            return $this->render('provisoire/provisoire.html.twig');
        }

        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController', "form"=>$form,
        ]);
    }
}
