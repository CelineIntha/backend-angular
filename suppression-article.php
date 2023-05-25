<?php

include 'header-json.php';

try{

    include 'authentification.php';

    if($utilisateurConnecte) {

        if($utilisateurConnecte['admin'] == 1) {

            $requete = $bdd->prepare("DELETE FROM article WHERE id = :id");

            $requete->execute(["id" => $_GET['id']]);

            // echo '{"message" => "L\'article a bien été supprimé"}';
            echo json_encode(["message" => "L'article a bien été supprimé"]);
        } else {
            echo json_encode(["message" => "Vous n'avez pas les droits nécessaires"]);
        }
    } else {

        echo json_encode(["message" => "Ce compte n'existe plus"]);

    }

} catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}