<?php if(! defined('ABSPATH')){ return; }
/*
Name: Latest Posts 3
Description: Create and display a Latest Posts 3 element
Class: TH_LatestPosts3
Category: content
Level: 3
*/
/**
 * Class TH_LatestPosts3
 *
 * Create and display a Latest Posts 3 element
 *
 * @package  Kallyas
 * @category Page Builder
 * @author   Team Hogash
 * @since    3.8.0
 */
class TH_LatestPosts3 extends ZnElements
{
	public static function getName(){
		return __( "Latest Posts 3", 'zn_framework' );
	}

	/**
	 * This method is used to display the output of the element.
	 * @return void
	 */
	function element()
	{
		$options = $this->data['options'];

		$elm_classes=array();
		$elm_classes[] = $this->data['uid'];
		$elm_classes[] = zn_get_element_classes($options);

		$attributes = zn_get_element_attributes($options);

		$color_scheme = $this->opt( 'element_scheme', '' ) == '' ? zget_option( 'zn_main_style', 'color_options', false, 'light' ) : $this->opt( 'element_scheme', '' );
		$elm_classes[] = 'latestposts3--'.$color_scheme;
		$elm_classes[] = 'element-scheme--'.$color_scheme;
		?>

			<div class=" latest_posts style2 latest_posts--style3 latest_posts3 <?php echo implode(' ', $elm_classes); ?>" <?php echo $attributes; ?>>
				<h3 class="m_title m_title_ext text-custom latest_posts3-elm-title"><?php echo (isset($options['lp_title']) ? strip_tags($options['lp_title']) : '');?></h3>
				<?php
				if ( ! empty( $options['lp_blog_page'] ) ) {
					echo '<a href="' . $options['lp_blog_page'] . '" class="viewall element-scheme__linkhv latest_posts3-viewall">' . __( "VIEW ALL", 'zn_framework' ) . ' -</a>';
				}
				?>
				<ul class="posts latest_posts3-posts">
					<?php
					// Check what categories were selected..if any
					$blog_category = '';
					if ( isset ( $options['lp_blog_categories'] ) ) {
						$blog_category = implode( ',', $options['lp_blog_categories'] );
					}

					// HOW MANY POSTS
					$num_posts = '2';
					if ( isset ( $options['lp_num_posts'] ) ) {
						$num_posts = $options['lp_num_posts'];
					}

					// Start the query
					query_posts( array ( 'posts_per_page' => $num_posts, 'cat' => $blog_category ) );

					// GET THE NUMBER OF TOTAL POSTS RETURNED
					global $wp_query;

					// Start the loop
					while ( have_posts() ) {
						the_post();

						echo '<li class="post latest_posts3-post">';

						//echo '<div class="details latest_posts3-post-details">';
							//echo '<span class="date latest_posts3-post-details-det latest_posts3-post-date">'.get_the_time( 'd/m/Y' ). '</span>';
							//echo '<span class="cat latest_posts3-post-details-det atest_posts3-post-cat">' . __( 'in ', 'zn_framework' );
							//the_category( ", " );
							//echo '</span>';
						//echo '</div>';


						// Create the featured image html
						if($this->opt('lp_img','') == 'yes'){
							$the_image = '';
							if ( has_post_thumbnail( get_the_ID() ) ) {
								$thumb = get_post_thumbnail_id( get_the_ID() );

								$alt = get_post_meta($thumb, '_wp_attachment_image_alt', true);
								$title = get_the_title($thumb);

								if ( ! empty ( $thumb ) ) {
									$image = wp_get_attachment_image_src( $thumb );
									if(isset($image[0]) && !empty($image[0])) {
										$the_image = '<a href="' . get_permalink() . '" class="latest_posts3-thumb">';
										$the_image .= '<img src="'. $image['0'] . '" width="' . $image['1'] . '" height="' . $image['2'] . '" alt="'.$alt.'" title="'.$title.'" class="latest_posts3-thumb-img" />';
										$the_image .= '</a>';
									}
								}
							}
							echo $the_image;
						}

						// TITLE
						echo '<h4 class="title latest_posts3-title"><a class="latest_posts3-title-link" href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';

						// TEXT
						echo '<div class="text latest_posts3-post-text">';
						$excerpt = get_the_excerpt();
						$excerpt = strip_shortcodes( $excerpt );
						$excerpt = strip_tags( $excerpt );
						$the_str = mb_substr( $excerpt, 0, 350 );
						echo $the_str . '...';

						echo '</div>';
						echo '<div class="clearfix"></div>';
						echo '</li>';
					}
					wp_reset_query();
					?>
				</ul>
			</div>
			<!-- end // latest posts style 2 -->
	<?php
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
						"name"        => __( "Title", 'zn_framework' ),
						"description" => __( "Enter a title for your Latest Posts element", 'zn_framework' ),
						"id"          => "lp_title",
						"std"         => "",
						"type"        => "text",
					),
					array (
						"name"        => __( "Blog page Link", 'zn_framework' ),
						"description" => __( "Enter the link to your blog page", 'zn_framework' ),
						"id"          => "lp_blog_page",
						"std"         => "",
						"type"        => "text",
					),
					array (
						"name"        => __( "Number of posts", 'zn_framework' ),
						"description" => __( "Enter the number of posts that you want to show", 'zn_framework' ),
						"id"          => "lp_num_posts",
						"std"         => "2",
						"type"        => "text",
					),
					array (
						"name"        => __( "Blog Category", 'zn_framework' ),
						"description" => __( "Select the blog category to show items", 'zn_framework' ),
						"id"          => "lp_blog_categories",
						"multiple"    => true,
						"std"         => "0",
						"type"        => "select",
						"options"     => WpkZn::getBlogCategories()
					),

					array (
						"name"        => __( "Show posts images?", 'zn_framework' ),
						"description" => __( "Enable if you want to display the posts's feature image.", 'zn_framework' ),
						"id"          => "lp_img",
						"std"         => "",
						"type"        => "toggle2",
						"value"		=> "yes",
					),

					array(
						'id'          => 'element_scheme',
						'name'        => 'Element Color Scheme',
						'description' => 'Select the color scheme of this element',
						'type'        => 'select',
						'std'         => '',
						'options'        => array(
							'' => 'Inherit from EGW options > Color Options [Requires refresh]',
							'light' => 'Light (default)',
							'dark' => 'Dark'
						),
						'live'        => array(
							'multiple' => array(
								array(
									'type'      => 'class',
									'css_class' => '.'.$uid,
									'val_prepend'  => 'latestposts3--',
								),
								array(
									'type'      => 'class',
									'css_class' => '.'.$uid,
									'val_prepend'  => 'element-scheme--',
								),
							)
						)
					),

				),
			),




		);
		return $options;
	}
}

