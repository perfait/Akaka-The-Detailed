<?php
/**
 * @author  Rainbow-Themes
 * @since   1.0
 * @version 1.0
 */

use Elementor\Plugin;

class Rainbow_Scripts
{

    public $version;
    protected static $instance = null;

    public function __construct()
    {

        add_action('wp_enqueue_scripts', array($this, 'rainbow_register_scripts'), 12);
        add_action('wp_enqueue_scripts', array($this, 'rainbow_enqueue_scripts'), 15);
        add_action('admin_enqueue_scripts', array($this, 'rainbow_admin_scripts'), 15);

    }

    public static function instance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function rainbow_register_scripts()
    {
        wp_register_style('bootstrap-min', Rainbow_Helper::get_vendor_css('bootstrap.min'), array(), RAINBOW_VERSION);
        wp_register_style('bootstrap-min-rtl', Rainbow_Helper::get_rtl_css('vendor/bootstrap.min'), array(), RAINBOW_VERSION);
        wp_register_style('slick', Rainbow_Helper::get_vendor_css('slick'), array(), RAINBOW_VERSION);
        wp_register_style('slick-theme', Rainbow_Helper::get_vendor_css('slick-theme'), array(), RAINBOW_VERSION);
        wp_register_style('aos', Rainbow_Helper::get_vendor_css('aos'), array(), RAINBOW_VERSION);
        wp_register_style('font-awesome-free', Rainbow_Helper::get_vendor_css('fontawesome'), array(), RAINBOW_VERSION);
        wp_register_style('feature', Rainbow_Helper::get_plugins_css('feature'), array(), RAINBOW_VERSION);
        wp_register_style('inbio-style', Rainbow_Helper::get_css('style'), array(), RAINBOW_VERSION);
        wp_register_style('inbio-woocommerce', rainbow_helper::get_css('rainbow-woocommerce'), array(), RAINBOW_VERSION);
        wp_register_style('magnific-popup', Rainbow_Helper::get_vendor_css('magnific-popup'), array(), RAINBOW_VERSION);
        wp_register_style('plyr', Rainbow_Helper::get_vendor_css('plyr'), array(), RAINBOW_VERSION);


        wp_register_script('jquery-magnific-popup-min', Rainbow_Helper::get_vendor_js('jquery.magnific-popup.min'), array(), RAINBOW_VERSION);
        wp_register_script('plyr', Rainbow_Helper::get_vendor_js('plyr.min'), array(), RAINBOW_VERSION);
        wp_register_style('inbio-gfonts', $this->rainbow_fonts_url(), array(), RAINBOW_VERSION); // Google fonts
        wp_register_script('feather-min', Rainbow_Helper::get_vendor_js('feather.min'), array('jquery'), RAINBOW_VERSION, true);
        wp_register_script('slick-min', Rainbow_Helper::get_vendor_js('slick.min'), array('jquery'), RAINBOW_VERSION, true);
        wp_register_script('bootstrap', Rainbow_Helper::get_vendor_js('bootstrap'), array('jquery'), RAINBOW_VERSION, true);
        wp_register_script('text-type', Rainbow_Helper::get_vendor_js('text-type'), array('jquery'), RAINBOW_VERSION, true);
        wp_register_script('wow', Rainbow_Helper::get_vendor_js('wow'), array('jquery'), RAINBOW_VERSION, true);
        wp_register_script('aos', Rainbow_Helper::get_vendor_js('aos'), array('jquery'), RAINBOW_VERSION, true);
        wp_register_script('particles-js', Rainbow_Helper::get_vendor_js('particles'), array('jquery'), RAINBOW_VERSION, true);
        wp_register_script('jquery-one-page-nav', Rainbow_Helper::get_vendor_js('jquery-one-page-nav'), array('jquery'), RAINBOW_VERSION, true);
        wp_register_script('inbio-intro-video', Rainbow_Helper::get_vendor_js('intro-video'), array('jquery'), RAINBOW_VERSION, true);


        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        wp_register_script('inbio-main', Rainbow_Helper::get_js('main'), array('jquery'), RAINBOW_VERSION, true);
        wp_register_script('inbio-main-rtl', Rainbow_Helper::get_rtl_js('main'), array('jquery'), RAINBOW_VERSION, true);
        wp_register_script('inbio-has-elementor', Rainbow_Helper::get_js('has-elementor'), array('jquery'), RAINBOW_VERSION, true);

        wp_register_script('inbio-has-elementor-rtl', Rainbow_Helper::get_rtl_js('has-elementor'), array('jquery'), RAINBOW_VERSION, true);
        wp_register_script('inbio-has-app', Rainbow_Helper::get_js('app'), array('jquery'), RAINBOW_VERSION, true);
  
    }

