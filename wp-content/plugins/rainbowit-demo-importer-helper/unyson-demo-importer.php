<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class Rainbow_Demo_Importer {
	public function __construct() {		
		add_filter( 'rainbowit_demo_installer_warning_info', array( $this, 'rainbowit_data_loss_warning' ) );
		add_filter( 'fw:ext:backups-demo:demos', array( $this, 'rainbowit_demo_config' ) );
		add_action( 'fw:ext:backups:tasks:success:id:demo-content-install', array( $this, 'rainbowit_after_demo_install' ) );
		add_action( 'admin_menu', array( $this, 'wpdocs_register_my_custom_menu_page' ) );
		//add_filter( 'fw:ext:backups:add-restore-task:image-sizes-restore', '__return_false' ); // Enable it to skip image restore step

        add_action('admin_footer', array($this, 'rainbowit_demo_footer_add_scripts') );

	}	
	public function wpdocs_register_my_custom_menu_page() {
		add_management_page(esc_html__( 'Demo Contents Install', 'rainbowitdemo' ), 'Install Demo Data', 'manage_options', 'tools.php?page=fw-backups-demo-content');
	}	
	
	public function rainbowit_data_loss_warning( $links ) {
		$html  = '<div class="demo-warning-info notice notice-error">';
		$html .= esc_html__( 'Warning: All your old data will be lost if you install One Click demo data from here, so it is suitable only for a new website.', 'rainbowitdemo');
		$html .= '</div>';
		return $html;
	}
	public function rainbowit_demo_config( $demos ) {
		$demos_array = array(
			'demo1' => array(
				'title' => esc_html__( 'Home', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo1.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'home',
			),
            'demo1_light' => array(
				'title' => esc_html__( 'Home Light', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo1_light.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'home-light',
			),
			'demo2' => array(
				'title' 			=> esc_html__( 'Technician', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo2.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'technician',
			),
            'demo2_light' => array(
                'title' 			=> esc_html__( 'Technician Light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo2_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'technician-light',
            ),
            'designer_two' => array(
                'title' 			=> esc_html__( 'Designer Two', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'designer_two.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'designer-two',
            ),
            'designer_two_light' => array(
                'title' 			=> esc_html__( 'Designer Two', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'designer_two_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'designer-two-light',
            ),
            'demo3' => array(
				'title' 			=> esc_html__( 'Model', 'rainbowitdemo'),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo3.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'home3',
			),
            'demo3_light' => array(
                'title' 			=> esc_html__( 'Model Light', 'rainbowitdemo'),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo3_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'model-light',
            ),
			'demo4' => array(
				'title' => esc_html__( 'Consulting', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo4.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'home4',
			),
            'demo4_light' => array(
                'title' => esc_html__( 'Consulting Light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo4_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'consulting-light',
            ),
			'demo5' => array(
				'title' => esc_html__( 'Fashion Designer', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo5.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'fashion-designer',
			),
            'demo5_light' => array(
                'title' => esc_html__( 'Fashion Designer Light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo5_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'fashion-designer-light',
            ),
            'demo6' => array(
				'title' => esc_html__( 'Developer', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo6.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'developer',
			),
            'demo6_light' => array(
                'title' => esc_html__( 'Developer Light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo6_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'developer-light',
            ),
            'demo7' => array(
				'title' => esc_html__( 'Instructor Fitness', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo7.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'instructor-fitness',
			),
            'demo7_light' => array(
                'title' => esc_html__( 'Instructor Fitness Light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo7_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'instructor-fitness-light',
            ),
			'demo8' => array(
				'title' => esc_html__( 'Web Developer', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo8.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'web-developer',
			),
            'demo8_light' => array(
                'title' => esc_html__( 'Web Developer Light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo8_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'web-developer-light',
            ),
            'demo9' => array(
				'title' => esc_html__( 'Designer', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo9.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'designer',
			),
            'demo9_light' => array(
                'title' => esc_html__( 'Designer Light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo9_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'designer-light',
            ),
			'demo10' => array(
				'title' => esc_html__( 'Content Writer', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo10.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'content-writer',
			),
            'demo10_light' => array(
                'title' => esc_html__( 'Content Writer Light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo10_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'content-writer-light',
            ),
			'demo11' => array(
				'title' => esc_html__( 'Instructor', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo11.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'instructor',
			),
            'demo11_light' => array(
                'title' => esc_html__( 'Instructor Light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo11_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'instructor-light',
            ),
            'demo12' => array(
				'title' => esc_html__( 'Freelancer', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo12.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'freelancer',
			),
            'demo12_light' => array(
                'title' => esc_html__( 'Freelancer light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo12_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'freelancer-light',
            ),
			'demo13' => array(
				'title' => esc_html__( 'Photographer', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo13.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'photographer',
			),
            'demo13_light' => array(
                'title' => esc_html__( 'Photographer Light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo13_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'photographer-light',
            ),
			'demo14' => array(
				'title' => esc_html__( 'Politician', 'rainbowitdemo' ),
				'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo14.png',
				'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'politician',
			),
            'demo14_light' => array(
                'title' => esc_html__( 'Politician Light', 'rainbowitdemo' ),
                'screenshot' 		=> RAINBOWIT_PREVIEW . 'demo14_light.png',
                'preview_link' 		=> RAINBOWIT_PREVIEW_LINK . 'politician-light',
            ),
				

		);

		$download_url = RAINBOWIT_DEMO_DATA_URL;		
		foreach ($demos_array as $id => $data) {
			$demo = new \FW_Ext_Backups_Demo($id, 'piecemeal', array(
				'url' => $download_url,
				'file_id' => $id,
			));
			$demo->set_title($data['title']);
			$demo->set_screenshot($data['screenshot']);
			$demo->set_preview_link($data['preview_link']);
			$demos[ $demo->get_id() ] = $demo;
			unset($demo);
		}

		return $demos;
	}

	public function rainbowit_after_demo_install( $collection ){
		// Update front page id
		$demos = array(
			'demo1'  => 7,
			'demo1_light'  => 3905,
			'demo2'  => 756,
			'demo2_light'  => 3976,
            'designer_two'  => 4558,
            'designer_two_light'  => 4712,
			'demo3'  => 451,
			'demo3_light'  => 3945,
			'demo4'  => 176,
			'demo4_light'  => 3850,
			'demo5'  => 494,
			'demo5_light'  => 3888,
			'demo6'  => 515,
			'demo6_light'  => 3880,
			'demo7'  => 549,
			'demo7_light'  => 3931,
			'demo8'  => 573,
			'demo8_light'  => 3988,
			'demo9'  => 432,
			'demo9_light'  => 3872,
			'demo10'  => 426,
			'demo10_light'  => 3864,
			'demo11'  => 413,
            'demo11_light'  => 3913,
			'demo12'  => 367,
            'demo12_light'  => 3897,
			'demo13'  => 251,
            'demo13_light'  => 3950,
			'demo14'  => 199,
            'demo14_light'  => 3965,

		);

		$data = $collection->to_array();

		foreach( $data['tasks'] as $task ) {
			if( $task['id'] == 'demo:demo-download' ){
				$demo_id = $task['args']['demo_id'];
				$page_id = $demos[$demo_id];
				update_option( 'page_on_front', $page_id );
				flush_rewrite_rules();
				break;
			}
		}
		// Update contact form 7 email
		$cf7ids = array( 5 );
		foreach ( $cf7ids as $cf7id ) {
			$mail = get_post_meta( $cf7id, '_mail', true );
			$mail['recipient'] = get_option( 'admin_email' );

			if ( class_exists( 'WPCF7_ContactFormTemplate' ) ) {
				$pattern = "/<[^@\s]*@[^@\s]*\.[^@\s]*>/"; // <email@email.com>
				$replacement = '<'. \WPCF7_ContactFormTemplate::from_email().'>';
				$mail['sender'] = preg_replace($pattern, $replacement, $mail['sender']);
			}			
			update_post_meta( $cf7id, '_mail', $mail );		
		}


	}


    public function rainbowit_demo_footer_add_scripts()
    {
        $frontpage_id = get_option( 'page_on_front' );
        $frontpage_title = get_the_title( $frontpage_id );

        if (!empty($frontpage_title)) {
            ?>
            <script>
                jQuery(document).ready(function ($) {

                    $('.theme-browser .theme.fw-ext-backups-demo-item').each(function () {

                        var rainbowit_theme_title = $( this ).find('h3.theme-name').html();
                        var rainbowit_theme_title_slug = rainbowit_theme_title.toLowerCase();

                        var frontpage_title_slgu = '<?php echo strtolower($frontpage_title); ?>';

                        if (rainbowit_theme_title_slug == frontpage_title_slgu) {
                            $(this).addClass('active_demo');
                            return false;
                        }
                    });
                });
            </script>
            <?php
        }
    }

}

new Rainbow_Demo_Importer;