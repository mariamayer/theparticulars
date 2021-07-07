<?php
/**
 *Plugin Name: Add Yoast to api
 */

// class custom_taxonomies_posts {

//  public function __construct() {
//   $post_types = get_post_types( array( 'public' => true ), 'objects' );
//   foreach ( $post_types as $post_type ) {
//    $post_type_name = $post_type->name;
//    register_rest_field( $post_type_name,
//        'pure_taxonomies',
//        array(
//            'get_callback' => array($this, 'get_all_taxonomies'),
//            'schema' => null,
//        )
//    );
//   }
//  }

//  public function get_all_taxonomies($object,$field_name,$request) {
//   $return = array();

//   // Get categories
//   $post_categories = wp_get_post_categories($object['id']);
//   foreach ($post_categories as $category) {
//    $return['categories'][] = get_category($category);
//   }

//   // Get tags
//   $post_tags = wp_get_post_tags($object['id']);
//   if (!empty($post_tags)){
//    $return['tags'] = $post_tags;
//   }

//   // Get taxonomies
//   $args = array(
//       'public'   => true,
//       '_builtin' => false
//   );
//   $output = 'names'; // or objects
//   $operator = 'and'; // 'and' or 'or'
//   $taxonomies = get_taxonomies( $args, $output, $operator );
//   foreach ( $taxonomies as $key => $taxonomy_name ) {
//    $post_taxonomies = get_the_terms($object['id'], $taxonomy_name);
//    if (is_array($post_taxonomies)) {
//     foreach ($post_taxonomies as $key2 => $post_taxonomy) {
//      $return[$taxonomy_name][] = get_term($post_taxonomy, $taxonomy_name);
//     }
//    }
//   }
//   return $return;
//  }
// }

// add_action('rest_api_init',function() {
//  $custom_taxonomies_posts = new custom_taxonomies_posts;
// });

function prepare_rest_for_yoast_prime_cat($data, $post, $request){
    $_data = $data->data;


    $primaryCat = new WPSEO_Primary_Term('category', get_the_ID());
    $primaryCat = $primaryCat->get_primary_term();
    $primaryCat = get_cat_name($primaryCat);

    $categories = get_the_category();
    foreach( $categories as $category ) {
       $defaultCat = $category->name;
       $defaultCatLink = get_category_link( $category->term_id );
    }

    if ( $primaryCat !== "" ) {
        $cat = new WPSEO_Primary_Term('category', get_the_ID());
        $cat = $cat->get_primary_term();

        $catName = get_cat_name($cat);
        $catLink = get_category_link($cat);

        $_data['fixed_category']['prime_cat_name'] = $catName = get_cat_name($cat);
        $_data['fixed_category']['prime_cat_link'] = $catLink = get_category_link($cat);

     }
     else {
       $_data['fixed_category']['prime_cat_name'] = $catName = $defaultCat;
       $_data['fixed_category']['prime_cat_link'] = $catLink = $defaultCatLink;
    }


    $data->data = $_data;

    return $data;
}
add_filter('rest_prepare_post', 'prepare_rest_for_yoast_prime_cat', 10, 3);