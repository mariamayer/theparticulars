<?php

// add ACF for global calls
// {{options.your_field_bro}}

add_filter( 'timber_context', 'fancySquares_acf_options_timber_context'  );

function fancySquares_acf_options_timber_context( $context ) {
    $context['options'] = get_fields('option');
    return $context;
}
