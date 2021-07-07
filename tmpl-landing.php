<?php
/**
 * Template Name: Landing
 * Description: Landing Page Template - see pages and partials
 */
// $start = TimberHelper::start_timer();
$context = Timber::get_context();

Timber::render('pages/landing.twig', $context);

// echo TimberHelper::stop_timer( $start);
