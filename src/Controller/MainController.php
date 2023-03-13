<?php

namespace App\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    //ANCIENNE MANIERE DE FAIRE AVEC LES ANNOTATIONS, ON VA UTILISR LES ROUTES AUJOURD'HUI
//    /**
//     * @Route("/",name="main_home")
//     */
    #[Route("/",name: "main_home")] //LES ROUTES QUE L'ON UTILISE AUJOURD'HUI
    public function home(){
        //Va avec l'ancienne façon de faire, cad les annotations
        //echo 'coucou';
        // die();

        //retourne une réponse au navigateur
        return $this->render("main/home.html.twig");

    }

//    /**
//     * @Route("/test",name="main_test")
//     */
#[Route("/test", name: "main_test")]
    public function test(){
//        echo 'test';
//        die();
    return $this->render("main/test.html.twig");
    }
}