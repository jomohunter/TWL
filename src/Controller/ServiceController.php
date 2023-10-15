<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service/{idddd}', name: 'app_service')]
    public function index($idddd): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
            'name' => "$idddd"
        ]);
    }

    #[Route('/goToIndex', name: 'goToIndex')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('app_student');
    }

}
