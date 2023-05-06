<?php

namespace App\Controller;

use App\Entity\Copie;
use App\Entity\Quiz;
use App\Entity\User;
use App\Form\CopieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CopieController extends AbstractController
{
    /** Controller pour la création de la copie */
    #[Route('/dev/copie', name: 'app_copie')]
    public function copie(
        EntityManagerInterface $manager,
        Request $request,
    ): Response{
        $form = $this->createForm(CopieType::class, $copie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($copie);
            $manager->flush();

            return $this->render('provisoire/provisoire.html.twig');
        }

        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController', "form"=>$form,
        ]);
    }

    #[Route('/copie/create/{id}', name: 'app_copie_create')]
    public function createCopie(
        EntityManagerInterface $manager,
        Quiz $currentQuiz
    ): Response
    {
        $currentUser = $this->getUser();
        /** On vérifie si il existe déjà une copie de l'utilisateur pour le quiz,
         *Si le if nous renvoie Null ( donc n'existe pas ) on créé la copie
         *Si le if nous renvoie autre chose que null ( donc elle existe ) on ne créé pas la copie
         */
        if ($this->isGranted ('ROLE_ELEVE')) {

            if (null === $manager->getRepository(Copie::class)->findOneBy(['user' => $currentUser, 'quiz' => $currentQuiz])) {
                $copie = new Copie();
                $copie->setUser($currentUser);
                $copie->setQuiz($currentQuiz);

                $manager->persist($copie);
                $manager->flush();
            }

        }
        return $this->redirectToRoute('app_quiz_suivi', ['id' => $currentQuiz->getId()]);
    }
}
