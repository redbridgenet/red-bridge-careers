<?php
/*
 * WordPress plugin uninstallation script.
 *
 * Emphasis is put on using the 'uninstall.php' way of uninstalling the plugin rather than register_uninstall_hook.
 *
 * @see: http://codex.wordpress.org/Function_Reference/register_uninstall_hook#uninstall.php
 * 
 */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

$option_name = 'highlightjs_fwp_settings';

// For Single site
if ( !is_multisite() ) {
    delete_option( $option_name );
} 
// For Multisite
else {
    // For regular options.
    global $wpdb;
    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
    $original_blog_id = get_current_blog_id();
    foreach ( $blog_ids as $blog_id ) 
    {
        switch_to_blog( $blog_id );
        delete_option( $option_name );  
    }
    switch_to_blog( $original_blog_id );

    // For site options.
    delete_site_option( $option_name );  
}