<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FamilyMemberController extends AbstractController
{
    #[Route('/familymember', name: 'app_family_member_dashboard')] // Correction du chemin de la route
    public function index(): Response
    {
        return $this->render('family_member/app_family_member_dashboard.twig', [
            'controller_name' => 'FamilyMemberController',
        ]);
    }
}
