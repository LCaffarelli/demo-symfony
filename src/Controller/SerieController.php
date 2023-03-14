<?php

namespace App\Controller;
/*Controller créé grace à une commande sur le termninal*/

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/*On va créer des prefixes
On fait une route en dehors de la classe
Toutes les routes commenceront par /series et le name de toutes les routes commenceront par serie_*/
#[Route('/series', name: 'serie_')]
class SerieController extends AbstractController
{
    /*On change la route en rajoutant un s à série
     * On change le nom de la fonction pour qu'elle corresponde à ce que l'on veut faire
     * on change le name car ne correspond pas aux conventions
     * Response = typage de ce que l'on attend, pas obligatoire de le précisé, mais mis automatiquement
     *
     *
     * Grace au prefix on a plus qu'a mettre ce que l'on veut dans la route et juste le nom de la function */
    #[Route('', name: 'list')]
    public function list(): Response
    {
        //TODO : aller chercher les séries en BDD

        //on peut enlever le controller mis par defaut
        return $this->render('serie/list.html.twig');
    }

    /*On vient créeer la une nouvelle fonction qui va chercher la série en fonction de son id dans la base de donnée et de l'afficher
    on a mis l'id de la serie en parametre
    */
    #[Route ('/details/{id}', name: 'details')]
    public function details(int $id): Response
    {
        return $this->render("/serie/details.html.twig");
        //passer la serie à twig
    }

    /*Fonction pour créer une sérié*/
    #[Route('/create', name: 'create')]
    public function create(Request $request): Response{ // Request permet de recuperer ce qui va etre envoyé par l'ulisateur

         /*dump permet de voir l'etat de quelque chose en affichant une toolbar sur la page. Si on clique sur l'un des onglets de cette barre on peut acceder au profiler
         qui  donne encore plus d'informations. Mais le traitement continue...
         Du coup on va utiliser dd (dump die) pour arreter le traitement*/
        //dump($request);
        //dd($request);
        return $this->render('/serie/create.html.twig');
    }
}
