<?php
// src/Controller/BraceletController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse; // Importer la classe RedirectResponse
use App\Entity\Bracelet;
use App\Form\BraceletType;

class BraceletController extends AbstractController
{
    #[Route('/bracelet', name: 'app_bracelet')]
    public function index(Request $request): Response
    {
        // Création d'un nouvel objet Bracelet
        $bracelet = new Bracelet();

        // Génération du code d'identification unique
        $identificationCode = uniqid();
        $bracelet->setIdentificationCode($identificationCode);

        // Récupération des autres données à partir de la base de données
        $entityManager = $this->getDoctrine()->getManager();
        // Exemple : récupération de la température à partir de la base de données
        $temperature = $entityManager->getRepository(Bracelet::class)->findTemperature();
        $bracelet->setTemperature($temperature);

        // Exemple : récupération de la pression artérielle à partir de la base de données
        $bloodPressure = $entityManager->getRepository(Bracelet::class)->findBloodPressure();
        $bracelet->setBloodPressure($bloodPressure);

        // Exemple : récupération de la fréquence cardiaque à partir de la base de données
        $heartRate = $entityManager->getRepository(Bracelet::class)->findHeartRate();
        $bracelet->setHeartRate($heartRate);

        // Exemple : récupération du mouvement à partir de la base de données
        $movement = $entityManager->getRepository(Bracelet::class)->findMovement();
        $bracelet->setMovement($movement);

        $latitude = $entityManager->getRepository(Bracelet::class)->findGps();
        $bracelet->setlatitude($latitude);

          
          $longitude = $entityManager->getRepository(Bracelet::class)->findGps();
          $bracelet->setlongitude($longitude);

          $gps = $entityManager->getRepository(Bracelet::class)->findGps();
          $bracelet->setGps($longitude);


        // Création du formulaire et liaison avec l'objet Bracelet
        $form = $this->createForm(BraceletType::class, $bracelet);

        // Gestion de la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement du formulaire (sauvegarde en base de données, etc.)
            // ...

            /// Redirection vers le tableau de bord du propriétaire avec les données du bracelet
            $url = $this->generateUrl('app_owner_dashboard', [
                // Passer le code d'identification à travers la redirection
                'identificationCode' => $identificationCode,
            ]);
            return new RedirectResponse($url);
        }
    

        // Affichage du formulaire dans le template
        return $this->render('bracelet/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
