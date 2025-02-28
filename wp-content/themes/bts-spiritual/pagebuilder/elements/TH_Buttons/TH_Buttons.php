<?php if(! defined('ABSPATH')){ return; }
/*
 Name: Buttons
 Description: Create and display as many buttons as you want
 Class: TH_Buttons
 Category: content
 Level: 3
*/
/**
 * Class TH_Buttons
 *
 * Create and display as many buttons as you want
 *
 * @package  EGW
 * @category Page Builder
 * @author   Team Hogash
 * @since    4.0.0
 */
class TH_Buttons extends ZnElements
{
	public static function getName(){
		return __( "Buttons", 'zn_framework' );
	}


	/**
	 * Output the inline css to head or after the element in case it is loaded via ajax
	 */
	function css(){

		$uid = $this->data['uid'];
		$css = '';


		$buttons = $this->opt('single_btn');

		if( is_array($buttons) && !empty( $buttons ) ){
			foreach( $buttons as $i => $b ){

				$button_style = $b['button_style'];
				$button_selector = '.'.$uid.' .btn-custom-color.btn-element-'.$i;
				$button_simple_selector = '.'.$uid.' .btn-element-'.$i;
				$button_color = isset($b['btn_custom_color']) && !empty($b['btn_custom_color']) ? $b['btn_custom_color'] : '';

				// Button Fullcolor
				if($button_style == 'btn-fullcolor btn-custom-color' && $button_color ){
					$css .= $button_selector.'{background-color:'.$button_color.'}';
					$css .= $button_selector.':hover{background-color:'.adjustBrightness($button_color, 20).'}';
				}
				// Button lined
				elseif($button_style == 'btn-lined btn-custom-color' && $button_color ){
					$css .= $button_selector.'{color:'.$button_color.'; border-color:'.$button_color.';}';
					$css .= $button_selector.':hover{color:'.adjustBrightness($button_color, 20).'; border-color:'.adjustBrightness($button_color, 20).';}';
				}
				// Button Skewed
				elseif($button_style == 'btn-fullcolor btn-skewed btn-custom-color' && $button_color ){
					$css .= $button_selector.':before{background-color:'.$button_color.'}';
					$css .= $button_selector.':hover:before{background-color:'.adjustBrightness($button_color, 20).';}';
				}
				// Button Text
				elseif($button_style == 'btn-text btn-custom-color' && $button_color ){
					$css .= $button_selector.'{color:'.$button_color.'}';
					$css .= $button_selector.':hover{color:'.adjustBrightness($button_color, 7).';}';
				}

				// typography styles
				$btn_font_styles = '';
				if( isset($b['button_typo']) && !empty($b['button_typo']) ){
					foreach ($b['button_typo'] as $key => $value) {
						if($value != '') {
							$btn_font_styles .= $key.':'. $value.';';
						}
					}
					if(!empty($btn_font_styles)){
						$css .= $button_simple_selector.'{'.$btn_font_styles.'}';
					}
				}

				$btn_icon_margin = '';
				$btn_icon_size = '';

				$button_icon_size = isset($b['button_icon_size']) ? $b['button_icon_size'] : '14';
				$button_icon_pos = isset($b['button_icon_pos']) ? $b['button_icon_pos'] : 'before';
				$button_icon_distance = isset($b['button_icon_distance']) ? $b['button_icon_distance'] : '0';

				if($button_icon_size != '14'){
					$btn_icon_size = 'font-size:'.$button_icon_size.'px;';
				}

				if($button_icon_distance != 0){
					if($button_icon_pos == 'before'){
						$btn_icon_margin = 'margin-right:'.$button_icon_distance.'px;';
					} elseif($button_icon_pos == 'after'){
						$btn_icon_margin = 'margin-left:'.$button_icon_distance.'px;';
					}
				}
				if($btn_icon_size || $btn_icon_margin){
					$css .= $button_simple_selector.' .btn-element-icon{'.$btn_icon_size.$btn_icon_margin.'}';
				}
			}
		}


		$parent_hover_anim = $this->opt('parent_hover_anim','');

		if($parent_hover_anim != ''){

			$parent_id = $this->opt('parent_hover_id','');
			if($parent_id != ''){

				if($parent_hover_anim == 'fadeout'){
					$css .= '.'.$parent_id.':hover .ph-'.$uid.'.prt-hover-fadeout {opacity:0;}';
				}
				elseif($parent_hover_anim == 'fadein'){
					$css .= '.'.$parent_id.':hover .ph-'.$uid.'.prt-hover-fadein {opacity:1;}';
				}
				elseif($parent_hover_anim == 'slideout'){
					$css .= '.'.$parent_id.':hover .ph-'.$uid.'.prt-hover-slideout {opacity:0; max-height:0;}';
				}
				elseif($parent_hover_anim == 'slidein'){
					$css .= '.'.$parent_id.':hover .ph-'.$uid.'.prt-hover-slidein {opacity:1; max-height:200px;}';
				}

			}

		}


		return $css;
	}

