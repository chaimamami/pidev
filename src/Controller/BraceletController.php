<?php

// src/Controller/BraceletController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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

        // Exemple : récupération du GPS à partir de la base de données
        $gps = $entityManager->getRepository(Bracelet::class)->findGps();
        $bracelet->setGps($gps);

        // Création du formulaire et liaison avec l'objet Bracelet
        $form = $this->createForm(BraceletType::class, $bracelet);

        // Gestion de la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement du formulaire (sauvegarde en base de données, etc.)
            // ...
        }

        // Affichage du formulaire dans le template
        return $this->render('bracelet/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
