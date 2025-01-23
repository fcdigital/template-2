<?php

/**
 * template-2 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package template-2
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function template_2_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on template-2, use a find and replace
		* to change 'template-2' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('template-2', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.

	register_nav_menus(array(
		'main_menu_1' => 'Главная навигация, 1 колонка',
		'main_menu_2' => 'Главная навигация, 2 колонка',
		'side_menu' => 'Боковое меню',
	));


	// add_action('after_setup_theme', 'theme_register_nav_menu');

	// function theme_register_nav_menu() {
	// 	register_nav_menu('side-menu', 'Боковое меню');
	// }

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'template_2_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'template_2_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function template_2_content_width()
{
	$GLOBALS['content_width'] = apply_filters('template_2_content_width', 640);
}
add_action('after_setup_theme', 'template_2_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function template_2_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'template-2'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'template-2'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'template_2_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function template_2_scripts()
{
	wp_enqueue_style('template-2-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('template-2-style', 'rtl', 'replace');

	wp_enqueue_script('template-2-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'template_2_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/* Вывод в админку настроек сайта */

if (function_exists("acf_add_options_page")) {
	acf_add_options_page(array(
		"page_title" => "Настройки сайта",
		"menu_title" => "Настройки сайта",
		"menu_slug"  => "theme_settings",
	));
}

/* Подключение стилей */

add_action('wp_enqueue_scripts', 'theme_styles');

function theme_styles()
{
	if (is_page_template(['page-main.php', 'page-service-list.php'])) {
		wp_register_style('swiper-style', '//cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', false, '', '');
		wp_enqueue_style('swiper-style');

		wp_register_style('custom-style', get_template_directory_uri() . '/build/css/main.css', ['swiper-style'], '', '');
		wp_enqueue_style('custom-style');
	} elseif (is_page_template('page-service.php')) {
		wp_register_style('simplebar-style', '//cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css', false, '', '');
		wp_enqueue_style('simplebar-style');

		wp_register_style('swiper-style', '//cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', false, '', '');
		wp_enqueue_style('swiper-style');

		wp_register_style('custom-style', get_template_directory_uri() . '/build/css/main.css', ['swiper-style', 'simplebar-style'], '', '');
		wp_enqueue_style('custom-style');
	} else {
		wp_register_style('custom-style', get_template_directory_uri() . '/build/css/main.css', false, '', '');
		wp_enqueue_style('custom-style');
	}
}

/* Подключение скриптов */

add_action('wp_enqueue_scripts', 'theme_scripts');

function theme_scripts()
{
	if (is_page_template(['page-main.php', 'page-service-list.php', 'page-service.php'])) {
		wp_register_script('swiper-script', '//cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', false, '', true);
		wp_enqueue_script('swiper-script');
	}

	if (is_page_template('page-main.php')) {
		wp_register_script('custom-main-script', get_template_directory_uri() . '/build/js/index.bundle.js', ['swiper-script'], '', true);
		wp_enqueue_script('custom-main-script');
	} elseif (is_page_template('page-service-list.php')) {
		wp_register_script('custom-service-list-script', get_template_directory_uri() . '/build/js/services.bundle.js', ['swiper-script'], '', true);
		wp_enqueue_script('custom-service-list-script');
	} elseif (is_page_template('page-service.php')) {
		wp_register_script('simplebar-script', '//cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js', false, '', true);
		wp_enqueue_script('simplebar-script');

		wp_register_script('custom-service-script', get_template_directory_uri() . '/build/js/specificService.bundle.js', ['swiper-script', 'simplebar-script'], '', true);
		wp_enqueue_script('custom-service-script');
	} else {
		wp_register_script('custom-simple-pages-script', get_template_directory_uri() . '/build/js/simplePagesNavigation.bundle.js', false, '', true);
		wp_enqueue_script('custom-simple-pages-script');
	}
}

function custom_excerpt_for_service_page($excerpt) {
    // Проверить, используется ли шаблон page-service.php
    if (is_page()) {
        // Проверить, используется ли шаблон page-service.php
        if (is_page_template('page-service.php')) {
            // Получить значение поля ACF 'service_g_description'
            $service_g_description = get_field('service_g_description');

            // Если поле заполнено, вернуть его значение
            if ($service_g_description) {
                return $service_g_description;
            }
        }
    }

    // Если не используется шаблон page-service.php или поле пустое, вернуть стандартный отрывок
    return $excerpt;
}
add_filter('the_excerpt', 'custom_excerpt_for_service_page');
