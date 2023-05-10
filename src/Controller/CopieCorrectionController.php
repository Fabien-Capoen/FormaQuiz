<?php

namespace App\Controller;
use App\Entity\Copie;
use App\Entity\Quiz;
use App\Entity\Reponse;
use App\Trait\CopieCorrection;
use App\Trait\QuizSuiviTrait;
use Doctrine\ORM\EntityManagerInterface;
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
            "quiz" => $copie->getQuiz(),
            "quizNoteMax" => $copie->getQuiz()->getNoteMax(),
        ]);
    }

    #[Route('/copie/correction/flush/{id}', name: 'app_copie_correction_flush')]
    public function CopieCorrectionFlush(Copie $copie,EntityManagerInterface $manager, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        $reponses=$copie->getReponses();
        // on récupère la donnée qui a la clé "annotation-copie" dans la requête et on l'enregistre dans annotation copie
        $annotationCopie = $request->get('annotation-copie');
        $copie->setAnnotation($annotationCopie);
        // on récupère la donnée qui a la clé "annotation-note" dans la requête et on la pour dans annotation copie
        $noteCopie = $request->get('note-copie');
        $copie->setNote($noteCopie);

        // on boucle sur la requête sous forme de tableau, avec $key= "le nom du champ de formulaire" et value= "sa valeur"
        foreach ($request->request->all() as $key=>$value){
            // si la clé est différente de "annotation-copie" et "note-copie"
            if($key !== "annotation-copie" && $key !== "note-copie"){

                // on décompose la chaine de caractère de la clé avec le "-"  comme élément séparateur
                $explode=explode( "-", $key );
                //on cherche la 1ère réponse qui à l'ID = à $explode[1]
                $reponse = $reponses->findFirst(function(int $index, Reponse $reponse) use($explode): bool {
                    return $reponse->getId() == $explode[1];
                });
                // on vérifie que $explode[0] = à "annotation" avant d'envoyer  la valeur dans la table annotation
                if ("annotation" == $explode[0]){
                    $reponse->setAnnotation($value);
                }
                // on vérifie que $explode[0] = à "note" avant d'envoyer  la valeur dans la table annotation
                elseif("note"== $explode[0]){
                    $reponse->setNote($value);
                }
            }
        }
        $manager->flush();
        return $this->redirectToRoute('app_copies_du_quiz', ['id'=>$copie->getQuiz()->getId()]);
    }
}
