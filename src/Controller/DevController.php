<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\QuestionType;
use App\Entity\Status;
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
    #[Route('/dev/status/create', name: 'app_dev_status_create')]
    public function Status(
        EntityManagerInterface $entityManager,
    ): Response{
        $status = new Status();
        $status
            ->setLibelle("Corrigé");
        $entityManager->persist($status);
        $entityManager->flush();

        return new Response();
    }

    #[Route('/dev/formation/create', name: 'app_dev_formation_create')]
    public function Formation(
        EntityManagerInterface $entityManager,
    ): Response{
        $formation = new Formation();
        $formation
            ->setLibelle("BTS IMMO");
        $entityManager->persist($formation);
        $entityManager->flush();

        return new Response();
    }
}
