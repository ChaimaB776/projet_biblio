document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Empêche le rechargement de la page
    const searchTerm = document.getElementById('searchInput').value;
    const apiUrl = 'https://www.googleapis.com/books/v1/volumes?q=' + encodeURIComponent(searchTerm) + '&langRestrict=fr';
 
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const books = data.items || [];
            const resultsContainer = document.getElementById('resultsContainer');
            resultsContainer.innerHTML = ''; // Efface les résultats précédents
            books.forEach(book => {
                const title = book.volumeInfo.title || 'Titre inconnu';
                const authors = book.volumeInfo.authors ? book.volumeInfo.authors.join(', ') : 'Auteur inconnu';
                const thumbnail = book.volumeInfo.imageLinks ? book.volumeInfo.imageLinks.thumbnail : 'https://via.placeholder.com/150'; // Placeholder si pas d'image
 
                const bookDiv = document.createElement('div');
                bookDiv.innerHTML = `
                    <h2>${title}</h2>
                    <p>Auteur(s): ${authors}</p>
                    <img src="${thumbnail}" alt="${title}">
                    <button class="add-to-favorites">Ajouter aux favoris</button> <!-- Bouton "Ajouter aux favoris" -->
                    <hr>
                `;
                resultsContainer.appendChild(bookDiv);
            });
 
            // Ajouter un gestionnaire d'événements pour les boutons "Ajouter aux favoris"
            document.querySelectorAll('.add-to-favorites').forEach(button => {
                button.addEventListener('click', function() {
                    // Récupérer les informations sur le livre à partir des éléments HTML correspondants
                    const title = this.parentNode.querySelector('h2').textContent;
                    const authors = this.parentNode.querySelector('p').textContent.split(': ')[1]; // Récupérer les auteurs sans le texte "Auteur(s):"
                    const thumbnail = this.parentNode.querySelector('img').src;
 
                    // Envoyer une requête AJAX pour ajouter le livre aux favoris
                    fetch('favoris.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            title: title,
                            author: authors,
                            thumbnail: thumbnail
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            alert('Livre ajouté aux favoris avec succès !');
                        } else {
                            throw new Error('Erreur lors de l\'ajout du livre aux favoris.');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de l\'ajout du livre aux favoris.');
                    });
                });
            });
        })
        .catch(error => {
            console.error('Erreur lors de la requête:', error);
        });
});