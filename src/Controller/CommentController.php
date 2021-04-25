<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Evenements;
use App\Entity\User;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/Client/{id}", name="comment_index", methods={"GET"})
     */
    public function index($id): Response
    {

        $event = $this->getDoctrine()
            ->getRepository(Evenements::class)
            ->find($id);
        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(array('idevenement'=>$event));

        return $this->render('comment/index.html.twig', [
            'comments' => $comments,
            'evenements'=>$event
        ]);
    }
    function filterwords($text){
        $filterWords = array('fuck','pute','bitch');
        $filterCount = sizeof($filterWords);
        for ($i = 0; $i < $filterCount; $i++) {
            $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
        }
        return $text;
    }

    /**
     * @Route("/detailsEvent/{id}", name="comment_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $event = $this->getDoctrine()
            ->getRepository(Evenements::class)
            ->find($id);

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(1);
        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(array('idevenement'=>$event));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setCommentaire($this->filterwords($comment->getCommentaire()));
            $comment->setIdevenement($event);
            $comment->setIduser($user);

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comment_new', ['id' => $event->getId()]);
        }

        return $this->render('comment/index.html.twig', [
            'comment' => $comment,
            'comments' => $comments,
            'evenements'=>$event,
            'user'=>$user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idcomment}", name="comment_show", methods={"GET"})
     */
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{id}/{ide}/edit", name="comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comment $comment,$ide): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $event = $this->getDoctrine()
            ->getRepository(Evenements::class)
            ->find($ide);
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(1);
        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(array('idevenement'=>$event));


        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_new', ['id' => $ide]);
        }

        return $this->render('comment/index.html.twig', [

            'user'=>$user,
            'comments' => $comments,
            'evenements'=>$event,
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{ide}/delete", name="comment_delete")
     */
    public function delete(Request $request, Comment $coment,$ide): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($coment);
        $entityManager->flush();


        return $this->redirectToRoute('comment_new', ['id' => $ide]);
    }
}
