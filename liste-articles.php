<?php

include 'header-json.php';

try {
    require 'bdd.php';

    $requete = $bdd->prepare("SELECT * from article");

    $requete->execute();

    $listeArticle = $requete->fetchAll();

    echo json_encode($listeArticle);

} catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}