<?php

namespace App\Controller;

use App\Entity\Codepromo;
use App\Form\CodepromoType;
use App\Repository\CodepromoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CodepromoController extends AbstractController
{
    /**
     * @Route("/codepromo", name="codepromo")
     */


    /**
     * @param CodepromoRepository $repo
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/codepromo", name="affichage")
     */
    public function afficher(CodepromoRepository $repo){
      //  $repo=$this->getDoctrine()->getRepository(Codepromo::class);
        $codepromo=$repo->findAll();
        return $this->render('codepromo/codepromo.html.twig',['codepromo'=>$codepromo]);
    }
    /**
     * @Route("/Supp/{id}",name="d")
     */
    public function Delete($id, CodepromoRepository $repository){
        $codepromo=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($codepromo);
        $em->flush();
        return $this->redirectToRoute('affichage');

    }

    /**
     * @param Request $req
     * @return Response
     * @Route ("/add",name="add")
     */
    public function add(Request $req)
    {
        $codep= new Codepromo();
        $form=$this->createForm(CodepromoType::class,$codep);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($codep);
            $em->flush();
            return $this->redirectToRoute('affichage');
        }
            return $this->render('codepromo/add.html.twig',[
            'form'=>$form->createView()
            ]);

    }

    /**
     * @param CodepromoRepository $rep
     * @Route ("/upd/{id}" , name="m")
     */
    public function update(CodepromoRepository $rep,$id,Request $req){
        $codepromo=$rep->find($id);
        $form=$this->createForm(CodepromoType::class,$codepromo);
        $form->add('Mettre a jour',SubmitType::class);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affichage');
        }
        return $this->render('codepromo/update.html.twig',[
            'f'=>$form->createView()
        ]);
    }
}
