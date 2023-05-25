<?php

include 'header-json.php';

try {
    require 'bdd.php';

    $requete = $bdd->prepare("SELECT * from article
    WHERE id = :id");

    $requete->execute([
        'id' => $_GET['id']
    ]);

    $article = $requete->fetch();

    echo json_encode($article);

} catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}