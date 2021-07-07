<?php
/**
 * Template Name: Home
 * Description: Home Page Template - see pages and partials
 */
// $start = TimberHelper::start_timer();
$context = Timber::get_context();

	// recent posts not in interview
	$recentPosts = array(
		// Get post type project
		'post_type' => 'post',
		'posts_per_page' => 3,
		'category__not_in' => array(3)
	);
	$context['recentPostsPartOne'] = Timber::get_posts( $recentPosts );

	// recent posts not in interview part 2
	$recentPostsB = array(
		// Get post type project
		'post_type' => 'post',
		'offset' => 3,
		'posts_per_page' => 3,
		'category__not_in' => array(3)
	);
	$context['recentPostsPartTwo'] = Timber::get_posts( $recentPostsB );

	// recent posts not in interview part 2
	$recentInterviews = array(
		// Get post type project
		'post_type' => 'post',
		'cat'         => 3,
		'posts_per_page' => 3
	);
	$context['recentInterviews'] = Timber::get_posts( $recentInterviews );

	$FEATURED_POST_ID = get_field('featured_post');
	// set the values before hand and do the logic outside of twig
	// set values in array then ADD to the context of the page
	$FEATURED_CAT = get_the_category($FEATURED_POST_ID[0]);

	$FEATURED_CATEGORY_NAME = $term ? $term->name : $FEATURED_CAT[0]->name;
	$FEATURED_POST_TITLE = get_the_title($FEATURED_POST_ID[0]);
	$FEATURED_POST_IMG_ID = get_field('image_left',$FEATURED_POST_ID[0]);
	$FEATURED_POST_IMG_ID_Center = get_field('center_image',$FEATURED_POST_ID[0]);
	$FEATURED_POST_EXCERPT = get_the_excerpt($FEATURED_POST_ID[0]);
	$FEATURED_POST_LINK = get_the_permalink($FEATURED_POST_ID[0]);

	$context['FEATURED_POST'] = array(
		//"main_id" => $term->term_id,
		"main_category" => $FEATURED_CATEGORY_NAME,
		"title" => $FEATURED_POST_TITLE ,
		"image_id" => $FEATURED_POST_IMG_ID,
		"image_id_center" => $FEATURED_POST_IMG_ID_Center,
		"excerpt" => $FEATURED_POST_EXCERPT,
		"link" => $FEATURED_POST_LINK,
		// "is_parent" => $children
	);

	// $FEATURED_POST_ID = get_field('featured_post');
	$context['REWARDS_STYLE_TITLE'] = get_field('rewards_style_title');
	$context['REWARDS_STYLE_TITLE_SC'] = get_field('rewards_style_shortcode');

	$context['INSTA_SHOP_FEED'] = get_field('posts_favorite_looks', 'options');

	$context['INTERVIEWS_HOME'] = get_field('interviews_post_home');





Timber::render('pages/front-page.twig', $context);

// echo TimberHelper::stop_timer( $start);