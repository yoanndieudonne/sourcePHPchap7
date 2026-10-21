<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=cours_php;charset=utf8',
                   'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

$titre = isset($_GET['titre']) ? $_GET['titre'] : '';

// 1. VERSION DANGEREUSE : concatenation directe
$sql = "SELECT titre FROM livres WHERE titre = '" . $titre . "'";
echo "SQL execute : " . htmlentities($sql) . "<br>";
$res = $pdo->query($sql);
echo "Version dangereuse : ";
while (($l = $res->fetch(PDO::FETCH_ASSOC)) !== FALSE) {
    echo htmlentities($l['titre']) . " ; ";
}
$res->closeCursor();
echo "<br>";

// 2. VERSION SURE : requete preparee
$stmt = $pdo->prepare("SELECT titre FROM livres WHERE titre = :titre");
$stmt->execute([':titre' => $titre]);
echo "Version preparee : ";
while (($l = $stmt->fetch(PDO::FETCH_ASSOC)) !== FALSE) {
    echo htmlentities($l['titre']) . " ; ";
}
$stmt->closeCursor();
echo "(aucun resultat)<br>";
?>
