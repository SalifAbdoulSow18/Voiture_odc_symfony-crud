<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoiureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoitureController extends AbstractController
{
    /**
     * @Route("/voiture", name="voiture")
     */
    public function index(VoitureRepository $voitureRepository): Response
    {
        $voitures = $voitureRepository->findAll();
        return $this->render('voiture/index.html.twig', compact('voitures'));
    }

    /**
     * @Route("/voiture/create", name="voiture_create")
     */
    public function create( Request $request, EntityManagerInterface $em): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoiureType::class,$voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('voiture');
        }
        
        return $this->render('voiture/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
