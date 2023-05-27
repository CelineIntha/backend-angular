<?php

include 'header-json.php';

$json = file_get_contents('php://input');
$donneesFormulaire = json_decode($json, TRUE);

try{

    include 'authentification.php';

    if($utilisateurConnecte) {

        if($utilisateurConnecte['admin'] == 1) {

            $requete = $bdd->prepare("UPDATE article 
                                        SET nom = :nom, contenu = :contenu, id_categorie = :id_categorie
                                        WHERE id = :id");

            $requete->execute([
                "nom" => $donneesFormulaire["nom"],
                "contenu" => $donneesFormulaire["contenu"],
                "id_categorie" => $donneesFormulaire["id_categorie"],
                "id" => $donneesFormulaire["id"]
            ]);

            echo '{"message" : "L\'article a été modifié"}';
        } else {
            echo json_encode(["message" => "Vous n'avez pas les droits nécessaires"]);
        }

    }

} catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}