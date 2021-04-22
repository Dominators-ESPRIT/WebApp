<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Entity\Panier;
use App\Manager\panierManager;
use App\Repository\OeuvreRepository;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OeuvreController extends AbstractController
{
    /**
     * @param OeuvreRepository $repo
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/oeuvre", name="showoeuv")
     */
    public function afficher(OeuvreRepository $repo,panierManager $panierManager){
        $panier=$panierManager->getCurrentPanier();
        $panierManager->save($panier);
        $oeuvre=$repo->findAll();
        return $this->render('oeuvre/oeuvre.html.twig',['oeuvre'=>$oeuvre,'panier'=>$panier]);
    }
    /**
     * @Route("/addtocart/{id}",name="addtocart")
     */
    public function ajouter($id, OeuvreRepository $repository,panierManager $panierManager){
       $panier=$panierManager->getCurrentPanier();
        $etat=$panier->getEtat();
        if($etat==1) {
            $panierManager->save($panier);
            $em1 = $this->getDoctrine()->getManager();
            $em1->persist($panier);

        }elseif($etat==0) {
            $panier = new Panier();
            $em1 = $this->getDoctrine()->getManager();
            $em1->persist($panier);
        }
        $panier->setEtat(1);
        $oeuvre=$repository->find($id);
        $panierManager->save($panier);

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Oeuvre::class)->find($oeuvre);
        $product->setIdPanier($panier);
        $em->flush();
        return $this->redirectToRoute('showoeuv',['panier'=>$panier]);

    }
}
