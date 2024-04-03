<?php
// Démarrer la session
session_start();

// Détruire toutes les données de la session
session_destroy();

// Rediriger vers la page d'accueil
header("Location: index.php");
exit();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html"><img src="img/logo.png" alt="Logo de l'entreprise"></a></li>
                <li class="titre"><h1>Librairie </h1></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Déconnexion</h2>
        <p>Vous vous êtes déconnecté avec succès.</p>
        <p><a href="connexion.php">Se connecter à nouveau</a></p>
    </div>
</body>
</html>
