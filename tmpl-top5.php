<?php
/*
 * Template Name: Top 5
 * Template Post Type: post
 */

$context = Timber::get_context();

$FEATURED_IMG = get_field('fancySquare_featured_img');
$context['FEATURED_IMG'] = $FEATURED_IMG;
$featured = get_field('featured_product');
$context['FEATURED_PRODUCT_FIRST'] = array_slice($featured, 0, 1);
$context['FEATURED_PRODUCTS'] = array_slice($featured, 1);

$tags = wp_get_post_tags($post->ID);
if ($tags) {
	$tag_ids = array();
	foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
}
$relatedContent = array(
	'tag__in' => $tag_ids,
	'post__not_in' => array($post->ID),
	'posts_per_page'=>3, // Number of related posts that will be shown.
	'caller_get_posts'=>1
);
$context['RELATED_CONTENT'] = Timber::get_posts( $relatedContent );

$templateSlug = get_page_template_slug();
$context['PAGE_TEMPLATE'] = $templateSlug;


Timber::render('pages/top5.twig', $context);
