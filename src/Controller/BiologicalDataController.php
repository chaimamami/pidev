<?php

namespace App\Controller;

use App\Entity\BiologicalData;
use App\Entity\Bracelet; // Importer la classe Bracelet
use App\Form\BiologicalDataType;
use App\Repository\BiologicalDataRepository;
use App\Repository\BraceletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/biologicaldata')]
class BiologicalDataController extends AbstractController
{
    #[Route('/', name: 'app_biological_data_index', methods: ['GET'])]
    public function index(BiologicalDataRepository $biologicalDataRepository): Response
    {
        // Récupérer les données biologiques liées au patient (owner)
        $user = $this->getUser();
        $biologicalDatas = [];
        if ($user && in_array('ROLE_OWNER', $user->getRoles())) {
            $biologicalDatas = $biologicalDataRepository->findBy(['patient' => $user]);
        } elseif ($user && in_array('ROLE_HEALTH_PROFESSIONAL', $user->getRoles())) {
            // Si l'utilisateur est un professionnel de la santé,
            // Récupérer toutes les données biologiques
            $biologicalDatas = $biologicalDataRepository->findAll();
        }

        return $this->render('biological_data/index.html.twig', [
            'biological_datas' => $biologicalDatas,
        ]);
    }

    #[Route('/new', name: 'app_biological_data_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $biologicalDatum = new BiologicalData();
        $form = $this->createForm(BiologicalDataType::class, $biologicalDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ajouter les données du formulaire à l'entité BiologicalData
            $entityManager->persist($biologicalDatum);
            
            // Ajouter les médicaments
            foreach ($biologicalDatum->getMedication() as $medication) {
                $medication->setBiologicalData($biologicalDatum);
                $entityManager->persist($medication);
            }
            
            $entityManager->flush();

            // Rediriger vers la page de détails de la nouvelle donnée biologique
            return $this->redirectToRoute('app_biological_data_show', ['id' => $biologicalDatum->getId()]);
        }

        return $this->render('biological_data/new.html.twig', [
            'biological_datum' => $biologicalDatum,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_biological_data_show', methods: ['GET'])]
public function show(BiologicalData $biologicalDatum, BraceletRepository $braceletRepository): Response
{
    // Récupérer les données du bracelet associé à la donnée biologique
    $bracelet = $braceletRepository->findOneBy(['biologicalData' => $biologicalDatum]);

    return $this->render('biological_data/show.html.twig', [
        'biological_datum' => $biologicalDatum,
        'bracelet_data' => $bracelet, // Passer les données du bracelet à la vue
    ]);
}

    #[Route('/{id}/edit', name: 'app_biological_data_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BiologicalData $biologicalDatum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BiologicalDataType::class, $biologicalDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_biological_data_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('biological_data/edit.html.twig', [
            'biological_datum' => $biologicalDatum,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_biological_data_delete', methods: ['POST'])]
    public function delete(Request $request, BiologicalData $biologicalDatum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$biologicalDatum->getId(), $request->request->get('_token'))) {
            $entityManager->remove($biologicalDatum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_biological_data_index', [], Response::HTTP_SEE_OTHER);
    }
}
