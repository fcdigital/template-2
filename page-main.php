<?php
/*
Template Name: Шаблон "Главной страницы"
*/
?>

<?php get_header(); ?>
<main class="page-main">
	<div class="page-main__top-wrapper">
		<div class="page-main__top-columns">
			<div class="page-main__menu menu menu--short">
				<?php wp_nav_menu(array(
					'theme_location' => 'side_menu',
					'container'      => '',
					'menu_class'     => 'menu__list',
				)); ?>
			</div>
			<section class="slider-main">
				<div class="slider-main__slider swiper swiperMain">
					<ul class="slider-main__list swiper-wrapper">

						<?php
						$first_slide = get_field('slider-main_group');
						?>
						<li class="slider-main__item swiper-slide">
							<h1 class="slider-main__title title-huge"><?php echo $first_slide['slider-main_group_title']; ?></h1>

							<?php
							if (!empty($first_slide['slider-main_group_pic'])) :
							?>
								<picture>
									<source media="(min-width: 1150px)" srcset="<?php echo esc_url($first_slide['slider-main_group_pic']['url']); ?>" width="487" height="328">
									<img class="slider-main__pic" src="<?php echo esc_url($first_slide['slider-main_group_pic']['url']); ?>" alt="<?php echo esc_attr($first_slide['slider-main_group_pic']['alt']); ?>" width="320" height="215">
								</picture>
							<?php endif; ?>

							<?php
							if (!empty($first_slide['slider-main_group_description'])) :
							?>
								<p class="slider-main__description text-normal"><?php echo $first_slide['slider-main_group_description']; ?></p>
							<?php endif; ?>
						</li>

						<?php if (have_rows('slider-main_repeater')) : ?>
							<?php while (have_rows('slider-main_repeater')) : the_row();
								$title = get_sub_field('slider-main_repeater_title');
								$image = get_sub_field('slider-main_repeater_pic');
								$description = get_sub_field('slider-main_repeater_description');
								if (!empty($title) || !empty($image) || !empty($description)) :
							?>
									<li class="slider-main__item swiper-slide">
										<span class="slider-main__title title-huge"><?php echo $title; ?></span>

										<?php
										if (!empty($image)) :
										?>
											<picture>
												<source media="(min-width: 1150px)" srcset="<?php echo esc_url($image['url']); ?>" width="487" height="328">
												<img class="slider-main__pic" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_url($image['alt']); ?>" width="320" height="215">
											</picture>
										<?php endif; ?>

										<?php
										if (!empty($description)) :
										?>
											<p class="slider-main__description text-normal"><?php echo $description; ?></p>
										<?php endif; ?>
									</li>
							<?php endif;
							endwhile; ?>
						<?php endif; ?>
					</ul>

					<div class="slider-main__controls">
						<button class="slider-main__control slider-main__control--prev">
							<svg class="slider-main__icon">
								<use href="<?php echo get_template_directory_uri(); ?>/build/img/svgsprite/sprite.symbol.svg#left-filled-arrow"></use>
							</svg>
						</button>
						<button class="slider-main__control slider-main__control--next">
							<svg class="slider-main__icon">
								<use href="<?php echo get_template_directory_uri(); ?>/build/img/svgsprite/sprite.symbol.svg#left-filled-arrow"></use>
							</svg>
						</button>
					</div>
				</div>
			</section>
		</div>
	</div>

	<?php
	$has_services = false;
	if (have_rows('services_repeater')) :
		while (have_rows('services_repeater')) : the_row();
			$has_services = true;
		endwhile;
	endif;
	?>

	<section class="services" id="services" <?php echo !$has_services ? 'style="display: none;"' : ''; ?>>
		<div class="container">
			<ul class="services__list">
				<?php if (have_rows('services_repeater')) : ?>
					<?php while (have_rows('services_repeater')) : the_row(); ?>
						<?php
						$title = get_sub_field('services_repeater_title');
						$image = get_sub_field('services_repeater_pic-g');
						?>
						<li class="services__item services__item--first">
							<a class="services__link services__link--first" href="<?php the_sub_field('services_repeater_link'); ?>">
								<h2 class="services__title title-big"><?php echo $title; ?>
								</h2>

								<?php
								if (!empty($image['desktop-pic']) || !empty($image['mobile-pic'])) :
								?>
									<picture>
										<source media="(min-width: 1150px)" srcset="<?php echo esc_url($image['desktop-pic']['url']); ?>">
										<img class="services__pic" src="<?php echo esc_url($image['mobile-pic']['url']); ?>" alt="<?php echo esc_attr($image['mobile-pic']['alt']); ?>">
									</picture>
								<?php endif; ?>
							</a>
						</li>
					<?php endwhile; ?>
				<?php endif; ?>
			</ul>
		</div>
	</section>

	<section class="consultation" <?php echo !empty(get_field('consultation_button')) ? '' : 'style="display: none;"'; ?>>
		<div class="container">
			<div class="consultation__container">
				<h2 class="consultation__title title-big"><?php the_field('consultation_title'); ?></h2>
				<p class="consultation__description text-medium"><?php the_field('consultation_description'); ?></p>
				<button class="consultation__button consultation-button text-medium"><?php the_field('consultation_button'); ?></button>
			</div>
		</div>
	</section>

	<?php
	$has_slides = false;
	if (have_rows('slider-about-main_repeater')) :
		while (have_rows('slider-about-main_repeater')) : the_row();
			$has_slides = true;
		endwhile;
	endif;
	?>

	<div class="page-main__bottom-columns" <?php echo !$has_slides || !get_field('about_description-g') ? 'style="grid-template-columns: auto;"' : ''; ?>>
		<section class="slider-about" <?php echo !$has_slides ? 'style="display: none;"' : ''; ?>>
			<div class="slider-about__slider swiper swiperAbout">
				<ul class="slider-about__list swiper-wrapper">
					<?php if (have_rows('slider-about-main_repeater')) : ?>
						<?php while (have_rows('slider-about-main_repeater')) : the_row(); ?>
							<li class="slider-about__item swiper-slide">
								<h2 class="slider-about__title title-big"><?php the_sub_field('slider-about-main_repeater_title'); ?></h2>

								<?php
								$image = get_sub_field('slider-about-main_repeater_pic');
								if ($image) :
								?>
									<picture>
										<source media="(min-width: 1150px)" srcset="<?php echo esc_url($image['url']); ?>" width="456" height="227">
										<img class="slider-main__pic" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_url($image['alt']); ?>" width="320" height="159">
									</picture>
								<?php endif; ?>

								<span class="slider-about__name text-medium"><?php the_sub_field('slider-about-main_repeater_subtitle'); ?></span>
								<p class="slider-about__description text-medium"><?php the_sub_field('slider-about-main_repeater_description'); ?>
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


		<?php
		$description = get_field('about_description-g');
		if ($description) :
		?>
			<section class="about">
				<div class="container-no-padding">
					<div class="about__container">
						<h2 class="about__title title-big"><?php the_field('about_title'); ?></h2>
						<div class="about__description text-medium">
							<?php echo $description['desc-1']; ?>
						</div>
					</div>
				</div>

				<div class="about__services">
					<div class="container-no-padding">
						<div class="about__description text-medium">
							<?php echo $description['desc-2']; ?>
						</div>
					</div>
				</div>
				<div class="container-no-padding">
					<div class="about__container">
						<div class="about__description text-medium">
							<?php echo $description['desc-3']; ?>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

	</div>
</main>
<?php get_footer(); ?>