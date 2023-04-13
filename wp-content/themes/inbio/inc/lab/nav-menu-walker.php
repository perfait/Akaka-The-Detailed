<?php
/**
 * Nav Menu API: Walker_Nav_Menu class
 *
 * @package WordPress
 * @subpackage Nav_Menus
 * @since 4.6.0
 */


if (!class_exists('Rainbow_Nav_Walker')) {
    class Rainbow_Nav_Walker extends Walker_Nav_Menu
    { 
        protected $icon_display;
        protected $text_display;
 
        function __construct($icon_display = false, $text_display = true)
        {
            $this->icon_display = $icon_display;
            $this->text_display = $text_display;
        }

        /**
         * What the class handles.
         *
         * @since 3.0.0
         * @var string
         *
         * @see Walker::$tree_type
         */
        public $tree_type = array('post_type', 'taxonomy', 'custom');

        /**
         * Database fields to use.
         *
         * @since 3.0.0
         * @todo Decouple this.
         * @var array
         *
         * @see Walker::$db_fields
         */
        public $db_fields = array(
            'parent' => 'menu_item_parent',
            'id' => 'db_id',
        );

        /**
         * Starts the list before the elements are added.
         *
         * @param string $output Used to append additional content (passed by reference).
         * @param int $depth Depth of menu item. Used for padding.
         * @param stdClass $args An object of wp_nav_menu() arguments.
         * @see Walker::start_lvl()
         *
         * @since 3.0.0
         *
         */
        public function start_lvl(&$output, $depth = 0, $args = array())
        {
            if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = str_repeat($t, $depth);

            // Default class.
            $classes = array('sub-menu inbio-submenu department-megamenu');

            /**
             * Filters the CSS class(es) applied to a menu list element.
             *
             * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
             * @param stdClass $args An object of `wp_nav_menu()` arguments.
             * @param int $depth Depth of menu item. Used for padding.
             * @since 4.8.0
             *
             */
            $class_names = join(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $output .= "{$n}{$indent}<ul$class_names>{$n}";
        }

        /**
         * Ends the list of after the elements are added.
         *
         * @param string $output Used to append additional content (passed by reference).
         * @param int $depth Depth of menu item. Used for padding.
         * @param stdClass $args An object of wp_nav_menu() arguments.
         * @see Walker::end_lvl()
         *
         * @since 3.0.0
         *
         */
        public function end_lvl(&$output, $depth = 0, $args = array())
        {
            if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = str_repeat($t, $depth);
            $output .= "$indent</ul>{$n}";
        }

        /**
         * Starts the element output.
         *
         * @param string $output Used to append additional content (passed by reference).
         * @param WP_Post $item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param stdClass $args An object of wp_nav_menu() arguments.
         * @param int $id Current item ID.
         * @see Walker::start_el()
         *
         * @since 3.0.0
         * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
         *
         */
        public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        {


            /**
             * Megamenu Options
             */
            $rainbow_external_link = '';
            $enable_mega_menu = '';
            $mega_menu_template = '';
            if (class_exists('acf')) {
                $rainbow_external_link = get_field('rainbow_external_link', $item);
                $enable_mega_menu = get_field('rainbow_enable_mega_menu', $item);
                $mega_menu_template = get_field('rainbow_select_mega_menu', $item);
            }
            global $post;
            $mega_menu_template_id = (!empty($mega_menu_template)) ? $mega_menu_template : '';
            if ('' != $mega_menu_template_id) {
                if (class_exists('Elementor\Plugin')) {
                    $mega_menu_template_id = (!empty($mega_menu_template)) ? $mega_menu_template : '';
                    if ('' != $mega_menu_template_id) {
                        $elementor = \Elementor\Plugin::instance();
                        $mega_menu_content = $elementor->frontend->get_builder_content_for_display($mega_menu_template_id);
                    }
                }
            }
            $mega_parent_class = (1 == $enable_mega_menu) ? 'megamenu-wrapper' : '';
            $rainbow_external_link = (1 == $rainbow_external_link) ? 'rainbow-external-link' : '';

            $post_type_class = 'inbio-post-type-' . get_post_type(get_the_ID());


            if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = ($depth) ? str_repeat($t, $depth) : '';

            $classes = empty($item->classes) ? array() : (array)$item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            // Mega menu class
            $classes[] = $mega_parent_class;
            $classes[] = $rainbow_external_link;
            // $classes[] = $post_type_class;


            /**
             * Filters the arguments for a single nav menu item.
             *
             * @param stdClass $args An object of wp_nav_menu() arguments.
             * @param WP_Post $item Menu item data object.
             * @param int $depth Depth of menu item. Used for padding.
             * @since 4.4.0
             *
             */
            $args = apply_filters('nav_menu_item_args', $args, $item, $depth);

            /**
             * Filters the CSS classes applied to a menu item's list item element.
             *
             * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
             * @param WP_Post $item The current menu item.
             * @param stdClass $args An object of wp_nav_menu() arguments.
             * @param int $depth Depth of menu item. Used for padding.
             * @since 3.0.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             */
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));

            if (in_array('menu-item-has-children', $classes)) {
                $class_names .= ' has-dropdown';
            }

            if (in_array('current-menu-item', $classes)) {
                $class_names .= ' is-active';
            }

            if (in_array('current-menu-parent', $classes)) {
                $class_names .= ' is-active ';
            }

            if (in_array('current-menu-ancestor', $classes)) {
                $class_names .= ' is-active';
            }


            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';


            /**
             * Filters the ID applied to a menu item's list item element.
             *
             * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
             * @param WP_Post $item The current menu item.
             * @param stdClass $args An object of wp_nav_menu() arguments.
             * @param int $depth Depth of menu item. Used for padding.
             * @since 3.0.1
             * @since 4.1.0 The `$depth` parameter was added.
             *
             */
            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $class_names . '>';

            $atts = array();
            $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            if ('_blank' === $item->target && empty($item->xfn)) {
                $atts['rel'] = 'noopener noreferrer';
            } else {
                $atts['rel'] = $item->xfn;
            }
            $atts['href'] = !empty($item->url) ? $item->url : '';
            $atts['aria-current'] = $item->current ? 'page' : '';

            /**
             * Filters the HTML attributes applied to a menu item's anchor element.
             *
             * @param array $atts {
             *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
             *
             * @type string $title Title attribute.
             * @type string $target Target attribute.
             * @type string $rel The rel attribute.
             * @type string $href The href attribute.
             * @type string $aria_current The aria-current attribute.
             * }
             * @param WP_Post $item The current menu item.
             * @param stdClass $args An object of wp_nav_menu() arguments.
             * @param int $depth Depth of menu item. Used for padding.
             * @since 3.6.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             */
            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            /** This filter is documented in wp-includes/post-template.php */
            $title = apply_filters('the_title', $item->title, $item->ID);

            /**
             * Filters a menu item's title.
             *
             * @param string $title The menu item's title.
             * @param WP_Post $item The current menu item.
             * @param stdClass $args An object of wp_nav_menu() arguments.
             * @param int $depth Depth of menu item. Used for padding.
             * @since 4.4.0
             *
             */


            $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
            $title = apply_filters('rainbow_navmenu_icon_item_title', $title, $item, $args, $depth, $this->icon_display, $this->text_display);

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';

            // Mega menu
            if (defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')) {
                if (!\Elementor\Plugin::$instance->preview->is_preview_mode()) {
                    if ('' != $mega_menu_template_id && 1 == $enable_mega_menu) {
                        $item_output .= '<ul class="megamenu-sub-menu department-megamenu"><li class="megamenu-item department-megamenu-wrap">' . $mega_menu_content . '</li></ul>';
                    }
                }
            }
            $item_output .= $args->after;

            /**
             * Filters a menu item's starting output.
             *
             * The menu item's starting output only includes `$args->before`, the opening `<a>`,
             * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
             * no filter for modifying the opening and closing `<li>` for a menu item.
             *
             * @param string $item_output The menu item's starting HTML output.
             * @param WP_Post $item Menu item data object.
             * @param int $depth Depth of menu item. Used for padding.
             * @param stdClass $args An object of wp_nav_menu() arguments.
             * @since 3.0.0
             *
             */
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        /**
         * Ends the element output, if needed.
         *
         * @param string $output Used to append additional content (passed by reference).
         * @param WP_Post $item Page data object. Not used.
         * @param int $depth Depth of page. Not Used.
         * @param stdClass $args An object of wp_nav_menu() arguments.
         * @since 3.0.0
         *
         * @see Walker::end_el()
         *
         */
        public function end_el(&$output, $item, $depth = 0, $args = array())
        {
            if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $output .= "</li>{$n}";
        }

    } // TvNavWalker
}
