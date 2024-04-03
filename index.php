<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de livres</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php"><img src="img/logo.png" alt="Logo de l'entreprise"></a></li>
                <li class="titre"><h1>Librairie </h1></li>
                <?php
                // Démarrer la session
                session_start();

                // Vérifier si l'utilisateur est connecté
                if (isset($_SESSION["username"])) {
                    // Afficher le nom de l'utilisateur et un lien de déconnexion
                    echo "<li class='produit'><a href='deconnexion.php' style='color:#4c6be6;'>Déconnexion</a></li>";
                    echo "<li class='produit'><span style='color:#4c6be6;'>Bonjour, " . $_SESSION["username"] . "!</span></li>";
                    echo "<li class='produit'><a href='compte.php' style='color:#4c6be6;'>Compte</a></li>"; // Lien vers la page de compte

                } else {
                    // Si l'utilisateur n'est pas connecté, afficher un lien de connexion
                    echo "<li class='produit'><a href='connexion.php' style='color:#4c6be6;'>Connexion</a></li>";
                }
                ?>
                <li class="produit"><a href="favoris.php" style="color:#4c6be6;">Favoris</a></li>
            </ul>
        </nav>
    </header>
    <h1>Recherche de livres</h1>
    <form id="searchForm">
        <input type="text" id="searchInput" placeholder="Entrez le titre ou le genre du livre">
        <button type="submit">Rechercher</button>
    </form>
    <div class="container">
    <div id="resultsContainer" class="book-columns">
    
        <?php
        // Afficher les livres récupérés depuis la base de données
        foreach ($livres as $livre) {
            echo "<div class='livre'>";
            echo "<img src='" . $livre['image'] . "' alt='" . $livre['titre'] . "'>";
            echo "<h2>" . $livre['titre'] . "</h2>";
            echo "<p>Auteur: " . $livre['auteur'] . "</p>";
            echo "<a href='favoris.php?id=" . $livre['id'] . "&titre=" . $livre['titre'] . "&auteur=" . $livre['auteur'] . "&img=" . $livre['image'] . "'>Ajouter aux favoris</a>";
            // Ajout d'un formulaire pour ajouter aux favoris
            echo "<form action='favoris.php' method='post'>";
            echo "<input type='hidden' name='title' value='" . $livre['titre'] . "'>";
            echo "<input type='hidden' name='author' value='" . $livre['auteur'] . "'>";
            echo "<button type='submit'>Ajouter aux favoris</button>";
            echo "</form>";
            echo "</div>";
        }
        ?>
    </div>
    </div>
</body>
<footer>
        <p>Library, created by Elyea and Chaïma. All rights reserved.</p>
    </footer>
</html>
