<?php
include 'bdd.php';

// Connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["connexion"])) {
    // Récupérer les données du formulaire
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        // Récupérer les informations de l'utilisateur depuis la base de données en fonction de l'e-mail
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(["email" => $email]);
        $user = $stmt->fetch();

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user["password"])) {
            // Démarrer une session pour l'utilisateur
            session_start();
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"]; // Stocke le nom d'utilisateur dans une variable de session

            // Rediriger vers la page d'accueil
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        // En cas d'erreur lors de la connexion, afficher un message d'erreur détaillé
        error_log("Erreur lors de la connexion : " . $e->getMessage());
        http_response_code(500);
        echo "Une erreur est survenue lors de la connexion. Veuillez réessayer.";
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body> 
    <!-- La navbar-->
    <header>
        <nav>
            <ul>
                <li><a href="index.php"><img src="img/logo.png" alt="Logo de l'entreprise"></a></li>
                <li class="titre"><h1>Librairie </h1></li>
                <li class="produit"><a href="index.php" style="color:#4c6be6;">Accueil</a></li>
                <li class="produit"><a href="connexion.php" style="color:#4c6be6;">Connexions</a></li>
                <li class="produit"><a href="favoris.php" style="color:#4c6be6;">Favoris</a></li>
            </ul>
 
        </nav>
    </header>
    <div class="container">
        <!-- Formulaire de connexion -->
        <form action="" method="post" id="form-connexion">
            <h2>Connexion</h2>
                <div class="error-message"><?php echo $error_message; ?></div>
            <div class="form-group">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="connexion">Se connecter</button>
        </form>
    
        <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>
    </div>
</body>
<footer>
        <p>Library, created by Elyea and Chaïma. All rights reserved.</p>
    </footer>
</html>
