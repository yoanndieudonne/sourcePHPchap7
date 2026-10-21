<html>
<body>
<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=cours_php;charset=utf8',
                   'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

try {
    $res = $pdo->query("SELECT id, titre, auteur, annee
                        FROM livres ORDER BY annee");
    echo "<table border='1'>";
    echo "<tr><th>id</th><th>Titre</th><th>Auteur</th><th>Annee</th></tr>";
    while (($ligne = $res->fetch(PDO::FETCH_ASSOC)) !== FALSE) {
        echo "<tr><td>" . $ligne['id'] . "</td>"
           . "<td>" . htmlentities($ligne['titre']) . "</td>"
           . "<td>" . htmlentities($ligne['auteur']) . "</td>"
           . "<td>" . $ligne['annee'] . "</td></tr>";
    }
    echo "</table>";
    $res->closeCursor();
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
}
?>
</body>
</html>
