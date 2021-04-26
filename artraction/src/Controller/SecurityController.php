<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Controller\UsersRepository;

use App\Form\ResetPassType;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $utils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $utils): \Symfony\Component\HttpFoundation\Response
    {

        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();

        return $this->render('security/index.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);


    }

    /**
     * @Route("/hom", name="hom")
     */
    public function home(Request $request, AuthenticationUtils $utils): \Symfony\Component\HttpFoundation\Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user->getRole() == 'Admin')
            return $this->render('admin.html.twig');
        else if ($user->getRole() == 'Client')

            return $this->render('client.html.twig');
        else if ($user->getRole() == 'Artiste')
            return $this->render('artiste.html.twig');

    }


    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/base", name="base")
     */
    public function back()
    {
        return $this->render('base.html.twig', [

            $this->getUser()->getUsername()]);

    }
    /**
     * @Route("/")
     */
    public function accueil()
    {
        return $this->render('base.html.twig');
    }



}
