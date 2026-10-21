<?php
// On annonce au navigateur que la reponse est du JSON
header("Content-Type: application/json");

// Des donnees construites cote serveur (ex: lues en base de donnees)
$livres = [
    ["titre" => "1984",  "auteur" => "George Orwell", "annee" => 1949],
    ["titre" => "Dune",  "auteur" => "Frank Herbert", "annee" => 1965],
];

// json_encode transforme le tableau PHP en chaine JSON
echo json_encode($livres);
?>
