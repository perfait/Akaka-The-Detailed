<?php
/**
 * Inbio functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package inbio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Define Constants
 */
define('RAINBOW_THEME_URI', get_template_directory_uri());
define('RAINBOW_THEME_DIR', get_template_directory());
define('RAINBOW_CSS_URL', get_template_directory_uri() . '/assets/css/');
define('RAINBOW_RTL_CSS_URL', get_template_directory_uri() . '/assets/css/rtl/');
define('RAINBOW_CSS_FICON_URL', get_template_directory_uri() . '/assets/flaticon/');
define('RAINBOW_JS_URL', get_template_directory_uri() . '/assets/js/');
define('RAINBOW_RTL_JS_URL', get_template_directory_uri() . '/assets/js/rtl/');
define('RAINBOW_ADMIN_CSS_URL', get_template_directory_uri() . '/assets/admin/css/');
define('RAINBOW_ADMIN_JS_URL', get_template_directory_uri() . '/assets/admin/js/');
define('RAINBOW_DIRECTORY', RAINBOW_THEME_DIR . '/inc/');
define('RAINBOW_DIRECTORY_VIEW', RAINBOW_THEME_DIR . '/inc/views/');
define('RAINBOW_HELPER', RAINBOW_THEME_DIR . '/inc/helper/');
define('RAINBOW_OPTIONS', RAINBOW_THEME_DIR . '/inc/options/');
define('RAINBOW_CUSTOMIZER', RAINBOW_THEME_DIR . '/inc/customizer/');
define('RAINBOW_THEME_FIX', 'inbio');
define('RAINBOW_THEME_PT_PREFIX', 'rainbow');
define('RAINBOW_LAB', RAINBOW_THEME_DIR . '/inc/lab/');
define('RAINBOW_WOOCMMERCE', RAINBOW_THEME_DIR . '/woocommerce/custom/');
define('RAINBOW_TP', RAINBOW_THEME_DIR . '/template-parts/');
define('RAINBOW_IMG_URL', RAINBOW_THEME_URI . '/assets/images/logo/');
do_action('rainbow_theme_init');
$rainbow_theme_data = wp_get_theme();
define('RAINBOW_VERSION', (WP_DEBUG) ? time() : $rainbow_theme_data->get('Version'));


