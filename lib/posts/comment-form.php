<?php 

// rearrange comment box
// function fancySquares_move_comment_field_to_bottom( $fields ) {
//     $comment_field = $fields['comment'];
//     unset( $fields['comment'] );
//     $fields['comment'] = $comment_field;
//     return $fields;
// }

// add_filter( 'comment_form_fields', 'fancySquares_move_comment_field_to_bottom' );


/* Add Placehoder in comment Form Fields */
function fancysquares_comment_placeholders( $fields )
{
    $fields['author'] = str_replace(
        '<input',
        '<input placeholder="Name"',
        $fields['author']
    );
    $fields['email'] = str_replace(
        '<input',
        '<input placeholder="Email"',
        $fields['email']
    );
    $fields['url'] = str_replace(
        '<input',
        '<input placeholder="Website"',
        $fields['url']
    );
    return $fields;
}
add_filter( 'comment_form_default_fields', 'fancysquares_comment_placeholders' );
  
/* Add Placehoder in comment Form Field (Comment) */
function fancysquares_textarea_placeholder( $fields )
{
   
        $fields['comment_field'] = str_replace(
            '<textarea',
            '<textarea placeholder="Comment"',
            $fields['comment_field']
        );
    
  
    return $fields;
}
add_filter( 'comment_form_defaults', 'fancysquares_textarea_placeholder' );

// remove website field
function fancysquares_disable_comment_url($fields) { 
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields','fancysquares_disable_comment_url');



add_filter( 'comment_form_defaults', 'fancysquares_comment_form_defaults' );
function fancysquares_comment_form_defaults( $defaults ) {
 
    $defaults['title_reply'] = __( 'Write a comment' );
    $defaults['label_submit'] = __( 'Submit', 'custom' );
    return $defaults;
}