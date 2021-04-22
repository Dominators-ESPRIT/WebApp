<?php

namespace App\Controller;

use App\Entity\Codepromo;
use App\Entity\Oeuvre;
use App\Entity\Panier;
use App\Form\PanierType;
use App\Manager\panierManager;
use App\Repository\CodepromoRepository;
use App\Repository\OeuvreRepository;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PanierController extends AbstractController
{
    /**
     * @Route("/panier",name="showcart")
     * @return Response
     */
    public function afficher(OeuvreRepository $repo, panierManager $panierManager,CodepromoRepository $reposit,Request $request){
        $inputcode=null;
        $liv=$request->query->get('liv');
        $frais=0.0;
        if($liv=="stand")
                $frais=7.0;
        else if($liv=="exp")
                $frais=15.0;
        $panier=$panierManager->getCurrentPanier();
        $panierManager->save($panier);
        $id=$panier->getIdPanier();
        $pan=$repo->findBy(array('id_panier' => $id ));
        $etat=$panier->getEtat();
        $code=$request->get('code');
        $codepromo=$reposit->findAll();
        $x=2;
        $valeur=0;
        $existe=false;
        if ($code=="") {
            $x=3;
        } else{
            foreach($codepromo as $i=>$v) {
                if($code==$v->getLabel()){
                    $x=1;
                    $existe=true;
                   // $valeur=$v->getValeur();
                    $idcode=$v->getId();
                    $em = $this->getDoctrine()->getManager();
                    $paa = $em->getRepository(Panier::class)->find($id);
                    $paa->setIdCodepromo($idcode);
                    $em->flush();

                }

            }
        }


        $idcoode=$panier->getIdCodepromo();

        $emm = $this->getDoctrine()->getManager();
        if($code!="" && $existe==true){
        $coode=$emm->getRepository(Codepromo::class)->find($idcoode);
        $valeur=$coode->getValeur();}



        $total=0.0; $stotal=0.0;
        if ($etat==1){

                $i=0;
               foreach($pan as $i=>$value){
                    $stotal+=$value->getPrix();
                }
                $total=(100-$valeur)*$stotal/100+$frais;
            $tot=$total;
            $total-$frais;

               return $this->render('panier/show.html.twig',['pan'=>$pan,'stotal'=>$stotal,'total'=>$tot,'x'=>$x,'valeur'=>$valeur]);
            }else{
            return $this->render('panier/show.html.twig',['pan'=>null,'stotal'=>null,'total'=> null ,'x'=>$x,'valeur'=>null]);}
    }

    /**
     * @Route ("/delete/{id}", name="deloeuv")
     */
    public function deleteoeuv($id,OeuvreRepository $repository){
        $oeuvre=$repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Oeuvre::class)->find($oeuvre);
        $product->setIdPanier(null);
        $em->flush();
        return $this->redirectToRoute('showcart');

    }

    /**
     * @Route ("/confirmation", name="confirmer")
     */
    public function confirmercmd(PanierRepository $repository, panierManager $panierManager){
        $panier=$panierManager->getCurrentPanier();
        $panierManager->save($panier);
        $em = $this->getDoctrine()->getManager();
        $pan=$em->getRepository(Panier::class)->find($panier);
        $pan->setEtat(0);
        $em->flush();
        return $this->redirectToRoute('showoeuv');
    }
    /**
     *  @Route ("/annulation", name="annuler")
     */
    public function annuler(panierManager $panierManager){
        $panier=$panierManager->getCurrentPanier();
        $panierManager->save($panier);
        $em = $this->getDoctrine()->getManager();
        $pan=$em->getRepository(Panier::class)->find($panier);
        $pan->setEtat(0);
        $em->flush();
        return $this->redirectToRoute('showoeuv');
    }

    /*public function  verification(CodepromoRepository $repository,Request $request){
        $code=$request->get('code');
        //$codepromo=$repository->findBy(array('label'=>$code))->getLabel();
        $codepromo=$repository->findAll();
        foreach($codepromo as $i=>$v)
        {
            if($code==$v->getLabel()){
                $x=1;
                return $this->redirectToRoute('showcart',['x'=>$x]);
            }else{
                $x=2;}
        }

        return $this->redirectToRoute('showcart',['x'=>$x]);
    }
    */
}