	/**
	 * This method is used to display the output of the element.
	 *
	 * @return void
	 */
	function element()
	{
		$options = $this->data['options'];

		$classes=array();
		$classes[] = $uid = $this->data['uid'];
		$classes[] = 'text-'.$this->opt('el_alignment','left');
		$classes[] = zn_get_element_classes($options);

		$attributes = zn_get_element_attributes($options);

		// Parent Hover block
		$parent_hover_anim = $this->opt('parent_hover_anim','');
		$parent_hov_block_start = '';
		$parent_hov_block_end = '';
		if($parent_hover_anim != ''){
			$parent_hov_block_start = '<div class="prt-hover-'.$parent_hover_anim.' ph-'.$uid.'">';
			$parent_hov_block_end = '</div>';
		}

		echo $parent_hov_block_start;

		echo '<div class="zn_buttons_element '.implode(' ', $classes).'" '.$attributes.'>';

			$buttons = $this->opt('single_btn');

			if( is_array($buttons) && !empty( $buttons ) ){
				foreach( $buttons as $i => $b ){

					//Class
					$classes = array();
					$classes[] = 'btn-element btn-element-'.$i.' btn';
					$classes[] = $b['button_style'];
					$classes[] = $b['button_size'];
					$classes[] = $b['button_width'];
					$classes[] = isset($b['button_block']) ? $b['button_block'] : '';
					$classes[] = 'btn-icon--'.$b['button_icon_pos'];
					$classes[] = isset($b['button_corners']) && !empty($b['button_corners']) ? $b['button_corners'] : 'btn--rounded';

					// Styles
					$style = !empty($b['button_margin']) ? ' style="margin:'.$b['button_margin'].';"' : '';

					// Icon
					$icon = $b['button_icon_enable'] == 1 ? '<span class="btn-element-icon" '.zn_generate_icon( $b['button_icon'] ).'></span>':'';

					if( isset($b['button_text']) && !empty($b['button_text']) ){

						$text = '<span>'.$b['button_text'].'</span>';

						// Icon position
						if( $b['button_icon_pos'] == 'before' ){
							$text = $icon.$text;
						} else{
							$text = $text.$icon;
						}

						// extract link and add attributes and classes
						$link = zn_extract_link( $b['button_link'], implode(' ', $classes), $style );

						echo $link['start'] . $text . $link['end'];
					}

				}
			}

		echo '</div>';

		echo $parent_hov_block_end;

	}

