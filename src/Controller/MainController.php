<?php

namespace App\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\b;

class MainController extends AbstractController
{
    //ANCIENNE MANIERE DE FAIRE AVEC LES ANNOTATIONS, ON VA UTILISR LES ROUTES AUJOURD'HUI
//    /**
//     * @Route("/",name="main_home")
//     */
    #[Route("/",name: "main_home")] //LES ROUTES QUE L'ON UTILISE AUJOURD'HUI, par convention, le name doit comprendre le nom du controller (main)_le nom de la fonction (home)
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

    $films = [
        'title' => '<b>Belle</b>',
        'year' => 2021
    ];


    return $this->render("main/test.html.twig",['monfilm' => $films,'autreVariable'=>251453]);

    }
}