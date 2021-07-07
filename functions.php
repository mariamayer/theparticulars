<?php
/**
 * Fancy Squares includes
 *
 * The $fancySquares_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$fancySquares_includes = [
	'lib/timber.php',    // Timber setup
	'lib/assets.php',    // Scripts and stylesheets
	'lib/extras.php',    // Custom functions
	'lib/setup.php',     // Theme setup
	'lib/titles.php',    // Page titles
	'lib/customizer.php', // Theme customizer
	'lib/extras/acf-options.php', // Theme customizer
	'lib/posts/general-enhancements.php' // WordPress / Theme ehancements
];

foreach ($fancySquares_includes as $file) {
	if (!$filepath = locate_template($file)) {
		trigger_error(sprintf(__('Error locating %s for inclusion', 'fancysquares'), $file), E_USER_ERROR);
	}

	require_once $filepath;
}
unset($file, $filepath);

// Timber::$cache = true;

add_filter( 'timber_context', 'fs_recent_posts'  );

function fs_recent_posts( $context ) {
	$context['FS_FIRST_INTERVIEW'] = fancySquares_get_interview();
	$context['FS_FIRST_ACCESSORY'] = fancySquares_get_accessory();
	$context['INSTA_FEED'] = fancySquares_get_instagram();
    return $context;
}


function fancySquares_get_interview()
{
	$recentInterviews = array(
		// Get post type project
		'post_type' => 'post',
		'cat'         => 3,
		'posts_per_page' => 1
	);
	return Timber::get_posts( $recentInterviews );

}
function fancySquares_get_accessory()
{
	$recentAccessory = array(
		// Get post type project
		'post_type' => 'post',
		'cat'         => 2,
		'posts_per_page' => 1
	);
	return Timber::get_posts( $recentAccessory );

}


function fancySquares_get_instagram()
{
	$recentInstas = array(
		// Get post type project
		'post_type' => 'instagram',
		'posts_per_page' => 8
	);
	return Timber::get_posts( $recentInstas );

}

add_filter('ai1wm_exclude_content_from_export', function($exclude_filters) {
	$exclude_filters[] = 'themes/fancysquares-boot/node_modules';
	return $exclude_filters;
});


add_filter('jpeg_quality', function($arg){return 100;});


// function wp_b_bpro_logged_out_redirect( $post ) {
// 	$nonLandingUrl = $_SERVER['REQUEST_URI'];
// 	if ( !is_user_logged_in() ) {
// 		// echo $_SERVER['REQUEST_URI'];
// 		if($nonLandingUrl !== '/'){

// 			wp_redirect( 'https://staging.the-particulars.com' );
// 			exit;
// 		}
// 		// return 'https://the-particulars.com/';
// 		// echo '
// 		// <script type="text/javascript">
// 		// window.location.href = "https://staging.the-particulars.com";
// 		// </script>
// 		// ';exit;
// 	}
// }
// add_filter( 'wp', 'wp_b_bpro_logged_out_redirect');

// <p><a href="**insta-link**" target="_blank"><i class="fa fa-heart" aria-hidden="true"><span>heart</span></i></a></p>



//
//
// add thumbnail to rss
//
//

function featured_images_RSS($content) {
	global $post;

	$rssimage = get_field('rss_image', $post->ID) ? get_field('rss_image', $post->ID) : get_the_post_thumbnail_url($post->ID,'thumbnail');

	$content = '<p class="rss-image" style="margin-top: 0;"><img class="feed-img" src="'. $rssimage .'" alt="'.get_the_title($post->ID).'" style="max-width: 100%;"></p>';
	return $content;
}
// add_filter('the_excerpt_rss', 'featured_images_RSS');
add_filter('the_content_feed', 'featured_images_RSS');



// add_action('init', 'customRSS');
// function customRSS(){
//     add_feed('newfeed', 'customRSSFunc');
// }

// function customRSSFunc(){
//     get_template_part('rss', 'newfeed');
// }

// add_action( 'rss2_item', 'custom_thumbnail_tag' );
// function custom_thumbnail_tag() {
//     global $post;

// 	echo('<media:content url="'.get_field('rss_image',$post->ID).'" lang="en" />');
// }


function fancySquares_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'fancySquares_woocommerce_support' );


/** WooCommerce by Stellar Soft **/

// Single product
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

// External URL for products
add_filter( 'woocommerce_loop_product_link', static function ( $link, $product ) {

	if ( $product->get_type() === 'external' ) {
		$link = $product->get_product_url();
	}

	return $link;

}, 10, 2 );

add_filter( 'post_link', static function ( $link, $post ) {

	if ( $post->post_type === 'product' ) {
		$product = new WC_Product( $post->ID );
		if ( $product->get_type() === 'external' ) {
			$link = $product->get_product_url();
		}
	}

	return $link;

}, 10, 2 );

// Sidebar
add_action( 'widgets_init', static function () {

	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Sidebar Left', 'fancysquares' ),
		'id'            => 'wc-sidebar-left',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

} );

/** END WooCommerce by Stellar Soft **/

/** Remove the Add to Cart button on Shop page **/

add_action( 'woocommerce_after_shop_loop_item', 'remove_add_to_cart_buttons', 1 );

function remove_add_to_cart_buttons() {
  if( is_product_category() || is_shop()) { 
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
  }
}

/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options –> Reading
  // Return the number of products you wanna show per page.
  $cols = 120;
  return $cols;
}
