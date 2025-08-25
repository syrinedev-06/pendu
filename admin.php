<?php
$filename = "mots.txt";
$mots = file($filename, FILE_IGNORE_NEW_LINES);

// Ajouter un mot
if (isset($_POST["ajout"])) {
    $nouveau = strtolower(trim($_POST["mot"]));
    if (ctype_alpha($nouveau) && !in_array($nouveau, $mots)) {
        $mots[] = $nouveau;
        file_put_contents($filename, implode("\n", $mots));
    }
}

// Supprimer un mot
if (isset($_GET["suppr"])) {
    $mot = $_GET["suppr"];
    $mots = array_diff($mots, [$mot]);
    file_put_contents($filename, implode("\n", $mots));
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - Mots du pendu</title>
</head>
<body>
    <h1>🛠️ Gestion des mots</h1>
    <form method="post">
        <input type="text" name="mot" required>
        <button name="ajout">Ajouter</button>
    </form>
    <h2>Liste des mots :</h2>
    <ul>
        <?php foreach ($mots as $mot): ?>
            <li><?=$mot?> <a href="?suppr=<?=$mot?>">❌</a></li>
        <?php endforeach; ?>
    </ul>
    <p><a href="index.php">➡️ Retour au jeu</a></p>
</body>
</html>
