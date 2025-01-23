<?php
/*
Template Name: Шаблон страницы "Список услуг"
*/
?>

<?php get_header(); ?>
<main class="page-services">

    <div class="page-services__columns">
        <div class="page-services__column-1">
            <div class="menu menu--full">
                <?php wp_nav_menu(array(
                    'theme_location' => 'side_menu',
                    'container'      => '',
                    'menu_class'      => 'menu__list',
                )); ?>
            </div>
        </div>

        <div class="page-services__column-2">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ul class="breadcrumb__list">
                    <li class="breadcrumb__item text-medium"><a class="breadcrumb__link text-medium" href="/">Главная</a></li>
                    <li class="breadcrumb__item breadcrumb__item--services text-medium">
                        <?php echo wp_title('', true); ?>
                    </li>
                </ul>
            </nav>

            <h1 class="page-services__title title-big"><?php the_field('service-list_title'); ?></h1>
        </div>

        <section class="page-services__column-3 services-directory">
            <div class="services-directory__container services-directory__mobile-slider swiper swiperServices">
                <ul class="services-directory__list swiper-wrapper">

                    <?php

                    //                     $term = get_field('
                    // site_section_category');
                    $current_page_id = get_queried_object_id();

                    $query = new WP_Query(array(
                        'post_type' => 'page',
                        'post_status' => 'publish',
                        'posts_per_page' => 0, // Количество записей
                        'post_parent' => $current_page_id,
                        'order' => 'ASC'
                    ));

                    if ($query->have_posts()) :
                    ?>

                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <li class="services-directory__item swiper-slide">

                                <div class="services-directory__frame services-directory__frame--first" style="background-image: url(<?php the_post_thumbnail_url(); ?>); ">
                                    <h2 class="services-directory__title title-big"><?php the_title(); ?>
                                    </h2>
                                    <a class="services-directory__button text-medium" href="<?php the_permalink(); ?>"><?php the_field('post_button'); ?></a>
                                </div>
                            </li>

                        <?php endwhile;
                        wp_reset_postdata(); ?>

                    <?php endif; ?>

                </ul>
                <div class="services-directory__mobile-controls">
                    <button class="services-directory__mobile-control services-directory__mobile-control--prev">
                        <svg class="services-directory__mobile-icon">
                            <use href="<?php echo get_template_directory_uri(); ?>/build/img/svgsprite/sprite.symbol.svg#left-filled-arrow"></use>
                        </svg>
                    </button>
                    <button class="services-directory__mobile-control services-directory__mobile-control--next">
                        <svg class="services-directory__mobile-icon">
                            <use href="<?php echo get_template_directory_uri(); ?>/build/img/svgsprite/sprite.symbol.svg#left-filled-arrow"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    </div>

    <?php get_template_part('template-parts/company'); ?>

</main>

<?php get_footer(); ?>