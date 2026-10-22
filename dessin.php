<?php
// 1. En-tete : la reponse est une image PNG
header("Content-Type: image/png");

// 2. Creation d'une image de 300x200 pixels
$im = imagecreate(300, 200);

// 3. Allocation des couleurs (Rouge, Vert, Bleu)
// La premiere couleur allouee remplit automatiquement le fond : ici blanc
$blanc = imagecolorallocate($im, 255, 255, 255);
$bleu  = imagecolorallocate($im,   0,   0, 200);
$rouge = imagecolorallocate($im, 200,   0,   0);

// 4. Dessins (l'origine (0,0) est en haut a gauche, y augmente vers le bas)
imagerectangle($im, 20, 20, 120, 80, $bleu);         // rectangle (contour)
imagefilledellipse($im, 210, 60, 100, 60, $rouge);   // ellipse pleine
imageline($im, 20, 150, 280, 150, $bleu);            // segment horizontal
imagestring($im, 5, 30, 160, "Dessine avec GD", $bleu); // texte

// 5. Envoi de l'image au navigateur
imagepng($im);

// 6. Liberation de la memoire occupee par l'image
imagedestroy($im);
?>