    public function rainbow_enqueue_scripts()
    {

        /* CSS */
        wp_enqueue_style('inbio-gfonts');
        wp_enqueue_style('slick');
        wp_enqueue_style('slick-theme');

        if ( is_rtl() ) {
            wp_enqueue_style('bootstrap-min-rtl');
        } else {
            wp_enqueue_style('bootstrap-min');
        }

        wp_enqueue_style('sal');
        wp_enqueue_style('aos');
        wp_enqueue_style('font-awesome-free');
        wp_enqueue_style('feature');
        wp_enqueue_style('inbio-woocommerce');
        wp_enqueue_style( 'magnific-popup' );
        wp_enqueue_style( 'plyr' );


        $this->rainbow_fonts_url();
        $this->rainbow_elementor_scripts(); 
        wp_enqueue_style('inbio-style');

        wp_enqueue_style('inbio-one-style', get_stylesheet_uri());
        wp_style_add_data( 'inbio-one-style', 'rtl', 'replace' );

        wp_enqueue_script('feather-min'); 
        wp_enqueue_script('slick-min');
        wp_enqueue_script('bootstrap');
        wp_enqueue_script('text-type');
        wp_enqueue_script('wow');
        wp_enqueue_script('sal');
        wp_enqueue_script('aos');
        wp_enqueue_script('jquery-one-page-nav');
        wp_enqueue_script('jquery-magnific-popup-min');
        wp_enqueue_script('plyr');
        wp_enqueue_script('inbio-intro-video');

        if ( is_rtl() ) {
            wp_enqueue_script('inbio-main-rtl');
            wp_enqueue_script('inbio-has-elementor-rtl');
        } else {
            wp_enqueue_script('inbio-main');
            wp_enqueue_script('inbio-has-elementor');
        }


        $this->rainbow_localized_scripts(); // Localization
        $this->rainbow_localized_scripts2(); // Localization

    }

    public function rainbow_elementor_scripts()
    {
        if (!did_action('elementor/loaded')) {
            return;
        }
        if (Plugin::$instance->preview->is_preview_mode()) {

            wp_enqueue_style('inbio-gfonts');
            wp_enqueue_style('bootstrap-min');
            wp_enqueue_style('sal');
            wp_enqueue_style('slick');
            wp_enqueue_style('slick-theme');
            wp_enqueue_style('aos');
            wp_enqueue_style('font-awesome-free');
            wp_enqueue_style('feature');
            wp_enqueue_script('slick-min');
            wp_enqueue_script('bootstrap');
            wp_enqueue_script('text-type');
            wp_enqueue_script('wow');
            wp_enqueue_script('sal');
            wp_enqueue_script('aos'); 
            wp_enqueue_script('feather-min');
            wp_enqueue_style('inbio-woocommerce');
            wp_enqueue_style( 'magnific-popup' );
            wp_enqueue_script('jquery-magnific-popup-min');
            wp_enqueue_style( 'plyr' );
            wp_enqueue_script('plyr');

        }
    }


    public function rainbow_admin_scripts()
    {

        wp_enqueue_style('inbio-wp-admin', Rainbow_Helper::get_admin_css('admin-style'), array(), RAINBOW_VERSION);

        if (is_rtl()) {
            wp_enqueue_style('inbio-rtl-admin', Rainbow_Helper::get_admin_css('admin-style'), array(), RAINBOW_VERSION);
        }

        // JS
        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-tabs');

    }

    private function rainbow_fonts_url()
    {
        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';
        /* translators: If there are characters in your language that are not supported by Poppins, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Poppins font: on or off', 'inbio')) {
            $fonts[] = 'Poppins:wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,700&display=swap';

        }

        /* translators: If there are characters in your language that are not supported by Yantramanav, translate this to 'off'. Do not translate into your own language. */


        if ('off' !== esc_attr_x('on', 'Montserrat font: on or off', 'inbio')) {

            $fonts[] = 'Montserrat:wght@400,500,600,700,800&display=swap';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urlencode(implode('|', $fonts)),
                'subset' => urlencode($subsets),
            ), 'https://fonts.googleapis.com/css');
        }
        return $fonts_url;
    }


    private function rainbow_localized_scripts()
    {
  

        $localize_data = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'hasAdminBar' => is_admin_bar_showing() ? 1 : 0,
            'rtl' => is_rtl() ? 'yes' : 'no', //@rtl

        );
        wp_localize_script('inbio-has-elementor', 'RainbowObj', $localize_data);
        wp_localize_script('inbio-has-elementor-rtl', 'RainbowObj', $localize_data);
    }

    private function rainbow_localized_scripts2()
    {
        $rainbow_options        = Rainbow_Helper::rainbow_get_options();
        $rainbow_header_offset  = rainbow_get_acf_data("rainbow_header_offset");
        $rainbow_header_offset_on  = rainbow_get_acf_data("rainbow_header_offset_on");

        if ($rainbow_header_offset_on) {
            $rainbow_header_offset  = $rainbow_header_offset;

        } else {
            $rainbow_header_offset  = $rainbow_options['rainbow_header_offset'];
        }
          
        $localize_data2 = array( 
            'header_offset' => $rainbow_header_offset,

        );
        wp_localize_script('jquery-one-page-nav', 'RainbowBavObj', $localize_data2 );
    }

}

Rainbow_Scripts::instance();