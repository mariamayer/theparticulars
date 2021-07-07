<?php

add_filter( 'timber_context', 'fancySquares_show_instagram_results'  );

function fancySquares_show_instagram_results( $context ) {
    $context['fancySquaresInstagram'] = fancySquares_get_instagram();
    return $context;
}


function fancySquares_get_instagram()
{
  if(get_transient('instagram')) 
    {
        return get_transient('instagram');
    } 
    else 
    {
      $api = wp_remote_request("https://api.instagram.com/v1/users/5573718102/media/recent/?access_token=5573718102.1677ed0.94fc3ff78d8941b791d3d2b8f0acac6b");
      $api = json_decode($api['body']);
      $images = [];


      for($i = 0; $i < 20; $i++)
      {
        $images[$i] = [];
        $images[$i]['image'] = $api->data[$i]->images->standard_resolution->url;
        $images[$i]['url'] = $api->data[$i]->link;
        $images[$i]['likes'] = $api->data[$i]->likes->count;
      }


        set_transient('instagram', $images, 60*60*24); // expires every day
        return $images;
    }

}

// {# 
//       {% for insta in fancySquaresInstagram %}

//         {{insta['url']}}

//       {% endfor %} 
//     #}