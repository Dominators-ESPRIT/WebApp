<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Form\EvenementsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenements")
 */
class EvenementsController extends AbstractController
{
    /**
     * @Route("/", name="evenements_index", methods={"GET"})
     */
    public function index(): Response
    {
        $evenements = $this->getDoctrine()
            ->getRepository(Evenements::class)
            ->findAll();

        return $this->render('evenements/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }

    /**
     * @Route("/Client", name="evenements_Client", methods={"GET"})
     */
    public function indexFront(): Response
    {
        $evenements = $this->getDoctrine()
            ->getRepository(Evenements::class)
            ->findAll();

        return $this->render('evenements/FrontEvent.html.twig', [
            'evenements' => $evenements,
        ]);
    }


    /**
     * @Route("/new", name="evenements_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evenement = new Evenements();
        $form = $this->createForm(EvenementsType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $evenement->setVote(0);
            $evenement->setRate(0.0);
            $evenement->setNbreparticipants(0);
            $evenement->setImage("3.jpg");
            $evenement->getUploadFile();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenements_index');
        }

        return $this->render('evenements/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenements_show", methods={"GET"})
     */
    public function show(Evenements $evenement): Response
    {
        return $this->render('evenements/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenements_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evenements $evenement): Response
    {
        $form = $this->createForm(EvenementsType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenements_index');
        }

        return $this->render('evenements/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="event_delete")
     */
    public function delete(Request $request, Evenements $evenements): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($evenements);
        $entityManager->flush();


        return $this->redirectToRoute('evenements_index');
    }


    /**
     * @Route("/rate", name="rate_", methods={"POST"})
     */
    public function rateAction(\Symfony\Component\HttpFoundation\Request $request){
        $data = $request->getContent();
        $obj = json_decode($data,true);

        $em = $this->getDoctrine()->getManager();
        $rate =$obj['rate'];
        $idc = $obj['event'];
        $facceuil = $em->getRepository(Evenements::class)->find($idc);
        $note = ($facceuil->getRate()*$facceuil->getVote() + $rate)/($facceuil->getVote()+1);
        $facceuil->setVote($facceuil->getVote()+1);
        $facceuil->setRate($note);
        $em->persist($facceuil);
        $em->flush();
        return new Response($facceuil->getRate());
    }

}
