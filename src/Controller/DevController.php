<?php

namespace App\Controller;

use App\Entity\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DevController extends AbstractController
{
    #[Route('/dev/type/create', name: 'app_dev_type_create')]
    public function index(
        EntityManagerInterface $entityManager,
    ): Response{
        $questionType = new QuestionType();
        $questionType
            ->setLibelle("QCR");
        $entityManager->persist($questionType);
        $entityManager->flush();

        return new Response();
    }
}
