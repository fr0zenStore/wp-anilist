function fetchAnimeData(animeId) {
    const query = `
    query ($id: Int) {
        Media(id: $id) {
            title {
                romaji
            }
            description
            startDate {
                year
                month
                day
            }
            trailer {
                id
                site
            }
            coverImage {
                large
            }
            episodes
            type
            genres
            studios {
                nodes {
                    name
                }
            }
        }
    }`;

    fetch('https://graphql.anilist.co', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            query: query,
            variables: { id: parseInt(animeId) }
        })
    })
    .then(response => response.json())
    .then(data => {
        const anime = data.data.Media;
        document.getElementById('anime_results').innerHTML = `
            <p><strong>Titolo:</strong> ${anime.title.romaji}</p>
            <p><strong>Descrizione:</strong> ${anime.description}</p>
            <p><strong>Data di uscita:</strong> ${anime.startDate.year}-${anime.startDate.month}-${anime.startDate.day}</p>
            <p><strong>Studio:</strong> ${anime.studios.nodes.map(studio => studio.name).join(', ')}</p>
            <p><strong>Episodi:</strong> ${anime.episodes}</p>
            <img src="${anime.coverImage.large}" alt="${anime.title.romaji}" />
        `;
    })
    .catch(error => console.error('Errore API AniList:', error));
}
