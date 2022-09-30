<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(EmployeRepository $repo): Response
    {
        $employe = $repo->findAll();
        return $this->render('entreprise/index.html.twig', [
            'employes' => $employe,
        ]);
    }
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('entreprise/home.html.twig',[
            'slogan' => " Votre tableau de bord Employés",
            
        ]);
    }
    
    
    #[Route('/employe/liste', name: 'employe_liste')]
    public function liste(EmployeRepository $repo)
    {
        $employe = $repo->findall();   
        return $this->render('entreprise/liste.html.twig',[
            'employes'=>$employe,       
        ]);
    }
    #[Route('/employe/new', name: 'employe_new')]
    #[Route('/employe/edit/{id}', name: 'employe_edit')]

    public function form(EntityManagerInterface $manager, Request $globals, Employe $employe= null)
    {
        if($employe == null)
        {
            $employe = new Employe;  
            
        }
                
        $form= $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($globals);
        
            if ($form->isSubmitted() && $form->isValid())
            {
                $manager->persist($employe); 
                $manager->flush(); 
                return $this->redirectToRoute('employe_liste', [
                    'id'=> $employe->getId()
                ]);
            }

        return $this->renderForm("entreprise/form.html.twig",[
            'formEmploye' => $form,
            'editMode' => $employe->getId() !== null
            ]);
    }
    #[Route('/employe/delete/{id}', name: 'employe_delete')]

    public function delete(Employe $employe, EntityManagerInterface $manager)
    {
        $manager->remove($employe);
        $manager->flush();

        return $this->redirectToRoute('employe_liste');
    }
    
}
