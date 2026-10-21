<?php
header("Content-Type: text/css");

// La couleur du theme pourrait venir d'une session ou d'une BDD.
// Ici on la fait varier via un parametre GET, avec validation.
$couleur = isset($_GET['couleur']) ? $_GET['couleur'] : "#3366cc";

// Securite : on n'accepte qu'une couleur au format hexadecimal
// (reemploi des expressions regulieres vues precedemment)
if (!preg_match('/^#[0-9a-fA-F]{6}$/', $couleur)) {
    $couleur = "#3366cc";
}
?>
body {
    font-family: sans-serif;
    color: <?php echo $couleur; ?>;
}

h1 {
    border-bottom: 3px solid <?php echo $couleur; ?>;
}

.machin {
    background-color: <?php echo $couleur; ?>;
    color: white;
}
