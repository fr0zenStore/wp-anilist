<?php get_header(); ?>
<div class="container">
    <h1 class="text-center my-4">Poster di Anime e Film</h1>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php
        $args = ['post_type' => ['anime', 'movies'], 'posts_per_page' => -1];
        $query = new WP_Query($args);
        while ($query->have_posts()) : $query->the_post();
            $cover = get_post_meta(get_the_ID(), 'anime_cover', true);
        ?>
        <div class="col">
            <div class="card h-100">
                <img src="<?php echo esc_url($cover); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php the_title(); ?></h5>
                    <p class="card-text"><?php the_excerpt(); ?></p>
                </div>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</div>
<?php get_footer(); ?>
