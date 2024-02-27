<?php
// src/Controller/OwnerController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Bracelet;

class OwnerController extends AbstractController
{
    #[Route('/owner', name: 'app_owner_dashboard')]
    public function index(Request $request): Response
    {
        // Récupérer les données du bracelet depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $braceletRepository = $entityManager->getRepository(Bracelet::class);
        $braceletData = $braceletRepository->findAll(); // Ou utilisez une méthode spécifique pour récupérer les données

         // Génération du code d'accès
         $code = uniqid();

         // Stockage du code d'accès en session pour vérification ultérieure
         $request->getSession()->set('access_code', $code);

        // Traitement des données saisies par l'utilisateur
        $formData = [];
        if ($request->isMethod('POST')) {
            $formData['firstName'] = $request->request->get('firstName');
            $formData['lastName'] = $request->request->get('lastName');
            $formData['email'] = $request->request->get('email');
            $formData['phone'] = $request->request->get('phone');
        }

        return $this->render('owner/app_owner_dashboard.html.twig', [
            'braceletData' => $braceletData,
            'code' => $code,
            'formData' => $formData, // Passer les données du formulaire au modèle Twig
        ]);
        
    }
}
