<?php

include 'header-json.php';

$json = file_get_contents('php://input');
$donneesFormulaire = json_decode($json, TRUE);

try{
    
    include 'bdd.php';

    $requete = $bdd->prepare("SELECT * 
                                FROM utilisateur 
                                WHERE email = :email");

    $requete->execute([
        "email" => $donneesFormulaire["email"]
    ]);

    $utilisateur = $requete->fetch();

    if($utilisateur && password_verify(
        $donneesFormulaire["password"],
        $utilisateur['password'])
    ) {
       
        // Étape 1 : Créer le Header
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ]);

        // Étape 2 : Créer le Payload (les données que vous voulez stocker)
        $payload = json_encode([
            'email' => $donneesFormulaire["email"],
            'admin' => $utilisateur["admin"]
        ]);

        // Étape 3 : Encoder le Header et le Payload en base64Url
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Étape 4 : Créer la signature
        $key = 'clé secrète'; // Remplacez cette clé par une clé secrète de votre choix
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Étape 5 : Créer le JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        echo "{ \"jwt\" : \"$jwt\" }";


    } else {
        $erreur = ["message" => "utilisateur inconnu"];
        echo json_encode($erreur);
    }
}
catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}