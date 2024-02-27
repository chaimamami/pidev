<?php
// HealthProfessionalController.php

namespace App\Controller;

use App\Form\DashboardTypeFormType; // Importer la classe DashboardTypeFormType
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HealthProfessionalController extends AbstractController
{
    #[Route('/healthprofessional/dashboard', name: 'app_health_professional_dashboard')]
    public function dashboard(): Response
    {
        // Rediriger vers la page de sélection du type de tableau de bord
        return $this->redirectToRoute('app_choose_dashboard_type');
    }

    #[Route('/healthprofessional/doctor-dashboard', name: 'app_health_professional_doctor_dashboard')]
    public function doctorDashboard(): Response
    {
        // Logique pour le tableau de bord du médecin
        return $this->render('health_professional/doctor_dashboard.html.twig');
    }

    #[Route('/healthprofessional/emergency-dashboard', name: 'app_health_professional_emergency_dashboard')]
    public function emergencyDashboard(): Response
    {
        // Logique pour le tableau de bord de l'équipe d'urgence
        return $this->render('health_professional/emergency_dashboard.html.twig');
    }

    #[Route('/choose-dashboard-type', name: 'app_choose_dashboard_type')]
    public function chooseDashboardType(Request $request): Response
    {
        $form = $this->createForm(DashboardTypeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dashboardType = $form->get('dashboardType')->getData();

            if ($dashboardType === 'doctor') {
                return $this->redirectToRoute('app_health_professional_doctor_dashboard');
            } elseif ($dashboardType === 'emergency') {
                return $this->redirectToRoute('app_health_professional_emergency_dashboard');
            }
        }

        return $this->render('health_professional/choose_dashboard_type.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
