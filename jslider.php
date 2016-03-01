<?php
/**
 * Plugin Name: Zen Slider
 * Plugin URI: http://360zen.com
 * Description: A Slider for Custom Post Types. Uses SlidesJS.
 * Version: 0.5
 * Author: Justin Maurer
 * Author URI: http://360zen.com
 * License: DON'T USE THIS. IT'S NOT READY.
 */
include( plugin_dir_path( __FILE__ ) . 'options.php');

/**
*ENQUEUE SCRIPT
**/
function load_slides_js() {
	wp_enqueue_script(
		'slides_js',
		plugins_url( '/js/jquery.slides.js', __FILE__ ),
		array( 'jquery' )
	);
}
add_action( 'wp_enqueue_scripts', 'load_slides_js' );

/**
*LOAD SLIDER PARAMETERS
**/
function load_fire_js() {
	wp_enqueue_script( 'fire-slide', plugins_url( '/js/fire.js', __FILE__ ), array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'load_fire_js' );

/**
*LOAD STYLES
**/
function load_zenslider_style() {
	wp_register_style( 'zenslider-style', plugins_url( 'zenslider-style.css', __FILE__ ));
	wp_enqueue_style('zenslider-style');
}
add_action( 'wp_enqueue_scripts', 'load_zenslider_style' );


/**
*CREATE TEMPLATE TAG
**/
function go_slider_go() {  
	echo '<div id="slides">';
	/**THE CUSTOM POST TYPE**/
    
	$options = get_option('post_kind');
	$args = array( 'post_type' => $options, 'status'=> 'current', 'orderby' => 'rand', 'posts_per_page' => 6 );
	$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
				$post = $loop->post;
					echo '<div class="slide">';
					if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'slider-image');
						echo '<div class="slideImg col-8-12" style="background-image: url('.$image[0].');"><a href="'.get_permalink().'">';
						the_post_thumbnail('profile-sidebar');
						echo '</a></div>';
					}
		?>
					<a href="<?php echo get_permalink(); ?>"><div class="slideInfoContainer col-4-12">
					<div class="slideContent">
					<h2><?php the_title();?></h2>
					<?php
					$field = get_post_meta( $post->ID, 'wpcf-field-of-study', true);
					if (! empty( $field ) ) { 
						echo '<span class="meta slideField">'.$field.'</span>';
					}
					echo '</div></div></a></div>'; 
		endwhile; else: echo 'Sorry. No posts matched your criteria'; endif;
		echo '<a href="#" title="Previous" class="slidesjs-previous slidesjs-navigation"><img src="'.plugins_url( '/images/prev-arrow.png', __FILE__ ).'"/></a>
		<a href="#" title="Next" class="slidesjs-next slidesjs-navigation"><img src="'.plugins_url( '/images/next-arrow.png', __FILE__ ).'"/></a></div>';
}


/**
*ADD ADMIN PAGE
**/
add_action('admin_menu', 'zenslider_admin_add_page');
function zenslider_admin_add_page() {
add_options_page('Zen Slider Settings', 'Zen Slider Menu', 'manage_options', 'zenslider', 'zenslider_options_page');
}
