<?php
/*
Template Name: Шаблон страницы "Услуга"
Template Post Type: page, post
*/
?>

<?php get_header(); ?>
<main class="page-specific-service">
    <div class="page-specific-service__columns">
        <div class="page-specific-service__column-1">
            <div class="menu menu--full">
                <?php wp_nav_menu(array(
                    'theme_location' => 'side_menu',
                    'container'      => '',
                    'menu_class'     => 'menu__list',
                )); ?>
            </div>
        </div>
        <div class="page-specific-service__column-2">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ul class="breadcrumb__list">
                    <li class="breadcrumb__item text-medium"><a class="breadcrumb__link" href="/">Главная</a></li>

                    <?php
                    $current_page_id = get_the_ID(); // Получаем ID текущей страницы
                    $parent_page_id = wp_get_post_parent_id($current_page_id); // Получаем ID родительской страницы

                    if ($parent_page_id) {
                        $parent_page_title = get_the_title($parent_page_id); // Получаем заголовок родительской страницы
                        $parent_page_link = get_permalink($parent_page_id); // Получаем URL родительской страницы
                    ?>
                        <li class="breadcrumb__item breadcrumb__item--services text-medium">
                            <a class="breadcrumb__link" href="<?php echo esc_url($parent_page_link); ?>"><?php echo esc_html($parent_page_title); ?></a>
                        </li>
                    <?php
                    }
                    ?>

                    <li class="breadcrumb__item breadcrumb__item--specific-service text-medium">
                        <?php echo wp_title('', true); ?>
                    </li>
                </ul>
            </nav>

            <h1 class="page-specific-service__title title-big"><?php echo esc_html(get_field('service_title')); ?></h1>
        </div>
        <section class="page-specific-service__column-3 banners">
            <?php
            $service = get_field('service-g');
            if ($service && (!empty($service['pic']) )) :
            ?>
                <div class="banners__pic-wrapper">

                    <picture>
                            <source media="(min-width: 1600px)" srcset="<?php echo esc_url($service['pic']['url']); ?>" width="730" height="300">
                            <img class="banners__pic" src="<?php echo esc_url($service['pic']['url']); ?>" alt="<?php echo esc_attr($service['pic']['alt']); ?>" height="260">
                    </picture>

                    <?php
                    if ($service && (!empty($service['button']))) :
                    ?>
                        <button class="banners__button consultation-button text-medium"><?php echo esc_html($service['button']); ?></button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php
            if ($service && (!empty($service['description']))) :
            ?>
                <div class="banners__description text-medium container-mobile">
                    <?php echo $service['description']; ?>
                </div>
            <?php endif; ?>

            <?php
            $has_switches = false;
            if (have_rows('switches_repeater')) :
                while (have_rows('switches_repeater')) : the_row();
                    $has_switches = true;
                endwhile;
            endif; ?>

            <div class="service-description container-mobile" <?php echo !$has_switches ? 'style="display: none;"' : ''; ?>>
                <ul class="service-description__list">
                    <?php if (have_rows('switches_repeater')) : ?>
                        <?php while (have_rows('switches_repeater')) : the_row(); ?>
                            <?php
                            $switch = get_sub_field('switches_repeater_switch');
                            if (!empty($switch)) :
                            ?>
                                <li class="service-description__item">
                                    <button class="service-description__button text-medium"><?php echo esc_html($switch); ?></button>
                                </li>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            </div>


            <ul class="banners__list">
                <?php if (have_rows('examples_repeater')) : ?>
                    <li class="banners__item">
                        <section class="examples">
                            <h2 class="examples__title visually-hidden">Варианты изготовления</h2>
                            <div class="examples__mobile-slider swiper swiperExamples">

                                <ul class="examples__list swiper-wrapper">

                                    <?php while (have_rows('examples_repeater')) : the_row(); ?>
                                        <?php
                                        $image = get_sub_field('examples_repeater_pic');
                                        if ($image) :
                                        ?>
                                            <li class="examples__item swiper-slide">
                                                <div class="examples__container">

                                                    <picture>
                                                        <?php if (!empty($image['url'])) : ?>
                                                            <source media="(min-width: 1600px)" srcset="<?php echo esc_url($image['url']); ?>" width="348" height="282">
                                                            <img class="examples__pic" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" height="260">
                                                        <?php endif; ?>
                                                    </picture>

                                                    <div class="examples__pic-blackout"></div>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </ul>

                                <div class="examples__mobile-controls">
                                    <button class="examples__mobile-control examples__mobile-control--prev">
                                        <svg class="examples__mobile-icon">
                                            <use href="<?php echo get_template_directory_uri(); ?>/build/img/svgsprite/sprite.symbol.svg#left-filled-arrow"></use>
                                        </svg>
                                    </button>
                                    <button class="examples__mobile-control examples__mobile-control--next">
                                        <svg class="examples__mobile-icon">
                                            <use href="<?php echo get_template_directory_uri(); ?>/build/img/svgsprite/sprite.symbol.svg#left-filled-arrow"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </section>
                    </li>
                <?php endif; ?>

                <?php if (have_rows('description_repeater')) : ?>
                    <li class="banners__item">
                        <section class="description container-mobile">
                            <h2 class="description__title visually-hidden">Описание</h2>
                            <div class="description__container" data-simplebar>
                                <table class="description__table">
                                    <?php while (have_rows('description_repeater')) : the_row(); ?>
                                        <tr class="description__row">
                                            <?php if (have_rows('description_repeater_repeater')) : ?>
                                                <?php while (have_rows('description_repeater_repeater')) : the_row(); ?>
                                                    <td><?php echo esc_html(get_sub_field('description_repeater_repeater_cell')); ?></td>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endwhile; ?>

                                </table>
                            </div>
                        </section>
                    </li>
                <?php endif; ?>

                <?php
                $char = get_field('characteristics');
                if (!empty($char)) :
                ?>
                    <li class="banners__item">
                        <section class="characteristics text-medium container-mobile">
                            <?php the_field('characteristics'); ?>
                        </section>
                    </li>
                <?php endif; ?>
            </ul>
        </section>
    </div>

    <?php
    $has_slides = false;
    if (have_rows('slider-other_repeater', 'options')) :
        while (have_rows('slider-other_repeater', 'options')) : the_row();
            $has_slides = true;
        endwhile;
    endif;
    ?>

    <section class="other container-desktop" <?php echo !$has_slides ? 'style="display: none;"' : ''; ?>>
        <h2 class="other__title title-big">Вам может быть интересно</h2>
        <div class="other__slider swiper swiperOther">
            <ul class="other__list swiper-wrapper">
                <?php if (have_rows('slider-other_repeater', 'options')) : ?>
                    <?php while (have_rows('slider-other_repeater', 'options')) : the_row(); ?>
                        <li class="other__item swiper-slide">
                            <div class="other__frame other__frame--first" style="background-image: url(<?php the_sub_field('slider-other_repeater_pic'); ?>); ">
                                <h3 class="other__item-title title-big"><?php the_sub_field('slider-other_repeater_title'); ?></h3>
                                <a class="other__button text-medium" href="#"><?php the_sub_field('slider-other_repeater_button'); ?></a>
                            </div>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="other__controls">
            <button class="other__control other__control--prev">
                <svg class="other__icon">
                    <use href="<?php echo get_template_directory_uri(); ?>/build/img/svgsprite/sprite.symbol.svg#simple-left-arrow"></use>
                </svg>
            </button>
            <button class="other__control other__control--next">
                <svg class="other__icon">
                    <use href="<?php echo get_template_directory_uri(); ?>/build/img/svgsprite/sprite.symbol.svg#simple-left-arrow"></use>
                </svg>
            </button>
        </div>
    </section>

    <?php get_template_part('template-parts/company'); ?>

</main>
<?php get_footer(); ?>