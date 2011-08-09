<?php
/*
Plugin Name: Manage Others Posts Capabilities
Plugin URI: 
Description: Restrict users without capability to edit others posts see other uses posts
Author: George Mamadashvili
Version: 0.1
Author URI: http://twitter.com/mamaduka
*/

add_filter( 'views_edit-post', 'mamaduka_mopc_edit_views' );
add_filter( 'views_edit-page', 'mamaduka_mopc_edit_views' );
add_action( 'pre_get_posts', 'mamaduka_mopc_set_query' );

/*
 * 	If current user doesn't have capabilities to edit_others_posts
 *  Filter views on post edit screen
 * 
 *  @since 0.1
 */
function mamaduka_mopc_edit_views( $views ) {
	
	if ( !current_user_can( 'edit_others_posts' ) ) {
		unset( $views['all'] );
		unset( $views['publish'] );
		unset( $views['trash'] );
		
		return $views;
	} else {
		return $views;
	}
}

/*
 * If current user doesn't have capabilities to edit_others_posts
 * Set wp_query to display only his/her posts 
 * 
 * @since 0.1 
 */
function mamaduka_mopc_set_query( $wp_query ) {
	global $current_user;
    if ( is_admin() && !current_user_can( 'edit_others_posts' ) ) {
        $wp_query->set( 'author', $current_user->ID );
    }
}
?>
