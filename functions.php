<?php
// Registrazione degli script e degli stili
function wp_anilist_enqueue_scripts() {
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    wp_enqueue_style('wp-anilist-style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_script('alpinejs', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', [], null, true);
    wp_enqueue_script('anilist-api', get_template_directory_uri() . '/assets/js/anilist.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'wp_anilist_enqueue_scripts');

// Registrazione CPT Anime e Movies
function wp_anilist_register_cpts() {
    $types = ['anime' => 'Anime', 'movies' => 'Movies'];
    foreach ($types as $key => $label) {
        register_post_type($key, [
            'label' => $label,
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'show_in_rest' => true,
        ]);

        // Tassonomie
        register_taxonomy("genre_$key", $key, [
            'label' => 'Genere',
            'public' => true,
            'hierarchical' => true,
        ]);
        register_taxonomy("season_$key", $key, [
            'label' => 'Stagione',
            'public' => true,
            'hierarchical' => false,
        ]);
        register_taxonomy("type_$key", $key, [
            'label' => 'Tipo',
            'public' => true,
            'hierarchical' => false,
        ]);
        register_taxonomy("studio_$key", $key, [
            'label' => 'Studio',
            'public' => true,
            'hierarchical' => false,
        ]);
    }
}
add_action('init', 'wp_anilist_register_cpts');

// Metabox per ottenere i dati da AniList
function wp_anilist_metabox() {
    add_meta_box(
        'anime_data',
        'Dati Anime/Film da AniList',
        'wp_anilist_metabox_callback',
        ['anime', 'movies'],
        'normal'
    );
}
add_action('add_meta_boxes', 'wp_anilist_metabox');

function wp_anilist_metabox_callback($post) {
    echo '<label for="anime_id">ID Anime/Film:</label>';
    echo '<input type="text" id="anime_id" name="anime_id" />';
    echo '<button type="button" onclick="fetchAnimeData(document.getElementById(\'anime_id\').value)">Ottieni Dati</button>';
    echo '<div id="anime_results"></div>';
}
?>
