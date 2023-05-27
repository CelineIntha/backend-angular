<?php

include 'header-json.php';

try{

    include 'bdd.php';

    $requete = $bdd->prepare(
        "SELECT a.id ,a.nom, a.prix, a.contenu , a.date ,a.promotion, a.id_categorie ,c.nom as nom_categorie 
         FROM article a
         LEFT JOIN categorie c ON a.id_categorie = c.id");

    $requete->execute();

    $listeArticle = $requete->fetchAll();

    echo json_encode($listeArticle);

} catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}