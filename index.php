<?php
/**
 * The main template file
 *
 * @package  WordPress
 * @subpackage  SageTimber
 * @since  SageTimber 0.1
 */

$context = Timber::get_context();
// $context['posts'] = Timber::get_posts();
$templates = array( 'pages/index.twig' );
// if ( is_home() ) {
// 	array_unshift( $templates, 'pages/home.twig' );
// }

$firstEight = array(
	// Get post type project
	'post_type' => 'post',
	'posts_per_page' => 8,
);
$context['firstEight'] = Timber::get_posts( $firstEight );


Timber::render( $templates, $context );
