<?php

$enTetes = getallheaders();
//eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFAYS5jb20ifQ.LDa5zN04FFcTGI846h7zfNIGhHJl729g_TDgqggfmXc

    $jwt = $enTetes['Authorization'];

    $partiesJwt = explode('.', $jwt);

    // Étape 1 : Diviser le JWT en trois parties
    list($base64UrlHeader, $base64UrlPayload, $base64UrlSignatureProvided) = $partiesJwt;

    // Étape 2 : Décoder le Header et le Payload
    $header = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlHeader)), true);
    $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload)), true);

    // Étape 3 : Vérifier la signature
    $key = 'clé secrète';
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    if ($base64UrlSignatureProvided !== $base64UrlSignature) {
        die('{"message" : "Signature invalide"}');
    }

    $emailUtilisateurConnecte = $payload["email"];

    include 'bdd.php';

    $requete = $bdd->prepare("SELECT * FROM utilisateur WHERE email = :email");

    $requete->execute(["email" => $emailUtilisateurConnecte]);

    $utilisateurConnecte = $requete->fetch();