if (!function_exists('rainbow_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function rainbow_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on inbio, use a find and replace
         * to change 'inbio' to the name of your theme in all the template files.
         */
        load_theme_textdomain('inbio', get_template_directory() . '/languages');

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
            'primary' => esc_html__('Primary', 'inbio'),
            'sidenav' => esc_html__('SideNavs Icon Menu', 'inbio'),

        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */

        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /*
         * Post Format
         */
        add_theme_support('post-formats', array('gallery', 'link', 'quote', 'video', 'audio'));
        remove_theme_support('widgets-block-editor');

        add_editor_style(array('style-editor.css', rainbow_fonts_url()));
        add_theme_support('responsive-embeds');
        add_theme_support('wp-block-styles');
        add_theme_support('editor-styles');
        add_editor_style('style-editor.css');


        /*
         * Color Support
         */
        add_theme_support('align-wide');
        add_theme_support('editor-color-palette', array(
            array(
                'name' => esc_html__('Primary', 'inbio'),
                'slug' => 'inbio-primary',
                'color' => '#ff014f',
            ),
            array(
                'name' => esc_html__('Secondary', 'inbio'),
                'slug' => 'inbio-secondary',
                'color' => '#FFDC60',
            ),
            array(
                'name' => esc_html__('Tertiary', 'inbio'),
                'slug' => 'inbio-tertiary',
                'color' => '#FAB8C4',
            ),
            array(
                'name' => esc_html__('White', 'inbio'),
                'slug' => 'inbio-white',
                'color' => '#ffffff',
            ),
            array(
                'name' => esc_html__('Dark', 'inbio'),
                'slug' => 'inbio-dark',
                'color' => '#27272E',
            ),
        ));
        /*
         * Font Size
         */
        add_theme_support('editor-font-sizes', array(
            array(
                'name' => esc_html__('Small', 'inbio'),
                'size' => 12,
                'slug' => 'small'
            ),
            array(
                'name' => esc_html__('Normal', 'inbio'),
                'size' => 16,
                'slug' => 'normal'
            ),
            array(
                'name' => esc_html__('Large', 'inbio'),
                'size' => 36,
                'slug' => 'large'
            ),
            array(
                'name' => esc_html__('Huge', 'inbio'),
                'size' => 50,
                'slug' => 'huge'
            )
        ));

        /*
         * Add Custom Image Size
         */
        add_image_size('rainbow-thumbnail-sm', 340, 250, true);
        add_image_size('rainbow-thumbnail-md', 400, 400, true);
        add_image_size('rainbow-thumbnail-lg', 800, 600, true);
        add_image_size('rainbow-thumbnail-archive', 800, 450, true);
        add_image_size('rainbow-thumbnail-single', 1220, 686, true);

    }
endif;
add_action('after_setup_theme', 'rainbow_setup');


add_filter('image_size_names_choose', 'rainbow_new_image_sizes');
if (!function_exists('rainbow_new_image_sizes')) {
    /**
     * Image Size Name Choose
     *
     * @param $sizes
     * @return array
     */
    function rainbow_new_image_sizes($sizes)
    {
        return array_merge($sizes, array(
            'rainbow-thumbnail-sm' => esc_html__('Thumbnail Small - (335x250)', 'inbio'),
            'rainbow-thumbnail-md' => esc_html__('Thumbnail Medium - (400x400)', 'inbio'),
            'rainbow-thumbnail-lg' => esc_html__('Thumbnail large - (800x600)', 'inbio'),
            'rainbow-thumbnail-archive' => esc_html__('Thumbnail Archive - (800x450)', 'inbio'),
            'rainbow-thumbnail-single' => esc_html__('Thumbnail Single - (1220x686)', 'inbio'),
        ));
    }
}


if (!function_exists('rainbow_content_width')) {
    /**
     * Set the content width in pixels, based on the theme's design and stylesheet.
     *
     * Priority 0 to make it available to lower priority callbacks.
     *
     * @global int $content_width
     */
    function rainbow_content_width()
    {
        // This variable is intended to be overruled from themes.
        // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
        $GLOBALS['content_width'] = apply_filters('rainbow_content_width', 640);
    }
}

add_action('after_setup_theme', 'rainbow_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
require_once(RAINBOW_DIRECTORY . "scripts.php");

/**
 * Global Functions
 */
require_once(RAINBOW_DIRECTORY . "global-functions.php");

/**
 * Register Custom Widget Area
 */
require_once(RAINBOW_DIRECTORY . "widget-area-register.php");

/**
 * Register Custom Fonts
 */
require_once(RAINBOW_DIRECTORY . "register-custom-fonts.php");

/**
 * TGM
 */
require_once(RAINBOW_DIRECTORY . "tgm-config.php");

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/underscore/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/underscore/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/underscore/template-functions.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/underscore/jetpack.php';
}

/**
 * Helper Template
 */
require_once(RAINBOW_HELPER . "menu-area-trait.php");
require_once(RAINBOW_HELPER . "layout-trait.php");
require_once(RAINBOW_HELPER . "option-trait.php");
require_once(RAINBOW_HELPER . "meta-trait.php");
require_once(RAINBOW_HELPER . "banner-trait.php");
require_once(RAINBOW_HELPER . "social-trait.php");
require_once(RAINBOW_HELPER . "page-title-trait.php");
require_once(RAINBOW_HELPER . "pagination-trai.php");

/**
 * Helper
 */
require_once(RAINBOW_HELPER . "helper.php");

/**
 * Options
 */
require_once(RAINBOW_OPTIONS . "theme/option-framework.php");
require_once(RAINBOW_OPTIONS . "page-options.php");
require_once(RAINBOW_OPTIONS . "portfolio-options.php");
require_once(RAINBOW_OPTIONS . "post-format-options.php");
require_once(RAINBOW_OPTIONS . "user-extra-meta.php");
require_once(RAINBOW_OPTIONS . "menu-options.php");
require_once(RAINBOW_OPTIONS . "team-extra-meta.php");

/**
 * Customizer
 */
require_once(RAINBOW_CUSTOMIZER . "color.php");

/**
 * Lab
 */
require_once(RAINBOW_LAB . "class-tgm-plugin-activation.php");

/**
 * Nav Walker
 */
require_once(RAINBOW_LAB . "nav-menu-walker.php");
require_once(RAINBOW_LAB . "mobile-menu-walker.php");
require_once(RAINBOW_TP . "breadcrumb.php");
require_once(RAINBOW_LAB . "post-views.php");
 
/**
 * WooCommerce
 */
if (class_exists('WooCommerce')) {
    require_once(RAINBOW_WOOCMMERCE . "wooc-functions.php");
    require_once(RAINBOW_WOOCMMERCE . "wooc-hooks.php");
}
/**
 * Ajax actions
 */
add_action('wp_ajax_rainbow_loadmore_projects', 'rainbow_loadmore_projects');
add_action('wp_ajax_nopriv_rainbow_loadmore_projects', 'rainbow_loadmore_projects');


function rainbow_loadmore_projects()
{
    $html = null;
    $posttype = 'rainbow_projects';

    $settings = $_POST['data'];

    $page = absint($_POST['page']) + 1;

    $posts_per_page = $settings['posts_per_page'];

    $category_list = '';
    if (!empty($settings['category'])) {
        $category_list = implode(", ", $settings['category']);
    }
    $category_list_value = explode(" ", $category_list);
    $taxonomy = 'rainbow_projects_category';

    $args = array(

        'post_type' => $posttype,
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $page

    );

    $query = new WP_Query($args);

    $col_class = "col-lg-{$settings['col_lg']} col-md-{$settings['col_md']} col-sm-{$settings['col_sm']} col-{$settings['col']}";
    $temp = Rainbow_Helper::wp_set_temp_query($query);
    if ($query->have_posts()) :
        if ($query->max_num_pages == $page) {
            $remaining = false;
        }
        ob_start();

        include('template-parts/portfolio-grid-1.php');

    else:
        $remaining = false;
    endif;
    $html = ob_get_clean();
    $var = $_POST;
    wp_send_json(compact('html', 'page', 'remaining', 'query'));
}



