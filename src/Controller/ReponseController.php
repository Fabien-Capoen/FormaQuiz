<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Form\QCMReponseType;
use App\Form\QCRReponseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    #[Route('/reponse/qcm/create', name: 'app_reponse_QCM_create')]
    public function qcmReponse(
        EntityManagerInterface $manager,
        Request $request,
    ): Response
    {
        $qcmReponse = new Reponse();
        $form = $this->createForm(QCMReponseType::class, $qcmReponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($qcmReponse);
            $manager->flush();

            return $this->render('provisoire/provisoire.html.twig');
        }

        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController', "form"=>$form,
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
