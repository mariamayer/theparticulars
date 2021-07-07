<?php
/*
 * Template Name: Interview
 * Template Post Type: post
 */

$context = Timber::get_context();

$FEATURED_IMG_INTERVIEWEE = get_field('interviewee_image');
$context['FEATURED_IMG_INTERVIEWEE'] = $FEATURED_IMG_INTERVIEWEE;

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
// print_r(get_page_template_slug());

Timber::render('pages/single.twig', $context);
