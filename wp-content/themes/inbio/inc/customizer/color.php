<?php
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since inbio 1.0
 */
/**
 * rainbow_custom_customize_register
 */
if (!function_exists('rainbow_custom_customize_register')) {
    function rainbow_custom_customize_register()
    {
        /**
         * Custom Separator
         */
        class inbio_Separator_Custom_control extends WP_Customize_Control
        {
            public $type = 'separator';

            public function render_content()
            {
                ?>
                <p>
                <hr></p>
                <?php
            }
        }
    }

    add_action('customize_register', 'rainbow_custom_customize_register');
}

/**
 * Start Rainbow_Customize
 */
class Rainbow_Customize
{
    /**
     * This hooks into 'customize_register' (available as of WP 3.4) and allows
     * you to add new sections and controls to the Theme Customize screen.
     *
     * Note: To enable instant preview, we have to actually write a bit of custom
     * javascript. See rainbow_live_preview() for more.
     *
     * @see add_action('customize_register',$func)
     * @param \WP_Customize_Manager $wp_customize
     * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
     * @since inbio 1.0
     */
    public static function register($wp_customize)
    {

        //1. Define a new section (if desired) to the Theme Customizer
        $wp_customize->add_panel('rainbow_colors_options',
            array(
                'title' => esc_html__('Inbio Colors Options', 'inbio'), //Visible title of section
                'priority' => 35, //Determines what order this appears in
                'capability' => 'edit_theme_options', //Capability needed to tweak
                'description' => esc_html__('Allows you to customize some example settings for inbio.', 'inbio'), //Descriptive tooltip
            )
        );

        $wp_customize->add_section('rainbow_colors_main_options',
            array(
                'title' => esc_html__('Global Colors', 'inbio'), //Visible title of section
                'priority' => 10, //Determines what order this appears in
                'capability' => 'edit_theme_options', //Capability needed to tweak
                'panel' => 'rainbow_colors_options',
            )
        );

        /*************************
         * Primary
         ************************/
        $wp_customize->add_setting('color_primary',
            array(
                'default' => '#ff014f',
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport' => 'refresh',
                'sanitize_callback' => 'sanitize_hex_color'
            )
        );
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'rainbow_color_primary',
            array(
                'label' => esc_html__('Primary Color', 'inbio'),
                'settings' => 'color_primary',
                'priority' => 10,
                'section' => 'rainbow_colors_main_options',
            )
        ));

        /*************************
         * Primary Gradient Color From
         ************************/
        $wp_customize->add_setting('color_primary_gradient_from',
            array(
                'default' => '#6a67ce',
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport' => 'refresh',
                'sanitize_callback' => 'sanitize_hex_color'
            )
        );
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'rainbow_color_primary_gradient_from',
            array(
                'label' => esc_html__('Primary Gradient Color From', 'inbio'),
                'settings' => 'color_primary_gradient_from',
                'priority' => 10,
                'section' => 'rainbow_colors_main_options',
            )
        ));

        /*************************
         * Primary Gradient Color To
         ************************/
        $wp_customize->add_setting('color_primary_gradient_to',
            array(
                'default' => '#fc636b',
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport' => 'refresh',
                'sanitize_callback' => 'sanitize_hex_color'
            )
        );
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'rainbow_color_primary_gradient_to',
            array(
                'label' => esc_html__('Primary Gradient Color To', 'inbio'),
                'settings' => 'color_primary_gradient_to',
                'priority' => 10,
                'section' => 'rainbow_colors_main_options',
            )
        ));


    }

    /**
     * This will output the custom WordPress settings to the live theme's WP head.
     *
     * Used by hook: 'wp_head'
     *
     * @see add_action('wp_head',$func)
     * @since inbio 1.0
     */
    public static function rainbow_custom_color_output()
    {
        $color_primary = get_theme_mod('color_primary', '#ff014f');
        $primary_rgba_01 = rainbow_hex2rgba($color_primary, '0.1');
        ?>
        <!--Customizer CSS-->
        <style type="text/css">

            /************************************************************************************
             * General
             ************************************************************************************/
            /* Primary [#ff014f] */
            <?php self::rainbow_generate_css(':root', '--color-subtitle', 'color_primary'); ?>
            <?php self::rainbow_generate_css(':root', '--color-primary', 'color_primary'); ?>  
            <?php self::rainbow_generate_css('.rn-nav-list .nav-item .nav-link:hover, .rn-nav-list .nav-item .nav-link.active,.slide .content .inner .title span,.banner-details-wrapper-sticky .banner-title-area .title span', 'color  ', 'color_primary'); ?>

            <?php self::rainbow_generate_css(':root', '--color-primary-gradient-from', 'color_primary_gradient_from'); ?>
            <?php self::rainbow_generate_css(':root', '--color-primary-gradient-to', 'color_primary_gradient_to'); ?>
            
        </style>
        <!--/Customizer CSS-->
        <?php
    }

    /**
     * This will generate a line of CSS for use in header output. If the setting
     * ($mod_name) has no defined value, the CSS will not be output.
     *
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $style The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     * @param string $prefix Optional. Anything that needs to be output before the CSS property
     * @param string $postfix Optional. Anything that needs to be output after the CSS property
     * @param bool $echo Optional. Whether to print directly to the page (default: true).
     * @return string Returns a single line of CSS with selectors and a property.
     * @since inbio 1.0
     */
    public static function rainbow_generate_css($selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true)
    {
        $return = '';
        $mod = get_theme_mod($mod_name);
        if (!empty($mod)) {
            $return = sprintf('%s { %s:%s; }',
                $selector,
                $style,
                $prefix . $mod . $postfix
            );
            if ($echo) {
                echo rainbow_awescapeing($return);
            }
        }
        return $return;
    }

    /***
     * @param $selector
     * @param $angle
     * @param $from_color
     * @param $to_color
     * @param bool $echo
     * @return string
     */
    public static function rainbow_generate_gradient_angle($selector, $angle, $from_color, $to_color, $echo = true)
    {
        $return = '';
        $from_color = get_theme_mod($from_color, '#f81f01');
        $to_color = get_theme_mod($to_color, '#ee076e');
        if ($from_color || $to_color) {
            $return = sprintf('%s { background-image: linear-gradient(%s, %s, %s); }',
                $selector,
                $angle,
                $from_color,
                $to_color
            );
            if ($echo) {
                echo rainbow_awescapeing($return);
            }
        }
        return $return;
    }

    /**
     * @param $selector
     * @param $from_color
     * @param $from_color_default
     * @param $from
     * @param $to_color
     * @param $to_color_default
     * @param $to
     * @param bool $echo
     * @return string
     */
    public static function rainbow_generate_gradient_percentage($selector, $from_color, $from_color_default, $from,  $to_color, $to_color_default, $to, $echo = true)
    {
        $return = '';
        $from_color = get_theme_mod($from_color, $from_color_default);
        $to_color = get_theme_mod($to_color, $to_color_default);
        if ($from_color || $to_color) {
            $return = sprintf('%s { background-image: linear-gradient(%s %s, %s %s); }',
                $selector,
                $from_color,
                $from,
                $to_color,
                $to
            );
            if ($echo) {
                echo rainbow_awescapeing($return);
            }
        }
        return $return;
    }

    /**
     * @param $selector
     * @param $angle
     * @param $from_color
     * @param $from_color_default
     * @param $from
     * @param $to_color
     * @param $to_color_default
     * @param $to
     * @param bool $echo
     * @return string
     */
    public static function rainbow_generate_gradient_angle_percentage($selector, $angle, $from_color, $from_color_default, $from,  $to_color, $to_color_default, $to, $echo = true)
    {
        $return = '';
        $from_color = get_theme_mod($from_color, $from_color_default);
        $to_color = get_theme_mod($to_color, $to_color_default);
        if ($from_color || $to_color) {
            $return = sprintf('%s { background-image: linear-gradient(%s, %s %s, %s %s); }',
                $selector,
                $angle,
                $from_color,
                $from,
                $to_color,
                $to
            );
            if ($echo) {
                echo rainbow_awescapeing($return);
            }
        }
        return $return;
    }

    /**
     * @param $selector
     * @param $attributes
     * @param bool $echo
     * @return string
     */
    public static function rainbow_generate_box_shadow($selector, $attributes, $echo = true)
    {
        $return = '';
        if ($attributes) {
            $return = sprintf('%s { box-shadow: %s; }',
                $selector,
                $attributes
            );
            if ($echo) {
                echo rainbow_awescapeing($return);
            }
        }
        return $return;
    }

}

// Setup the Theme Customizer settings and controls...
add_action('customize_register', array('Rainbow_Customize', 'register'));

// Output custom CSS to live site
add_action('wp_head', array('Rainbow_Customize', 'rainbow_custom_color_output'));


