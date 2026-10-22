<?php
// 1. En-tete : la reponse est une image PNG
header("Content-Type: image/png");

// Les donnees du graphique (viendraient d'une base de donnees en pratique)
$donnees = [
    "Janvier" => 12,
    "Fevrier" => 25,
    "Mars"    => 18,
    "Avril"   => 30,
    "Mai"     => 22,
];

$largeur = 400;
$hauteur = 250;
$marge   = 30;

// 2. Creation de l'image
$im = imagecreate($largeur, $hauteur);

// 3. Allocation des couleurs : la premiere ($blanc) remplit le fond
$blanc = imagecolorallocate($im, 255, 255, 255);
$noir  = imagecolorallocate($im,   0,   0,   0);
$bleu  = imagecolorallocate($im,  60, 120, 200);
$rouge = imagecolorallocate($im, 200,   0,   0);
// Titre (sans accent : police bitmap)
imagestring($im, 4, $marge, 8, "Ventes mensuelles", $rouge);

// Calcul de la geometrie des barres
$max       = max($donnees);
$n         = count($donnees);
$largBarre = 40;
$espace    = ($largeur - 2 * $marge - $n * $largBarre) / ($n + 1);
$yBas      = $hauteur - $marge;   // ordonnee de l'axe horizontal (en bas)

$i = 0;
foreach ($donnees as $mois => $valeur) {
    // Hauteur proportionnelle a la valeur maximale
    $hBarre = round($valeur / $max * ($hauteur - 2 * $marge));
    $x1 = round($marge + $espace * ($i + 1) + $largBarre * $i);
    $x2 = $x1 + $largBarre;
    // y augmente vers le bas : le haut de la barre est yBas - hBarre
    $y1 = $yBas - $hBarre;

    imagefilledrectangle($im, $x1, $y1, $x2, $yBas, $bleu);
    imagestring($im, 2, $x1 + 12, $y1 - 14, $valeur, $rouge);   // valeur au-dessus
    imagestring($im, 1, $x1 + 2,  $yBas + 5, $mois,  $rouge);   // libelle dessous
    $i++;
}

// Axe horizontal
imageline($im, $marge, $yBas, $largeur - $marge, $yBas, $noir);

// 5. Envoi de l'image au navigateur
imagepng($im);

// 6. Liberation de la memoire
imagedestroy($im);
?>
