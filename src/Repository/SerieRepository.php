<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 *
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function save(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //*****RECHERCHE DES MEILLEURES SERIE EN MODE DQL*****
//    public function findBestSeries(){
//        //On va avoir besoin de notre manager pour faire la requete
//        $entityManager=$this->getEntityManager();
//
//        /*On vient créer une variable qui va contenir notre requete. On utilise une variable qu'on appele $dql pour avoir l'autocomplétion. On pourrait aussi l'appeler autrement .
//        Pour le nom de la table il faut prendre le nom de l'entité créée et on lui donne un alias ici "s" pour serie
//        Quand on veut filtrer on est obligé d'utiliser l'alias pour appeler les colonnes
//        */
//        $dql="SELECT s FROM App\Entity\Serie s
//                WHERE s.popularity > 100
//                AND s.vote >8
//                ORDER BY s.popularity DESC ";
//
//        //On vient créer une variable qui va contenir notre requete, on utilise des methodes du manager pour le faire
//        $query=$entityManager->createQuery($dql);
//
//        //Pour limiter au 30 meilleurs
//        $query->setMaxResults(30);
//
//        //On retourne ensuite le resultat
//        return $query-> getResult();
//    }

    //*****RECHERCHE DES MEILLEURES SERIE EN MODE QUERYBUILDER*****
    public function findBestSeries(){
        //On va créé une variable afin d'utiliser le queryBuilder. Il faut mettre un alias en parametre. Ainsi on aura pas besoin d'appeler l'entité
        $queryBuilder=$this->createQueryBuilder('s');

        //On vient faire la jointure, ici on utilise un left join car on ne sait pas si toutes les series auront des saisons.
        // On precise la colonne a lier avec un alias, et le nouvel alias de l'autre table
        $queryBuilder->leftJoin('s.seasons','seas');

        //On ajoute dans le SELECT de la requete tout ce qu'on peut trouver dans season
        $queryBuilder->addSelect('seas');

        //Pour faire mes filtre je dois utiliser la methode andWhere.
        $queryBuilder->andWhere('s.popularity >100');
        $queryBuilder->andWhere('s.vote >8');

        //Pour trier par popularité
        $queryBuilder->addOrderBy('s.popularity',order: 'DESC');
        $queryBuilder->addOrderBy('s.vote',order: 'DESC');

        //On fait une variable qui va recuperer notre builder
        $query=$queryBuilder->getQuery();

        //Ainsi on va pouvoir passer des limitations
        $query->setMaxResults(30);

        //Nous permet d'obtenir les 30 séries et non juste 30 résultats
        $paginator= new Paginator($query);

        //On retourne les resultats
        return $paginator;
    }

//REQUETES GENEREES AUTOMATIQUEMENTS
//    /**
//     * @return Serie[] Returns an array of Serie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Serie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
