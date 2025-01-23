<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package template-2
 */

?>

<footer class="footer text-medium">
	<div class="footer__container container">

		<?php
		$has_menu = false;
		if (have_rows('menu_repeater', 'options')) :
			while (have_rows('menu_repeater', 'options')) : the_row();
				$has_menu = true;
			endwhile;
		endif;

		$copyright = get_field('copyright', 'options');

		if ($has_menu || $copyright) :
		?>
			<div class="footer__column-1">
				<?php if (have_rows('menu_repeater', 'options')) : ?>
					<ul class="footer__menu-list">
						<?php while (have_rows('menu_repeater', 'options')) : the_row(); ?>
							<?php
							$link = get_sub_field('menu_repeater_link');
							$text = get_sub_field('menu_repeater_text');
							if ($text) :
							?>
								<li class="footer__menu-item">
									<a class="footer__menu-link" href="<?php echo esc_url($link); ?>"><?php echo esc_html($text); ?></a>
								</li>
							<?php endif; ?>
						<?php endwhile; ?>
					</ul>
				<?php endif; ?>
				<?php
				if ($copyright) :
				?>
					<div class="footer__copyright">
						<?php echo wp_kses_post($copyright);  ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php
		$phone = get_field('phone-footer_g', 'options');
		$address = get_field('address-g', 'options');
		$email = get_field('email', 'options');
		if ($address && $address['name'] || $phone || $email) :
		?>
			<div class="footer__column-2">
				<ul class="footer__contacts-list">

					<?php
					if ($phone) :
					?>
						<li class="footer__contacts-item">
							<a class="footer__phone" href="<?php echo esc_attr($phone['strict-form']); ?>">
								<pre><?php echo esc_html($phone['lenient-form']); ?></pre>
							</a>
						</li>
					<?php endif; ?>

					<?php
					if ($address && $address['name']) :
					?>
						<li class="footer__contacts-item">
							<a class="footer__address" href="<?php echo esc_url($address['map']); ?>" target="_blank"><?php echo esc_html($address['name']); ?></a>
						</li>
					<?php endif; ?>

					<?php
					if ($email) :
					?>
						<li class="footer__contacts-item">
							<a class="footer__email" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		<?php endif; ?>

		<div class="footer__column-3">
			<?php get_search_form(); ?>
			
			<?php
			$privacy = get_field('privacy-g', 'options');
			if ($privacy && $privacy['text']) :
			?>
				<a class="footer__privacy" href="<?php echo esc_attr($privacy['url']); ?>" target="_blank"><?php echo esc_html($privacy['text']); ?></a>
			<?php endif; ?>
		</div>
	</div>
</footer>

<section class="modal">
	<div class="modal__container">
		<div class="modal__close-wrapper">
			<button class="modal__close"></button>
		</div>
		<h2 class="modal__title title-large">Форма обратной связи</h2>
		<?php echo do_shortcode('[contact-form-7 id="d2e80a4" title="Форма обратной связи"]'); ?>
	</div>
</section>

<?php wp_footer(); ?>
</body>