	/**
	 * This method is used to retrieve the configurable options of the element.
	 * @return array The list of options that compose the element and then passed as the argument for the render() function
	 */
	function options()
	{
		$uid = $this->data['uid'];

		$options = array(
			'has_tabs'  => true,
			'general' => array(
				'title' => 'General options',
				'options' => array(
					array (
						"name"        => __( "Element Alignment", 'zn_framework' ),
						"description" => __( "Please select the alignment of the button/s.", 'zn_framework' ),
						"id"          => "el_alignment",
						"std"         => "left",
						"options"     => array (
							'left' => __( 'Left (default)', 'zn_framework' ),
							'right'          => __( 'Right', 'zn_framework' ),
							'center'          => __( 'Center', 'zn_framework' )
						),
						"type"        => "select",
						'live' => array(
						   'type'           => 'class',
						   'css_class'      => '.'.$uid,
						   'val_prepend'   => 'text-',
						),
					),

					array(
						"name"           => __( "Button", 'zn_framework' ),
						"description"    => __( "Add Button.", 'zn_framework' ),
						"id"             => "single_btn",
						"element_title" => "button_text",
						"std"            => "",
						"type"           => "group",
						"add_text"       => __( "Button", 'zn_framework' ),
						"remove_text"    => __( "Button", 'zn_framework' ),
						"group_sortable" => true,
						"subelements"    => array (

							'has_tabs'  => true,
							'general' => array(
								'title' => 'General options',
								'options' => array(

									array (
										"name"        => __( "Text", 'zn_framework' ),
										"description" => __( "Text inside the button", 'zn_framework' ),
										"id"          => "button_text",
										"std"         => "",
										"type"        => "text",
									),

									array (
										"name"        => __( "Link", 'zn_framework' ),
										"description" => __( "Attach a link to the button", 'zn_framework' ),
										"id"          => "button_link",
										"std"         => "",
										"type"        => "link",
										"options"     => zn_get_link_targets(),
									),

									array (
										"name"        => __( "Style", 'zn_framework' ),
										"description" => __( "Select a style for the button", 'zn_framework' ),
										"id"          => "button_style",
										"std"         => "btn-fullcolor",
										"type"        => "select",
										"options"     => zn_get_button_styles(),
										'live' => array(
										   'type'           => 'class',
										   'css_class'      => '.'.$uid.' .btn-element',
										),
									),
									array (
										"name"        => __( "Button Custom Color", 'zn_framework' ),
										"description" => __( "Select buton custom color.", 'zn_framework' ),
										"id"          => "btn_custom_color",
										"std"         => "#cd2122",
										"type"        => "colorpicker",
										"dependency"  => array( 'element' => 'button_style' , 'value'=> array('btn-fullcolor btn-custom-color', 'btn-lined btn-custom-color', 'btn-fullcolor btn-skewed btn-custom-color', 'btn-fullcolor btn-bordered btn-custom-color', 'btn-text btn-custom-color') )
									),
									array (
										"name"        => __( "Size", 'zn_framework' ),
										"description" => __( "Select a size for the button", 'zn_framework' ),
										"id"          => "button_size",
										"std"         => "",
										"type"        => "select",
										"options"     => array (
											''          => __( "Default", 'zn_framework' ),
											'btn-lg'    => __( "Large", 'zn_framework' ),
											'btn-md'    => __( "Medium", 'zn_framework' ),
											'btn-sm'    => __( "Small", 'zn_framework' ),
											'btn-xs'    => __( "Extra small", 'zn_framework' ),
										),
										'live' => array(
										   'type'           => 'class',
										   'css_class'      => '.'.$uid.' .btn-element',
										),
									),

									array (
										"name"        => __( "Button Corners", 'zn_framework' ),
										"description" => __( "Select the button corners type for this button", 'zn_framework' ),
										"id"          => "button_corners",
										"std"         => "btn--rounded",
										"type"        => "select",
										"options"     => array (
											'btn--rounded'  => __( "Smooth rounded corner", 'zn_framework' ),
											'btn--round'    => __( "Round corners", 'zn_framework' ),
											'btn--square'   => __( "Square corners", 'zn_framework' ),
										),
										'live' => array(
										   'type'           => 'class',
										   'css_class'      => '.'.$uid.' .btn-element',
										),
									),

									array (
										"name"        => __( "Width", 'zn_framework' ),
										"description" => __( "Select a size for the button", 'zn_framework' ),
										"id"          => "button_width",
										"std"         => "",
										"type"        => "select",
										"options"     => array (
											''                          => __( "Default", 'zn_framework' ),
											'btn-block btn-fullwidth'   => __( "Full width (100%)", 'zn_framework' ),
											'btn-halfwidth'             => __( "Half width (50%)", 'zn_framework' ),
											'btn-third'                 => __( "One-Third width (33%)", 'zn_framework' ),
											'btn-forth'                 => __( "One-forth width (25%)", 'zn_framework' ),
										),
										'live' => array(
										   'type'           => 'class',
										   'css_class'      => '.'.$uid.' .btn-element',
										),
									),

									array (
										"name"        => __( "Button text Options", 'zn_framework' ),
										"description" => __( "Specify the typography properties for the sub-title.", 'zn_framework' ),
										"id"          => "button_typo",
										"std"         => '',
										'supports'   => array( 'size', 'font', 'style', 'line', 'weight' ),
										"type"        => "font",
									),


									array (
										"name"        => __( "Make button as block?", 'zn_framework' ),
										"description" => __( "Transform the button and make it a block?", 'zn_framework' ),
										"id"          => "button_block",
										"std"         => "",
										"value"       => "btn-block",
										"type"        => "toggle2",
										'live' => array(
										   'type'           => 'class',
										   'css_class'      => '.'.$uid.' .btn-element',
										),
									),

									array (
										"name"        => __( "Margins", 'zn_framework' ),
										"description" => __( "Add css margins to the buttons for distancing. The css syntax is [top right bottom left].", 'zn_framework' ),
										"id"          => "button_margin",
										"std"         => "",
										"type"        => "text",
										"placeholder" => "ex: 10px 10px 10px 10px",
									),


								),
							),

							'icon' => array(
								'title' => 'Icon options',
								'options' => array(

									array (
										"name"        => __( "Add icon?", 'zn_framework' ),
										"description" => __( "Add an icon to the button?", 'zn_framework' ),
										"id"          => "button_icon_enable",
										"std"         => "0",
										"value"       => "1",
										"type"        => "toggle2",
									),

									array (
										"name"        => __( "Icon position", 'zn_framework' ),
										"description" => __( "Select the position of the icon", 'zn_framework' ),
										"id"          => "button_icon_pos",
										"std"         => "before",
										"type"        => "select",
										"options"     => array (
											'before'  => __( "Before text", 'zn_framework' ),
											'after'   => __( "After text", 'zn_framework' ),
										),
										"dependency"  => array( 'element' => 'button_icon_enable' , 'value'=> array('1') ),
									),

									array (
										"name"        => __( "Select icon", 'zn_framework' ),
										"description" => __( "Select an icon to add to the button", 'zn_framework' ),
										"id"          => "button_icon",
										"std"         => "0",
										"type"        => "icon_list",
										'class'       => 'zn_full',
										"dependency"  => array( 'element' => 'button_icon_enable' , 'value'=> array('1') ),
									),

									array(
										'id'          => 'button_icon_size',
										'name'        => 'Icon size.',
										'description' => 'Change the icon\'s size.',
										'type'        => 'slider',
										'std'         => '14',
										"helpers"     => array (
											"step" => "1",
											"min" => "8",
											"max" => "80"
										),
										"dependency"  => array( 'element' => 'button_icon_enable' , 'value'=> array('1') ),
									),

									array(
										'id'          => 'button_icon_distance',
										'name'        => 'Button icon distance.',
										'description' => 'Change the default distance from the icon vs text.',
										'type'        => 'slider',
										'std'         => '0',
										"helpers"     => array (
											"step" => "1",
											"min" => "0",
											"max" => "80"
										),
										"dependency"  => array( 'element' => 'button_icon_enable' , 'value'=> array('1') ),
									),

								)
							)

						)
					),

					array (
						"name"        => __( "Parent Hover Animation", 'zn_framework' ),
						"description" => __( "Animate element on parent hover", 'zn_framework' ),
						"id"          => "parent_hover_anim",
						"std"         => "",
						"type"        => "select",
						"options"     => array(
							"" => "None",
							"fadeout" => "Fade Out",
							"fadein" => "Fade In",
							"slideout" => "Slide Out",
							"slidein" => "Slide In",
							// "color" => "Color Swap",
						),
					),

					array(
						'id'          => 'parent_hover_id',
						'name'        => __( "Parent ID", 'zn_framework' ),
						'description' => __( "You need to copy the parent element's unique ID. To find it, open the parent element's options and in the HELP tab you can find the ID. Just click to copy it and paste it here.", 'zn_framework' ),
						'type'        => 'text',
						'std'         => '',
						"dependency"  => array( 'element' => 'parent_hover_anim' , 'value'=> array('fadeout', 'fadein', 'slideout', 'slidein') )
					),

					// animation type
					// fade out/ fade in / slide in / slide-out / color
				),
			),


		);
		return $options;
	}
}
