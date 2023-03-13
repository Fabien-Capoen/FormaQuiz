<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Form\FormTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    use FormTrait;
    #[Route('/user/create', name: 'app_user_create')]   // dd('bonjour'); --> la commande dd permet d'afficher un résultat et arrête le controller.
    public function index(
        EntityManagerInterface $manager,
		Request $request,
		UserPasswordHasherInterface $hasher
        ): Response{
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if (
                    $form->get("password")->getData() !==
                    $form->get("confirmation")->getData()
                ) {
                    $form
                        ->get("password")
                        ->addError(new FormError("les 2 mdp ne sont pas identiques"));
                }
                if ($this->checkExistingUser($manager, $form->get("email"))) {
                    $form
                        ->get("email")
                       ->addError(new FormError("Cet email est déjà prise."));
                }
                if ($this->checkErrors($form->all())) {
                    return $this->render("critical error", [
                        "form" => $form,
                    ]);
                }

                $user->setPassword(
                    $hasher->hashPassword($user, $form->get("password")->getData())
                );
                $manager->persist($user);
                $manager->flush();

                return $this->render('user/index.html.twig', [
                    'controller_name' =>'UserController', "form"=>$form,
                ]);// redirectToRoute("app_ticket_create");
            }

            return $this->render('user/index.html.twig', [
            'controller_name' =>'UserController', "form"=>$form,
            ]);
        }
}
