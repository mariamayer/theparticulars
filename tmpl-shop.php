<?php
/**
 * Template Name: Shop Style
 * Description: Shop Styles Page Template - see pages and partials
 */
// $start = TimberHelper::start_timer();
$context = Timber::get_context();


	// $currentList = get_field('list');

	// foreach ( $currentList as $listItem ) {
	// 	// print_r($listItem['list_id']);

	// 	$getListJson = $jsonshopTIL = file_get_contents('http://api.shopstyle.com/api/v2/lists/'.$listItem['list_id'].'?pid=uid3569-42015337-41&limit=50');
	// 	$decodeListJson = json_decode( $getListJson , true );

	// 	$adminList[] = $decodeListJson;
	// }

	// $context['SHOPSTYLE_ACF'] = $adminList;


	// foreach ( $currentList as $favoriteList ) {
	// 	// print_r($listItem['list_id']);

	// 	$getListJson = $jsonshopTIL = file_get_contents('http://api.shopstyle.com/api/v2/lists/'.$favoriteList['list_id'].'/items?pid=uid3569-42015337-41&limit=50');
	// 	$decodeListJson = json_decode( $getListJson , true );
	// 	// array_push($decodeListJson, "product_id",$favoriteList['list_id']);
	// 	$decodeListJson['product_id'] = $favoriteList['list_id'];
	// 	$adminFavoritesList[] = $decodeListJson;
	// }

	// $context['SHOPSTYLE_ACF'] = $adminList;

	// $context['SHOPSTYLE_FAV'] = $adminFavoritesList;

	// print_r($context['SHOPSTYLE_FAV']);


Timber::render('pages/shop.twig', $context);
