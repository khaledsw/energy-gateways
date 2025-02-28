<?php if(! defined('ABSPATH')){ return; }

$theme_config = array(
		'options_prefix' => 'zn_kallyas_optionsv4', // The DB options field name
		'theme_id' => 'EGW', // The theme id that will be used for options field
		'name'           => 'EGW', // The theme name
		'server_url'	=> 'http://energygateways.com',
		'supports'       => array(
			'pagebuilder'  	=> true,
			'megamenu'     	=> true,
			'iconmanager'  	=> true,
			'imageresizer' 	=> true,
			'shortcodes' 	=> false,
			'theme_updater'	=> array(
				'author' => 'Hogash',
			),
		)
	);

	// Change the advanced tab to advanced_options. This is needed for the custom css save
	// TODO : Remove this and change the 'advanced_options' to 'advanced'
	function zn_add_custom_css_saving( $saved_options ){

		if ( isset( $saved_options['advanced_options']['custom_css'] ) ) {
			$custom_css = $saved_options['advanced_options']['custom_css'];
			update_option( 'zn_'.ZN()->theme_data['theme_id'].'_custom_css', $custom_css, false );

			// Remove custom css from the main options field
			unset( $saved_options['advanced_options']['custom_css'] );
		}

		if ( isset( $saved_options['advanced_options']['custom_js'] ) ) {
			$custom_js = $saved_options['advanced_options']['custom_js'];
			update_option( 'zn_'.ZN()->theme_data['theme_id'].'_custom_js', $custom_js, true );

			// Remove custom css from the main options field
			unset( $saved_options['advanced_options']['custom_js'] );
		}

		return $saved_options;
	}
	add_filter( 'zn_options_to_save', 'zn_add_custom_css_saving' );

	function znkl_dummy_data_locations(){
		return array(
			'main' => array(
				'title'   => 'KALLYAS MAIN DEMO',
				'desc'   => 'This is the main demo of our theme.',
				'image'   => THEME_BASE_URI .'/template_helpers/dummy_content/main_demo/main-demo.jpg',
				'folder'  => THEME_BASE .'/template_helpers/dummy_content/main_demo',
				'preview' => 'http://kallyas.net/demo/',
			),
			'one_page' => array(
				'title'   => 'KALLYAS ONE PAGE',
				'desc'   => 'This is the one page demo of the theme',
				'image'   => THEME_BASE_URI .'/template_helpers/dummy_content/one_page/one-page.jpg',
				'folder'  => THEME_BASE .'/template_helpers/dummy_content/one_page',
				'preview' => 'http://kallyas.net/demos/',
			),
			'ares_furniture' => array(
				'title'   => 'ARES DEMO',
				'desc'   => 'Import Ares Demo content.',
				'image'   => THEME_BASE_URI .'/template_helpers/dummy_content/ares_furniture/thumb.jpg',
				'folder'  => THEME_BASE .'/template_helpers/dummy_content/ares_furniture',
				'preview' => 'http://kallyas.net/demo-ares/furniture/',
			),
			'travel' => array(
				'title'   => 'TRAVEL DEMO',
				'desc'   => 'Import Travel Demo content.',
				'image'   => THEME_BASE_URI .'/template_helpers/dummy_content/travel/thumb.jpg',
				'folder'  => THEME_BASE .'/template_helpers/dummy_content/travel',
				'preview' => 'http://kallyas.net/demos/travel/',
			),
			'app_landing' => array(
				'title'   => 'APP LANDING DEMO',
				'desc'   => 'Import App Landing Demo content.',
				'image'   => THEME_BASE_URI .'/template_helpers/dummy_content/app_landing/thumb.jpg',
				'folder'  => THEME_BASE .'/template_helpers/dummy_content/app_landing',
				'preview' => 'http://kallyas.net/demo-kyma/app-landing/',
			),
		);
	}

	add_filter( 'zn_dummy_data_locations', 'znkl_dummy_data_locations' );

