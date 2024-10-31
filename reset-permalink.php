<?php
/*
Plugin Name: Reset Permalink
Plugin URI: http://benjaminsterling.com/wordpress-plugins/reset-permalink/
Description: 
Version: 0.1
Author: Benjamin Sterling
Author URI: http://kenzomedia.com
License: 

	Copyright 2011  Benjamin Sterling  (email : benjamin.sterling@kenzomedia.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
global $is_resetable;
$is_resetable = false;
function rp_get_sample_permalink_html( $arg, $post_id ){
	global $is_resetable;
	if( ereg('edit-slug', $arg) ){
		$is_resetable = true;
		$arg .= "<span id='reset=permalink-btn'><a onclick=\"resetPermalink(".$post_id."); return false;\" href='' class='button' >Reset Permalink</a></span>\n";
	}
	
	return $arg;
}

function rs_admin_print_footer_scripts( $arg ){
	global $is_resetable;
	if( $is_resetable ){
?>
<script type='text/javascript'>
	var resetPermalink = function(post_id){
			jQuery.post(ajaxurl, {
				action: 'sample-permalink',
				post_id: post_id,
				new_slug: '',
				new_title: jQuery('#title').val(),
				samplepermalinknonce: jQuery('#samplepermalinknonce').val()
			}, function(data) {
				jQuery('#edit-slug-box').html(data);
				makeSlugeditClickable();
			});
	}
</script>
<?php
	}
}

add_action( 'admin_print_footer_scripts', 'rs_admin_print_footer_scripts', 1,1 );
add_filter( 'get_sample_permalink_html', 'rp_get_sample_permalink_html',5,2 );
?>