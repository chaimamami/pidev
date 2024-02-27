<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

class OwnerController extends AbstractController
{
    
        #[Route('/owner', name: 'app_owner_dashboard')] // Correction du chemin de la route
        public function index(): Response
        {
            return $this->render('owner/app_owner_dashboard.html.twig', [
                'controller_name' => 'OwnerController',
            ]);
        }
    

}
