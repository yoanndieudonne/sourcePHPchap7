<?php
$dsn = 'mysql:host=localhost;dbname=cours_php;charset=utf8';

try {
    $pdo = new PDO($dsn, 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion a MySQL reussie.<br>";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage() . "<br>";
    exit;
}
?>
