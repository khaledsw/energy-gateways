<?php if(! defined('ABSPATH')){ return; }
/**
 * This file is autoloaded by framework/addons/plugins/class-plugins.php
 */
$plugins = array(
	array (
		'addon_type'		   => 'child_theme',
		'name'                 => 'Kallyas child theme',
		'slug'                 => 'kallyas-child-theme',
		'source'               => THEME_BASE_URI . '/template_helpers/plugins/kallyas-child.zip',
		'source_type'          => 'external',
		'version'              => '1.0.0',
		'z_plugin_icon'        => THEME_BASE_URI . '/template_helpers/plugins/kallyas-child.png',
		'z_plugin_author'      => 'Hogash Studio',
		'z_plugin_description' => 'Always stay updated and safely customize Kallyas theme code, by applying custom hooks or overriding files. <a href="https://codex.wordpress.org/Child_Themes" target="_blank">More on Child Themes</a>.',
		'zn_plugin'            => 'revslider/revslider.php',
	),
	array (
		'name'                 => 'Revolution Slider',
		'slug'                 => 'revslider',
		'source'               => 'http://kallyas.net/0f5afa285cb7d34ee6fa41b23bd51e61/a22ce5d69768192ed534fcb4335c9d195254.zip',
		'source_type'          => 'external',
		'version'              => '5.2.5.4',
		'external_url'         => '',
		'z_plugin_icon'        => THEME_BASE_URI . '/template_helpers/plugins/rev_slider.png',
		'z_plugin_author'      => 'themepunch',
		'z_plugin_description' => 'Slider Revolution is not only for "Sliders". You can now build a beautiful one-page web presence with absolutely no coding knowledge required.',
		'zn_plugin'            => 'revslider/revslider.php',
	),
	/*
	* Since the plugin is not maintained anymore by its author and we don't provide full support
	* for its development, then there's no need to have it marked as a MUST HAVE installed plugin.
	*/
	array(
		'name'                 => 'WooCommerce',
		'slug'                 => 'woocommerce',
		'version'              => '2.5.5',
		'z_plugin_icon'        => THEME_BASE_URI . '/template_helpers/plugins/woocommerce.png',
		'z_plugin_author'      => 'woothemes',
		'z_plugin_description' => 'WooCommerce is a free eCommerce plugin that allows you to sell anything, beautifully. Built to integrate seamlessly with WordPress, WooCommerce is the world’s favorite eCommerce solution that gives both store owners and developers complete control.',
		'zn_plugin'            => 'woocommerce/woocommerce.php',
	),
	array(
		'name'                 => 'Booking Calendar',
		'slug'                 => 'booking',
		'version'              => '6.2',
		'z_plugin_icon'        => THEME_BASE_URI . '/template_helpers/plugins/booking_calendar.png',
		'z_plugin_author'      => 'wpdevelop',
		'z_plugin_description' => 'Booking Calendar plugin - is the ultimate booking system for online reservation and availability checking service for your site.',
		'zn_plugin'            => 'booking/wpdev-booking.php',
	),
	array (
		'name'                 => 'PostLove - Content like plugin',
		'slug'                 => 'hogash-post-love',
		'source'               => THEME_BASE_URI . '/template_helpers/plugins/hogash-post-love.zip',
		'source_type'          => 'external',
		'version'              => '1.0.0',
		'external_url'         => '',
		'z_plugin_icon'        => THEME_BASE_URI . '/template_helpers/plugins/postlove.png',
		'z_plugin_author'      => 'HogashStudio',
		'z_plugin_description' => 'Hogash Post Love brings article loving to your site. You users or visitors would be able to share their interest in your articles by loving them.',
		'zn_plugin'            => 'hogash-post-love/hogash-post-love.php',
	),
	array (
		'name'                 => 'Cute Slider',
		'slug'                 => 'CuteSlider',
		'source'               => THEME_BASE_URI . '/template_helpers/plugins/cutesliderwp.zip',
		'source_type'          => 'external',
		'version'              => '1.1.18',
		'external_url'         => '',
		'z_plugin_icon'        => THEME_BASE_URI . '/template_helpers/plugins/cute_slider.png',
		'z_plugin_author'      => 'Averta and Kreatura Media',
		'z_plugin_description' => 'Cute Slider is a unique and easy to use slider with awesome 3D and 2D transition effects, captions, 4 ready to use templates, video (youtube and vimeo) support and more impressive features',
		'zn_plugin'            => 'CuteSlider/cuteslider.php',
		'deprecated'            => array(
			'message' => 'This plugin is no longer maintained by it\'s developers. Please be aware that problems may appear when using it. We strongly recommend using an alternative slider provided by the theme.'
		),
	),
);

