<?php

include 'header-json.php';

try{

    include 'bdd.php';

    $requete = $bdd->prepare( "SELECT * FROM categorie" );

    $requete->execute();

    $listeCategories = $requete->fetchAll();

    echo json_encode($listeCategories);

} catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}