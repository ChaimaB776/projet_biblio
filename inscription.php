<?php
// On inclue le fichier de la connexion a la bdd
include 'bdd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inscription'])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        // Hash du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Préparation de la requête avec le mot de passe hashé
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password); // Utilisation du mot de passe hashé
        
        // Exécution de la requête
        $stmt->execute();

        echo "Inscription réussie";
    } catch (PDOException $e) {
        echo "L'inscription a échoué : " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription / Connexion</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html"><img src="img/logo.png" alt="Logo de l'entreprise"></li></a>
                <li class="titre"><h1>Librairie </h1></li>
                <li class="produit"><a href="index.php" style="color:#4c6be6;">Accueil</a></li>
                <li class="produit"><a href="connexion.php" style="color:#4c6be6;">Connexions</a></li>
                <li class="produit"><a href="favoris.php" style="color:#4c6be6;">Favoris</a></li>
            </ul>
 
        </nav>
    </header>
    <div class="container">
        <!-- Formulaire de connexion -->
        <form action="" method="post" id="form-inscription">
            <h2>Inscription</h2>
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="inscription">S'inscrire</button>
        </form>
        <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous ici</a>.</p>
    </div>
</body>
<footer>
        <p>Library, created by Elyea and Chaïma. All rights reserved.</p>
    </footer>
</html>
