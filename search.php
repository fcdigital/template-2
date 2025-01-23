<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package template-2
 */

get_header();
?>

<main class="page-search container">

	<?php if (have_posts()) : ?>


		<h1 class="page-search__title title-big">
			<?php
			/* translators: %s: search query. */
			printf(esc_html__('Результаты поиска по запросу: %s', 'template-2'), '<span>' . get_search_query() . '</span>');
			?>
		</h1>

		<section class="search">
			<ul class="search__list">
				<?php
				/* Start the Loop */
				while (have_posts()) :
					the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part('template-parts/content', 'search');

				endwhile;
				?>

			</ul>
		</section>

	<?php

		the_posts_navigation();

	else :

		get_template_part('template-parts/content', 'none');

	endif;
	?>




</main><!-- #main -->

<?php
get_footer();
