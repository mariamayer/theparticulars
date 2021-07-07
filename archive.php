<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */

$templates = array( 'pages/archive.twig', 'pages/index.twig' );

$context = Timber::get_context();

$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
// print_r($category_id);
// // print_r($);

$context['title'] = 'Archive';

if ( is_day() ) {

	$context['title'] = 'Archive: '.get_the_date( 'D M Y' );

} else if ( is_month() ) {

	$context['title'] = 'Archive: '.get_the_date( 'M Y' );

} else if ( is_year() ) {

	$context['title'] = 'Archive: '.get_the_date( 'Y' );

} else if ( is_tag() ) {

	$context['title'] = single_tag_title( '', false );

} else if ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'pages/archive-' . get_query_var( 'cat' ) . '.twig' );

} else if ( is_post_type_archive() ) {

	$context['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'pages/archive-' . get_post_type() . '.twig' );

}

$firstEight = array(
	// Get post type project
	'post_type' => 'post',
	'cat' => $category_id,
	'posts_per_page' => 8,
);
$context['firstEight'] = Timber::get_posts( $firstEight );

$offsetEight = array(
	// Get post type project
	'post_type' => 'post',
	'cat' => $category_id,
	'offset' => 8,
	'posts_per_page' => 6,
);
$context['offsetEight'] = Timber::get_posts( $offsetEight );

// grab featured post from category
$term = get_queried_object();
$FEATURED_POST_ID = get_field('featured_post', $term );
// set the values before hand and do the logic outside of twig
// set values in array then ADD to the context of the page
$FEATURED_POST_TITLE = get_the_title($FEATURED_POST_ID[0]);
$FEATURED_POST_IMG_ID = get_field('image_left',$FEATURED_POST_ID[0]);
$FEATURED_POST_IMG_ID_Center = get_field('center_image',$FEATURED_POST_ID[0]);
$FEATURED_POST_EXCERPT = get_the_excerpt($FEATURED_POST_ID[0]);
$FEATURED_POST_LINK = get_the_permalink($FEATURED_POST_ID[0]);

$context['FEATURED_POST'] = array(
	"main_id" => $term->term_id,
	"main_category" => $term->name,
	"title" => $FEATURED_POST_TITLE ,
	"image_id" => $FEATURED_POST_IMG_ID,
	"image_id_center" => $FEATURED_POST_IMG_ID_Center,
	"excerpt" => $FEATURED_POST_EXCERPT,
	"link" => $FEATURED_POST_LINK,
	// "is_parent" => $children
);

// interview
if ( is_category('3') ){
	$context['INTERVIEW_ALPHABET_GROUPS'] = Timber::get_terms('category',
		array('include'=>'799,800,801,802,803','hide_empty' => true)
	);

	$context['INTERVIEW_MISC_CATEGORIES'] = Timber::get_terms('category',
		array('include'=>'796,797,795,794','hide_empty' => true)
	);
}

//$context['posts'] = Timber::get_posts();

Timber::render( $templates, $context );