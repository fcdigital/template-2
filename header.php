<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package template-2
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/build/img/favicons/favicon.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/build/img/favicons/apple-touch-icon.png">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<header class="header">
		<div class="header__columns container-no-padding">
			<div class="header__column-1">

				<?php
				$image = get_field('logo', 'options');
				if (!empty($image)) :
				?>
					<a class="header__logo" <?php if (!is_front_page()) : ?> href="/" <?php else : ?> href="#" style="pointer-events: none; cursor: default;" <?php endif; ?> aria-label="<?php echo esc_attr($image['alt']); ?>">
						<img class="header__shortcut-logo style-svg" src="<?php echo esc_url($image['url']); ?>">
					</a>
				<?php endif; ?>

				<div class="header__contacts">

					<?php
					$phone = get_field('phone_g', 'options');
					if ($phone) :
					?>
						<a class="header__phone text-medium" href="tel:<?php echo $phone['strict-form']; ?>">
							<pre><?php echo $phone['lenient-form'] ?></pre>
						</a>
					<?php endif; ?>

					<div class="header__social social">
						<?php if (have_rows('social_repeater', 'options')) : ?>
							<ul class="social__list">
								<?php while (have_rows('social_repeater', 'options')) : the_row(); ?>
									<?php
									$image = get_sub_field('social_repeater_pic');
									if ($image) :
									?>
										<li class="social__item">
											<a class="social__list" href="<?php the_sub_field('social_repeater_link'); ?>" aria-label=<?php echo esc_attr($image['alt']); ?>>
												<img class="social__icon style-svg" src="<?php echo esc_url($image['url']); ?>">
											</a>
										</li>
									<?php endif; ?>
								<?php endwhile; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="header__column-2">
				<?php get_search_form(); ?>
				<button class="header__nav-toggle" type="button" aria-label="Открыть навигацию по сайту">
					<div class="header__nav-icon"></div>
				</button>
			</div>
		</div>
		<style>
			:root {
				--theme-color: <?php the_field('color', 'options'); ?>;
				--theme-color-transparent: <?php the_field('color-transparent', 'options'); ?>;
			}
		</style>
	</header>

	<div class="nav">
		<div class="nav__columns text-large">
			<div class="nav__column-1">
				<span class="nav__name">Услуги</span>
				<?php wp_nav_menu(array(
					'theme_location' => 'main_menu_1',
					'container'      => '',
					'menu_class'      => 'nav__list',
				)); ?>
			</div>
			<div class="nav__column-2">
				<?php wp_nav_menu(array(
					'theme_location' => 'main_menu_2',
					'container'      => '',
					'menu_class'      => 'nav__list',
				)); ?>
			</div>
		</div>
	</div>