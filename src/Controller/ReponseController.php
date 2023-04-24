<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\User;
use App\Form\QCMReponseType;
use App\Form\QCRReponseType;
use App\Trait\QuizSuiviTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    use QuizSuiviTrait;
    #[Route('/reponse/qcm/create/{id}', name: 'app_reponse_QCM_create')]
    public function qcmReponse(
        EntityManagerInterface $manager,
        Request $request,
        Question $currentQuestion,
    ): Response
    {
        $qcmReponse = new Reponse();
        $qcmReponse->setQuestion($currentQuestion);
        $currentUser = $this->getUser();
        $form = $this->createForm(QCMReponseType::class, $qcmReponse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $qcmReponse->setUser($currentUser);
            $manager->persist($qcmReponse);
            $manager->flush();

            return $this->render('provisoire/provisoire.html.twig');
        }

        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController', "form"=>$form,
            'question'=> $currentQuestion,
            'user'=>$currentUser,
        ]);
    }

    #[Route('/reponse/qcr/create', name: 'app_reponse_QCR_create')]
    public function qcrReponse(
        EntityManagerInterface $manager,
        Request $request,
    ): Response
    {

        $qcrReponse = new Reponse();
        $form = $this->createForm(\QCRReponseType::class, $qcrReponse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($qcrReponse);
            $manager->flush();

            return $this->render('provisoire/provisoire.html.twig');
        }

        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController', "form"=>$form,
        ]);
    }
}
