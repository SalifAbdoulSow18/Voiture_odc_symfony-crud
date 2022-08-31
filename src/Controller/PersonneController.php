<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonneController extends AbstractController
{
    /**
     * @Route("/personne", name="personne")
     */
    public function index(PersonneRepository $personneRepository): Response
    {
        $personnes = $personneRepository->findAll();
        return $this->render('personne/index.html.twig', compact('personnes'));
    }

    /**
     * @Route("/personne/create", name="personne_create")
     */
    public function create( Request $request, EntityManagerInterface $em): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class,$personne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute('personne');
        }
        
        return $this->render('personne/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/personne/{id<[0-9]+>}/update", name="personne_update")
     */
    public function update( Request $request, EntityManagerInterface $em, Personne $personne): Response
    {
        $form = $this->createForm(PersonneType::class,$personne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$em->persist($personne);
            $em->flush();
            return $this->redirectToRoute('personne');
        }
        
        return $this->render('personne/create.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/personne/{id<[0-9]+>}/delete", name="personne_delete")
     */
    public function delete(EntityManagerInterface $em, Personne $personne): Response
    {
       $em->remove($personne);
       $em->flush();
       return $this->redirectToRoute('personne');
    }
}
