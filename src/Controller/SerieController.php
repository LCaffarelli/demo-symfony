<?php

namespace App\Controller;
/*Controller créé grace à une commande sur le termninal*/

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /*On recupere les repository en l'injectant des les params*/
    public function list(SerieRepository $serieRepository): Response
    {
        //Liste TOUTES les séries
        //$series=$serieRepository->findAll();
       // dump($series);

        //Aller chercher les 30 séries les plus populaires avec DOCTRINE. On fait un tableau vide pour recuperer, on precise par quoi on va classer (popularity) et si c'est croissant ou décroissant, et le nombre que l'on veut recuperer (30)
        //$series=$serieRepository->findBy([],['popularity'=>'DESC'],30);

        ////Aller chercher les 30 séries les plus populaires avec DQL. On fait une variable qui appelle le repository et on appelle la fonction que l'on a créée avec la requete
        $series=$serieRepository->findBestSeries();
        dump($series);

        //on peut enlever le controller mis par defaut
        //Dans le render on retourne donc un lien et une clef
        return $this->render('serie/list.html.twig',['series'=>$series]);
    }

    /*On vient créeer la une nouvelle fonction qui va chercher la série en fonction de son id dans la base de donnée et de l'afficher
    on a mis l'id de la serie en parametre
    */
    #[Route ('/details/{id}', name: 'details')]
    public function details(int $id, SerieRepository $serieRepository): Response
    {
        $serie =$serieRepository->find($id);
        return $this->render("/serie/details.html.twig",['serie'=>$serie]);
        //passer la serie à twig
    }

    /*Fonction pour créer une sérié*/
    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    { // Request permet de recuperer ce qui va etre envoyé par l'ulisateur

        /*dump permet de voir l'etat de quelque chose en affichant une toolbar sur la page. Si on clique sur l'un des onglets de cette barre on peut acceder au profiler
        qui  donne encore plus d'informations. Mais le traitement continue...
        Du coup on va utiliser dd (dump die) pour arreter le traitement*/
        //dump($request);
        //dd($request);
        return $this->render('/serie/create.html.twig');
    }

    /*On va venir creer un manager dans la fonction demo*/
    #[Route('/demo', name: 'demo')]
    public function demo(EntityManagerInterface $entityManager)
    {
        $serie = new Serie();
        $serie->setName('serie3');
        $serie->setBackdrop('test');
        $serie->setPoster('poster');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstAirDate(new \DateTime('-1 years'));
        $serie->setLastAirDate(new \DateTime('-6 months'));
        $serie->setGenre('Fantasy');
        $serie->setOverview('blabla');
        $serie->setVote(1.5);
        $serie->setPopularity(5.60);
        $serie->setStatus('cancelled');
        $serie->setTmdbId(123);

        dump($serie);

        //Va créer l'objet dans la base de données
        $entityManager->persist($serie);
        //L'envoie dans la BDD
        $entityManager->flush();

        dump($serie);//va afficher ce qui a été créé

//        //Pour supprimer
//        $entityManager->remove($serie);
//
//        //Pour envoyer la commande en BDD
//        $entityManager->flush();

        //Pour modifier (ici avec série 3)
        $serie->setGenre('comic');
        //Pour envoyer la commande en BDD
        $entityManager->flush();


        return $this->render('serie/create.html.twig');

    }
}
