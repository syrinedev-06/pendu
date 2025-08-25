<?php
session_start();

// Charger les mots
$mots = file("mots.txt", FILE_IGNORE_NEW_LINES);

// Nouvelle partie
if (!isset($_SESSION["mot"])) {
    $_SESSION["mot"] = strtolower($mots[array_rand($mots)]);
    $_SESSION["essais"] = [];
    $_SESSION["erreurs"] = 0;
}

$mot = $_SESSION["mot"];

// Traitement d'une lettre
if (isset($_POST["lettre"])) {
    $lettre = strtolower($_POST["lettre"]);
    if (!in_array($lettre, $_SESSION["essais"])) {
        $_SESSION["essais"][] = $lettre;
        if (strpos($mot, $lettre) === false) {
            $_SESSION["erreurs"]++;
        }
    }
}

// Construire l'affichage
$mot_affiche = "";
$gagne = true;
foreach (str_split($mot) as $lettre) {
    if (in_array($lettre, $_SESSION["essais"])) {
        $mot_affiche .= $lettre . " ";
    } else {
        $mot_affiche .= "_ ";
        $gagne = false;
    }
}

// Défaite ?
$perdu = ($_SESSION["erreurs"] >= 6);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jeu du Pendu</title>
    <style>
        body { font-family: Arial; text-align: center; }
        .mot { font-size: 2em; letter-spacing: 5px; }
        .lettres { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>🎮 Jeu du Pendu 🎮</h1>
    <img src="images/<?=$_SESSION['erreurs']?>.png" alt="pendu"><br>
    <p class="mot"><?=$mot_affiche?></p>
    <p>Lettres déjà proposées : <?=implode(", ", $_SESSION["essais"])?></p>

    <?php if ($gagne): ?>
        <h2>✅ Bravo, tu as gagné !</h2>
        <form method="post"><button name="reset">Nouvelle partie</button></form>
        <?php session_destroy(); ?>
    <?php elseif ($perdu): ?>
        <h2>❌ Perdu ! Le mot était : <?=$mot?></h2>
        <form method="post"><button name="reset">Rejouer</button></form>
        <?php session_destroy(); ?>
    <?php else: ?>
        <form method="post">
            <input type="text" name="lettre" maxlength="1" required>
            <button type="submit">Proposer</button>
        </form>
    <?php endif; ?>
</body>
</html>
