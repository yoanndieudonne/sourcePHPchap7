<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=cours_php;charset=utf8',
                   'upjv', 'upjv2021');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

$msg = "";
$idEnCours = null;       // id du livre en cours de modification
$livreEnCours = null;    // donnees du livre a modifier

// 1. CREATE : ajout d'un livre (POST sans id)
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && !isset($_POST['id'])
    && isset($_POST['titre']) && isset($_POST['auteur'])) {
    $titre  = trim($_POST['titre']);
    $auteur = trim($_POST['auteur']);
    $annee  = isset($_POST['annee']) ? (int)$_POST['annee'] : 0;
    if ($titre !== '' && $auteur !== '') {
        $stmt = $pdo->prepare("INSERT INTO livres (titre, auteur, annee)
                               VALUES (:titre, :auteur, :annee)");
        $stmt->execute([':titre'  => $titre,
                        ':auteur' => $auteur,
                        ':annee'  => $annee]);
        $n = $stmt->rowCount();
        $stmt->closeCursor();
        $msg .= "Livre ajoute ($n ligne creee).<br>";
    }
}

// 2. UPDATE : modification d'un livre (POST avec id)
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['id'])
    && isset($_POST['titre']) && isset($_POST['auteur'])) {
    $id     = (int)$_POST['id'];
    $titre  = trim($_POST['titre']);
    $auteur = trim($_POST['auteur']);
    $annee  = isset($_POST['annee']) ? (int)$_POST['annee'] : 0;
    if ($titre !== '' && $auteur !== '' && $id > 0) {
        $stmt = $pdo->prepare("UPDATE livres
                               SET titre = :titre, auteur = :auteur, annee = :annee
                               WHERE id = :id");
        $stmt->execute([':titre'  => $titre,
                        ':auteur' => $auteur,
                        ':annee'  => $annee,
                        ':id'     => $id]);
        $n = $stmt->rowCount();
        $stmt->closeCursor();
        // rowCount() = 0 si la ligne n'existe pas ou si rien n'a change
        if ($n === 0) {
            $msg .= "Aucune modification (donnees identiques ou id introuvable).<br>";
        } else {
            $msg .= "Livre modifie ($n ligne mise a jour).<br>";
        }
    }
}

// 3. DELETE : suppression d'un livre (GET ?supprimer=id)
if (isset($_GET['supprimer'])) {
    $stmt = $pdo->prepare("DELETE FROM livres WHERE id = :id");
    $stmt->execute([':id' => (int)$_GET['supprimer']]);
    $n = $stmt->rowCount();
    $stmt->closeCursor();
    if ($n === 0) {
        $msg .= "Aucun livre supprime (id introuvable).<br>";
    } else {
        $msg .= "Livre supprime ($n ligne).<br>";
    }
}

// 4. Preparation du formulaire de modification (GET ?modifier=id)
if (isset($_GET['modifier'])) {
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE id = :id");
    $stmt->execute([':id' => (int)$_GET['modifier']]);
    $livreEnCours = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if ($livreEnCours !== false) {
        $idEnCours = $livreEnCours['id'];
    }
}

// 5. READ : lecture de la liste, APRES les ecritures eventuelles
$res    = $pdo->query("SELECT id, titre, auteur, annee
                       FROM livres ORDER BY id");
$livres = $res->fetchAll(PDO::FETCH_ASSOC);
$res->closeCursor();
?>
<html>
<body>
<h2>Bibliotheque (<?php echo count($livres); ?> livres)</h2>
<?php if ($msg !== '') echo "<p><b>$msg</b></p>"; ?>
<table border="1">
<tr><th>id</th><th>Titre</th><th>Auteur</th><th>Annee</th><th></th></tr>
<?php foreach ($livres as $l) { ?>
<tr>
  <td><?php echo $l['id']; ?></td>
  <td><?php echo htmlentities($l['titre']); ?></td>
  <td><?php echo htmlentities($l['auteur']); ?></td>
  <td><?php echo $l['annee']; ?></td>
  <td>
    <a href="crud.php?modifier=<?php echo $l['id']; ?>">Modifier</a> |
    <a href="crud.php?supprimer=<?php echo $l['id']; ?>">Supprimer</a>
  </td>
</tr>
<?php } ?>
</table>

<h3><?php echo $idEnCours ? "Modifier le livre #$idEnCours" : "Ajouter un livre"; ?></h3>
<form method="post" action="crud.php">
  <?php if ($idEnCours) { ?>
    <input type="hidden" name="id" value="<?php echo $idEnCours; ?>">
  <?php } ?>
  Titre : <input type="text" name="titre" size="30"
                 value="<?php echo htmlentities($livreEnCours['titre'] ?? ''); ?>"><br>
  Auteur : <input type="text" name="auteur" size="30"
                  value="<?php echo htmlentities($livreEnCours['auteur'] ?? ''); ?>"><br>
  Annee : <input type="text" name="annee" size="5"
                 value="<?php echo htmlentities($livreEnCours['annee'] ?? ''); ?>"><br>
  <input type="submit" value="<?php echo $idEnCours ? 'Enregistrer' : 'Ajouter'; ?>">
  <?php if ($idEnCours) { ?>
    <a href="crud.php">Annuler</a>
  <?php } ?>
</form>
</body>
</html>
