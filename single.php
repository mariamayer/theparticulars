<?php
/**
 * Single page template
 *
 * @package  WordPress
 * @subpackage  SageTimber
 * @since  SageTimber 0.1
 */

$context = Timber::get_context();

$FEATURED_IMG = get_field('fancySquare_featured_img');

$context['FEATURED_IMG'] = $FEATURED_IMG;

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

Timber::render('pages/single.twig', $context);
