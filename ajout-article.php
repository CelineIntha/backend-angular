<?php

include 'header-json.php';

$json = file_get_contents('php://input');
$donneesFormulaire = json_decode($json, TRUE);

try{

    include 'authentification.php';

    if($utilisateurConnecte) {

        if($utilisateurConnecte['admin'] == 1) {

            $requete = $bdd->prepare("INSERT INTO article (nom, contenu, date, id_categorie)
                                        VALUES (:nom, :contenu,  NOW() , :id_categorie)");

            $requete->execute([
                "nom" => $donneesFormulaire["nom"],
                "contenu" => $donneesFormulaire["contenu"],
                "id_categorie" => $donneesFormulaire["id_categorie"]
            ]);

            echo '{"message" : "L\'article a été ajouté"}';
        } else {
            echo json_encode(["message" => "Vous n'avez pas les droits nécessaires"]);
        }

    }

} catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}