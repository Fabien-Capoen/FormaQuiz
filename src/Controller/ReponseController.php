<?php

namespace App\Controller;

use App\Entity\Copie;
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

/** on récpuère toutes les fonctions d'AbstractController et on les associes à ReponseController,
 Exemple : $this->getUser()
 */
class ReponseController extends AbstractController
{
    use QuizSuiviTrait;
    #[Route('/reponse/qcm/create/{id}', name: 'app_reponse_QCM_create')]
    public function qcmReponse(
        EntityManagerInterface $manager,   // permet de faire le lien avec l'entité et la  la bdd
        Request $request,                  // permet au code d'accéder à la requête
        Question $currentQuestion          // on récupère le paramètre {id} et on l'associe à $currentquestion
    ): Response
    {
        $currentUser = $this->getUser();
        $qcmReponse = $manager->getRepository(Reponse::class)->findOneBy(['user'=>$currentUser,'question'=>$currentQuestion]);

        if (null === $qcmReponse)
        {
            $copie = $manager->getRepository(Copie::class)->findOneBy(['quiz'=>$currentQuestion->getQuiz(), 'user'=>$currentUser]);
            $qcmReponse = new Reponse();
            $qcmReponse->setQuestion($currentQuestion);
            $qcmReponse->setUser($currentUser);
            $qcmReponse->setCopie($copie);
        }

        $form = $this->createForm(QCMReponseType::class, $qcmReponse);
        /** permet au formulaire de traiter les requêtes reçues,
         * sans ça le formulaire ne pourrait jamais traiter les requêtes envoyées depuis le front quand on appuie sur "envoyer"
         * ici le formulaire peut alors vérifier les conditions "isValid" et "isSubmitted"
         */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($qcmReponse);
            $manager->flush();
            return $this->redirectToRoute('app_quiz_suivi', ['id'=>$currentQuestion->getQuiz()->getId()]);
        }

        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController', "form"=>$form,
            'question'=> $currentQuestion,
            'user'=>$currentUser,
        ]);
    }

    #[Route('/reponse/qcr/create/{id}', name: 'app_reponse_QCR_create')]
    public function qcrReponse(
        EntityManagerInterface $manager,
        Request $request,
        Question $currentQuestion,

    ): Response
    {
        $currentUser = $this->getUser();
        $qcrReponse = $manager->getRepository(Reponse::class)->findOneBy(['user'=>$currentUser,'question'=>$currentQuestion]);

        if(null === $qcrReponse){
            $qcrReponse = new Reponse();
            $qcrReponse->setQuestion($currentQuestion);
            $qcrReponse->setUser($currentUser);

        }

        $form = $this->createForm(\QCRReponseType::class, $qcrReponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($qcrReponse);
            $manager->flush();

            return $this->redirectToRoute('app_quiz_suivi', ['id'=>$currentQuestion->getQuiz()->getId()]);
        }

        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController', "form"=>$form,
            'question'=> $currentQuestion,
            'user'=>$currentUser,
        ]);
    }
}
