<?php
$has_slides = false;
if (have_rows('slider-about_repeater', 'options')) :
    while (have_rows('slider-about_repeater', 'options')) : the_row();
        $has_slides = true;
    endwhile;
endif;
?>

<?php
$has_advantages = false;
if (have_rows('advantages_repeater', 'options')) :
    while (have_rows('advantages_repeater', 'options')) : the_row();
    $has_advantages = true;
    endwhile;
endif;
?>

<div class="company" <?php echo !$has_slides || !$has_advantages ? 'style="justify-content: center; gap: 0;"' : ''; ?>>
    <section class="advantages" <?php echo !$has_advantages ? 'style="display: none;"' : ''; ?>>
        <h2 class="advantages__title visually-hidden">Преимущества</h2>
        <ul class="advantages__list">
            <?php if (have_rows('advantages_repeater', 'options')) : ?>
                <?php while (have_rows('advantages_repeater', 'options')) : the_row(); ?>
                    <?php
                    $title = get_sub_field('advantages_repeater_title');
                    $url = get_sub_field('advantages_repeater_pic');
                    ?>
                    <li class="advantages__item advantages__item--first text-pre-large" style="background-image: url(<?php echo esc_url($url); ?>);">
                        <?php echo esc_html($title); ?>
                    </li>
                <?php endwhile; ?>
            <?php endif; ?>
        </ul>
    </section>

    <section class="slider-about" <?php echo !$has_slides ? 'style="display: none;"' : ''; ?> <?php echo !$has_advantages ? 'style="width: 100%;"' : ''; ?>>
        <div class="slider-about__slider swiper swiperAbout">
            <ul class="slider-about__list swiper-wrapper">
                <?php if (have_rows('slider-about_repeater', 'options')) : ?>
                    <?php while (have_rows('slider-about_repeater', 'options')) : the_row(); ?>
                        <li class="slider-about__item swiper-slide">
                            <h2 class="slider-about__title title-big"><?php the_sub_field('slider-about_repeater_title'); ?></h2>

                            <?php
                            $image = get_sub_field('slider-about_repeater_pic');
                            if ($image) :
                            ?>
                                <picture>
                                    <source media="(min-width: 1600px)" srcset="<?php echo esc_url($image['url']); ?>" width="456" height="227">
                                    <img class="slider-main__pic" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_url($image['alt']); ?>" width="320" height="159">
                                </picture>
                            <?php endif; ?>

                            <span class="slider-about__name text-medium"><?php the_sub_field('slider-about_repeater_subtitle'); ?></span>
                            <p class="slider-about__description text-medium"><?php the_sub_field('slider-about_repeater_description'); ?>
                            </p>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>

            <div class="slider-about__controls">
                <button class="slider-about__control slider-about__control--prev">
                    <svg class="slider-about__icon">
                        <use href="<?php echo get_template_directory_uri(); ?>/build/img/svgsprite/sprite.symbol.svg#left-filled-arrow"></use>
                    </svg>
                </button>
                <button class="slider-about__control slider-about__control--next">
                    <svg class="slider-about__icon">
                        <use href="<?php echo get_template_directory_uri(); ?>/build/img/svgsprite/sprite.symbol.svg#left-filled-arrow"></use>
                    </svg>
                </button>
            </div>
        </div>
    </section>
</div>