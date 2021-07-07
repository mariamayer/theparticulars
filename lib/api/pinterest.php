<?php

namespace RMH\FancySquares\Api\Pinterest;


function getRecentPin()
{
  // app secret = 49fa5e058f09dd4216c876f36a1b42be1faa254d2b2427fafe478aec3d420bc5
  // app/client id = 4872925939645825692
  // access code = 84982aae7cfe967a
  // access token = AXgJGDHOxzr8Wcmx9cYZKryB8LFsFI-bQcbyOCFDoCgp9oBBXwAAAAA

  if(get_transient('pin')) 
    {
        return get_transient('pin');
    } 

    $api = wp_remote_request("https://api.pinterest.com/v3/pidgets/users/jackiemiranne/pins/");
	$api = json_decode($api['body']);
  	
  	$pins = [];


  for($i = 0; $i < 2; $i++)
  {
    $pins[$i] = [];
    $pins[$i]['image'] = $api->data->pins[$i]->images->{'237x'}->url;
    $pins[$i]['id'] = $api->data->pins[$i]->id;

  }



  set_transient('pin', $pins, 60*60*1); // expires every hour
  return $pins;

}