<?php
/**
 * Theme options > General Options  > Favicon options
 */


// BOXED LAYOUT
$admin_options[] = array (
    'slug'        => 'layout_options',
    'parent'      => 'layout_options',
    "name"        => __( "Choose Site Layout", 'zn_framework' ),
    "description" => __( "Choose the type of layout you want pages to display.", 'zn_framework' ),
    "id"          => "zn_boxed_layout",
    "std"         => "no",
    // "type"        => "zn_radio",
    // "options"     => array ( 'no' => __( 'No', 'zn_framework' ), 'yes' => __( 'Yes', 'zn_framework' ) ),
    "type"        => "radio_image",
    "class"       => "zn_full ri-2 ri-bg-hover",
    "options"     => array(
        array(
            'value' => 'no',
            'name'  => __( 'Full-Width', 'zn_framework' ),
            'image' => THEME_BASE_URI .'/images/admin/site-layout/fullwidth.svg'
        ),
        array(
            'value' => 'yes',
            'name'  => __( 'Boxed', 'zn_framework' ),
            'image' => THEME_BASE_URI .'/images/admin/site-layout/boxed.svg'
        ),
    )
);

// BACKGROUND IMAGE
$admin_options[] = array (
    'slug'        => 'layout_options',
    'parent'      => 'layout_options',
    "name"        => __( "Background Image", 'zn_framework' ),
    "description" => __( "Please choose your desired image to be used as a background", 'zn_framework' ),
    "id"          => "boxed_style_image",
    "std"         => '',
    "options"     => array ( "repeat" => true, "position" => true, "attachment" => true ),
    "type"        => "background",
    'dependency'  => array ( 'element' => 'zn_boxed_layout', 'value' => array ( 'yes' ) ),
);

// BACKGROUND COLOR
$admin_options[] = array (
    'slug'        => 'layout_options',
    'parent'      => 'layout_options',
    "name"        => __( "Background Color", 'zn_framework' ),
    "description" => __( "Please choose your desired background color", 'zn_framework' ),
    "id"          => "boxed_style_color",
    "std"         => '#fff',
    "type"        => "colorpicker",
    'dependency'  => array ( 'element' => 'zn_boxed_layout', 'value' => array ( 'yes' ) ),
);

// BOXED LAYOUT FOR HOMEPAGE
$admin_options[] = array (
    'slug'        => 'layout_options',
    'parent'      => 'layout_options',
    "name"        => __( "Homepage Boxed Layout", 'zn_framework' ),
    "description" => __( "Here you can choose a specific layout setting for the homepage that will override the
		setting from above.", 'zn_framework' ),
    "id"          => "zn_home_boxed_layout",
    "std"         => "def",
    "type"        => "zn_radio",
    "options"     => array (
        'def' => __( 'Default', 'zn_framework' ),
        'no'  => __( 'No', 'zn_framework' ),
        'yes' => __( 'Yes', 'zn_framework' )
    ),
);

$admin_options[] = array (
    'slug'        => 'layout_options',
    'parent'      => 'layout_options',
    "name"        => __( "Content size", 'zn_framework' ),
    "description" => __( "Please choose the desired default size for the content.", 'zn_framework' ),
    "id"          => "zn_width",
    "std"         => "1170",
    "options"     => array ( '1170' => '1170px', '960' => '960px', 'custom' => 'Custom Width' ),
    "type"        => "select"
);

$admin_options[] = array (
    'slug'        => 'layout_options',
    'parent'      => 'layout_options',
    'id'          => 'custom_width',
    'name'        => __( 'Site Container Width (on Large breakpoints, 1200px)', 'zn_framework'),
    'description' => __( 'Choose the desired width for the site\'s container.', 'zn_framework' ),
    'type'        => 'slider',
    'std'        => '1170',
    'helpers'     => array(
        'min' => '1170',
        'max' => '1900'
    ),
    'dependency' => array( 'element' => 'zn_width' , 'value'=> array('custom') )
);

$admin_options[] = array (
    'slug'        => 'layout_options',
    'parent'      => 'layout_options',
    "name"        => __( "Enable Element Entry Animations", 'zn_framework' ),
    "description" => __( "Choose yes if you want to enable elements entry/reveal animations on page scroll. Each element will have Animation options in the Misc. tab. Please remember that it affects website performance.", 'zn_framework' ),
    "id"          => "zn_animations",
    "std"         => "no",
    "type"        => "zn_radio",
    "options"     => array ( 'no' => __( 'No', 'zn_framework' ), 'yes' => __( 'Yes', 'zn_framework' ) ),
);

/*
    Commented as per https://github.com/hogash/kallyas/issues/232
*/
// // START SLIDER AFTER HEADER
// $admin_options[] = array (
//     'slug'        => 'layout_options',
//     'parent'      => 'layout_options',
//     "name"        => __( "Start Slider/header area after header?", 'zn_framework' ),
//     "description" => __( "If set to yes, the slider/subheader area will start bellow the header.", 'zn_framework' ),
//     "id"          => "zn_slider_header",
//     "std"         => "no",
//     "type"        => "zn_radio",
//     "options"     => array ( 'no' => __( 'No', 'zn_framework' ), 'yes' => __( 'Yes', 'zn_framework' ) ),
// );


$admin_options[] = array (
    'slug'        => 'layout_options',
    'parent'      => 'layout_options',
    "name"        => __( '<span class="dashicons dashicons-editor-help"></span> HELP:', 'zn_framework' ),
    "description" => __( '<a href="http://www.gmswebdesign.co.uk/">www.gmswebdesign.co.uk</a>', 'zn_framework' ),
    "id"          => "lto_title",
    "type"        => "zn_title",
    "class"       => "zn_full zn-custom-title-md zn-top-separator zn-sep-dark"
);

$admin_options[] = zn_options_video_link_option( '', __( 'Click here to access video tutorial for this options section.', 'zn_framework' ), array(
    'slug'        => 'layout_options',
    'parent'      => 'layout_options'
));

$admin_options[] = wp_parse_args( znpb_general_help_option( 'zn-admin-helplink' ), array(
    'slug'        => 'layout_options',
    'parent'      => 'layout_options',
));