<?php
/**
 * Template Name: About
 * Description: About Page Template - see pages and partials
 */
// $start = TimberHelper::start_timer();
$context = Timber::get_context();

$recentPosts = array(
	// Get post type project
	'post_type' => 'post',
	'posts_per_page' => 3,
	'category__not_in' => array(3)
);
$context['recentPostsPartOne'] = Timber::get_posts( $recentPosts );

Timber::render('pages/about.twig', $context);

// echo TimberHelper::stop_timer( $start);
