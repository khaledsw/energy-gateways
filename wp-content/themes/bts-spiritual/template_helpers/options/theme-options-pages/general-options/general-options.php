<?php
/**
 * Theme options > General Options
 */

$admin_options[] = array (
    'slug'        => 'general_options',
    'parent'      => 'general_options',
    "name"        => __( 'GENERAL SETTINGS', 'zn_framework' ),
    "description" => __( 'These settings below are related to theme itself.', 'zn_framework' ),
    "id"          => "info_title1",
    "type"        => "zn_title",
    "class"       => "zn_full zn-custom-title-large zn-toptabs-margin"
);

$admin_options[] = array (
    'slug'        => 'general_options',
    'parent'      => 'general_options',
    "name"        => __( "Use page preloader?", 'zn_framework' ),
    "description" => __( "Choose yes if you want to show a page preloader.", 'zn_framework' ),
    "id"          => "page_preloader",
    "std"         => 'no',
    "options"     => array (
        'no' => __( "No", 'zn_framework' ),
        'yes' => __( "Pulsating-circle animation", 'zn_framework' ),
        'yes_spinner' => __( "Spinner animation", 'zn_framework' ),
        'yes_persp' => __( "Perspective-square animation", 'zn_framework' ),
        'yes_img_persp' => __( "Custom Image & perspective animation", 'zn_framework' ),
        'yes_img_breath' => __( "Custom Image & breath animation", 'zn_framework' ),
        'yes_img' => __( "Custom Image & no animation", 'zn_framework' ),
    ),
    "type"        => "select"
);

$admin_options[] = array (
    'slug'        => 'general_options',
    'parent'      => 'general_options',
    "name"        => __( "Preloader overlay background color", 'zn_framework' ),
    "description" => __( "Please choose a default color for the preloader's overlay background color. Please remember, if you're using large images or too many external resources, the preloader will take longer to hide.", 'zn_framework' ),
    "id"          => "page_preloader_bg",
    "alpha"       => "true",
    "std"         => "#ffffff",
    "type"        => "colorpicker",
    'dependency'  => array ( 'element' => 'page_preloader', 'value' => array ( 'yes', 'yes_spinner', 'yes_persp', 'yes_img_persp', 'yes_img_breath', 'yes_img' ) ),
);

$admin_options[] = array (
    'slug'        => 'general_options',
    'parent'      => 'general_options',
    "name"        => __( "Preloader Custom Image (.jpg, .gif, .svg)", 'zn_framework' ),
    "description" => __( "Please choose image to be displayed into the preloader.", 'zn_framework' ),
    "id"          => "page_preloader_img",
    "std"         => "",
    "type"        => "media",
    'dependency'  => array ( 'element' => 'page_preloader', 'value' => array ( 'yes_img', 'yes_img_persp', 'yes_img_breath' ) ),
);


$admin_options[] = array (
    'slug'        => 'general_options',
    'parent'      => 'general_options',
    "name"        => __( "Enable Smooth Scroll?", 'zn_framework' ),
    "description" => __( "This option will hijack the page default scroll and add an ease effect. It's very appealing with parallax scrolls and general nativation.", 'zn_framework' ),
    "id"          => "smooth_scroll",
    "std"         => 'no',
    "options"     => array ( 'yes' => __( "Yes", 'zn_framework' ), 'no' => __( "No", 'zn_framework' ) ),
    "type"        => "select"
);


$admin_options[] = array (
    'slug'        => 'general_options',
    'parent'      => 'general_options',
    "name"        => __( '<span class="dashicons dashicons-editor-help"></span> HELP:', 'zn_framework' ),
    "description" => __( '<a href="http://www.gmswebdesign.co.uk/">www.gmswebdesign.co.uk</a>', 'zn_framework' ),
    "id"          => "go_title",
    "type"        => "zn_title",
    "class"       => "zn_full zn-custom-title-md zn-top-separator zn-sep-dark"
);

$admin_options[] = zn_options_video_link_option( '', __( 'Click here to access video tutorial for this options section.', 'zn_framework' ), array(
    'slug'        => 'general_options',
    'parent'      => 'general_options'
));

$admin_options[] = wp_parse_args( znpb_general_help_option( 'zn-admin-helplink' ), array(
    'slug'        => 'general_options',
    'parent'      => 'general_options',
));
