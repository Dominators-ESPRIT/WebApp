<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Entity\User;
use App\Entity\Vote;
use App\Entity\OeuvreCompetition;
use App\Form\OeuvreCompetitionType;
use App\Repository\CompetitionRepository;
use App\Repository\OeuvreCompetitionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/oeuvre-competition")
 */
class OeuvreCompetitionController extends AbstractController
{
    /**
     * @Route("/", name="oeuvre_competition_index", methods={"GET"})
     */
    public function index(OeuvreCompetitionRepository $oeuvreCompetitionRepository): Response
    {
        return $this->render('oeuvre_competition/artisteCOC.html.twig', [
            'oeuvre_competitions' => $oeuvreCompetitionRepository->findAll(),
        ]);
    }
/**
     * @Route("/artisteGOCC", name="artisteGOCC", methods={"GET"})
     */
    public function artisteGO(OeuvreCompetitionRepository $oeuvreCompetitionRepository): Response
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(array(
            'id' => 3,
        ));
        $oeuvreCompetition = $oeuvreCompetitionRepository->findBy(array(
            'user' => $user,
        ));

        return $this->render('oeuvre_competition/artisteGOC.html.twig', [
            'oeuvre_competitions' => $oeuvreCompetition,
        ]);
    }

    /**
     * @Route("/userCOCP", name="userCOC", methods={"GET"})
     */
    public function userCOC(OeuvreCompetitionRepository $oeuvreCompetitionRepository): Response
    {
        return $this->render('oeuvre_competition/userCOC.html.twig', [
            'oeuvre_competitions' => $oeuvreCompetitionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/user", name="artisteGOC", methods={"GET"})
     */
    public function artisteGOC(OeuvreCompetitionRepository $oeuvreCompetitionRepository): Response
    {

        return $this->render('oeuvre_competition/artisteGOC.html.twig', [
            'oeuvre_competitions' => $oeuvreCompetitionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="oeuvre_competition_new", methods={"GET","POST"})
     */
    public function new(Competition $competition, Request $request): Response
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepository->findOneBy(array(
            'id' => 3,
        ));
        $oeuvreCompetition = new OeuvreCompetition();
        $oeuvreCompetition->setCompetition($competition);
        $oeuvreCompetition->setUser($user);
        $form = $this->createForm(OeuvreCompetitionType::class, $oeuvreCompetition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $image = $form->get('image')->getData();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$image->guessExtension();
//                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $fileName);

            // Move the file to the directory where brochures are stored
            $image->move(
                $this->getParameter('oeuvre_directory'),
                $fileName
            );

            // Update the 'logos' property to store the PDF file name
            // instead of its contents
            $oeuvreCompetition->setImage($fileName);


            $entityManager->persist($oeuvreCompetition);
            $entityManager->flush();

            return $this->redirectToRoute('oeuvreCompetition', array('id' => $oeuvreCompetition->getCompetition()->getId()));

        }

        return $this->render('oeuvre_competition/new.html.twig', [
            'oeuvre_competition' => $oeuvreCompetition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="oeuvre_competition_show", methods={"GET"})
     */
    public function show(OeuvreCompetition $oeuvreCompetition): Response
    {
        return $this->render('oeuvre_competition/show.html.twig', [
            'oeuvre_competition' => $oeuvreCompetition,
        ]);
    }
    /**
     * @Route("/{id}/competition", name="oeuvreCompetition", methods={"GET"})
     */
    public function oeuvreCompetition(Competition $competition, OeuvreCompetitionRepository $oeuvreCompetitionRepository, UserRepository $userRepository): Response
    {
        $voteRepository = $this->getDoctrine()->getRepository(Vote::class);

        $user = $userRepository->findOneBy(array(
            'id' => 3,
        ));
        $oeuvreCompetition = $oeuvreCompetitionRepository->findBy(array(
            'competition' => $competition,
        ));


        $oeuvresCompetitionTab=null;


        foreach ($oeuvreCompetition as $oeuvre){
            $votes = $voteRepository->findBy(array(
                'oeuvreCompetition' => $oeuvre,
            ));
            $existVote = $voteRepository->findBy(array(
                'user' => $user,
                'oeuvreCompetition' => $oeuvre,
            ));
            $oeuvresCompetition =new \stdClass();
            $oeuvresCompetition->id = $oeuvre->getId();
            $oeuvresCompetition->image = $oeuvre->getImage();
            $oeuvresCompetition->competition = $oeuvre->getCompetition();
            $oeuvresCompetition->description = $oeuvre->getDescription();
            $oeuvresCompetition->username = $oeuvre->getUser()->getUsername();
            $oeuvresCompetition->vote = count($votes);
            $oeuvresCompetition->existVote = $existVote;

            $oeuvresCompetitionTab[]=$oeuvresCompetition;
        }

        return $this->render('oeuvre_competition/artisteCOC.html.twig', [
            'oeuvre_competitions' => $oeuvresCompetitionTab,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="oeuvre_competition_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OeuvreCompetition $oeuvreCompetition): Response
    {
        $form = $this->createForm(OeuvreCompetitionType::class, $oeuvreCompetition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('oeuvre_competition_index');
        }

        return $this->render('oeuvre_competition/edit.html.twig', [
            'oeuvre_competition' => $oeuvreCompetition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="oeuvre_competition_delete", methods={"POST"})
     */
    public function delete(Request $request, OeuvreCompetition $oeuvreCompetition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oeuvreCompetition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($oeuvreCompetition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('oeuvreCompetition', array('id' => $oeuvreCompetition->getCompetition()->getId()));
    }
}
