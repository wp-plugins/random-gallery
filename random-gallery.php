<?php
/*
Plugin Name: Random Gallery
Description: Display a random selection of photos from an arbitrarily large list.
License: GPLv2 or later
Author: David Greenwold
Author URI: http://www.greenwold.com/web-projects/#random-gallery
Version: 00.01
*/
class dgplugins {
function random_gallery($attr)  { // $attr is the default name given by wp to an array consisting of the key/value pairs defined by the user in the shortcode	// Sanitize the user input.
	sanitize_text_field($attr['ids']);	sanitize_text_field($attr['shownum']);	$ids_in = explode(",", $attr['ids']); // Split the ids string into an array.	$count_in = count($ids_in); // Get the length of the array (the number of ids).	// Try to account for mistakes the user might make in entering shownum.
	if( !isset($attr['shownum']) || empty($attr['shownum']) || $attr['shownum'] < 1 || $attr['shownum'] > $count_in ) {		$attr['shownum'] = $count_in;	}
	// Create an array called $ids_out, which has a length equal to shownum and contains randomly selected values from $ids_in.	// Use a helper array called $rand, which also has a length equal to shownum. For each index, use the intermediate variable $randi. Only append it to $rand if it has not yet been used.		$rand[0] = mt_rand(0, $count_in - 1);	$ids_out[0] = $ids_in[$rand[0]];
	for ($i = 1; $i < $attr['shownum']; $i++) {		$randi = mt_rand(0, $count_in - 1);		while (in_array($randi, $rand)) {			$randi = mt_rand(0, $count_in - 1);		}		$rand[$i] = $randi;		$ids_out[$i] = $ids_in[$rand[$i]];	}
	// Use the new ids list ($ids_out) to call the regular gallery shortcode.	echo do_shortcode('[gallery ids='.implode(",", $ids_out).' orderby="rand"]');}}// Create a shortcode that calls the function.
add_shortcode('random-gallery',array('dgplugins','random_gallery'));