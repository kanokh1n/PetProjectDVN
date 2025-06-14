<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResgistrationController extends AbstractController
{
    #[Route('/resgistration', name: 'app_resgistration')]
    public function index(): Response
    {
        return $this->render('resgistration/index.html.twig', [
            'controller_name' => 'ResgistrationController',
        ]);
    }
}
