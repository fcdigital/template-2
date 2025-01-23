<?php

/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package template-2
 */

?>


<li class="search__item">
	<h2 class="search__title text-pre-large">
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h2>

	<div class="search__description text-medium">
		<?php
		$about = get_field('about_description-g'); // для вывода описания Главной страницы
		$service = get_field('service-g'); // для вывода описания страницы Услуги
		$num_words = 33; // ограничение количества выводимых слов в описании

		// Вывести значение поля, если оно существует, иначе вывести отрывок
		if ($service) {
			echo wp_trim_words(wp_filter_nohtml_kses($service['description']), $num_words);
		} elseif ($about) {
			echo wp_trim_words(wp_filter_nohtml_kses($about['desc-1']), $num_words);
		} else {
			the_excerpt();
		}
		?>
	</div>
</li>
