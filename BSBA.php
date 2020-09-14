<?php
/*
Plugin Name: BSBA
Plugin URI: http://wordpress.org/plugins/BSBA
Description: For show pictures in 'before|after' style
Author: Karen Melikyan
Version: 1
*/

require_once('back/functions.php');

/**
 * Include styles & scripts
 */
function addAdminStyles()
{
    wp_enqueue_style("cdn1", "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css", '', '1.0.0', 'all' );
    wp_enqueue_style("cdn2", "https://use.fontawesome.com/releases/v5.10.2/css/all.css", '', '1.0.0', 'all' );
    wp_enqueue_style("bsba-admin", "/wp-content/plugins/BSBA/front/bsba.css", '', '1.0.0', 'all' );

    wp_enqueue_script("cdn3", "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js", array(), '1.0', true );
    wp_enqueue_script("cdn4", "https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js", array(), '1.0', true );
    wp_enqueue_script("cdn5", "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js", array(), '1.0', true );
    wp_enqueue_script("bsba-admin", "/wp-content/plugins/BSBA/front/bsba.js", array(), '1.0', true );
}

function addShortcodeStyles()
{
    wp_enqueue_style("shortcode-css", "/wp-content/plugins/BSBA/front/bsba.css", array(), "");
    wp_enqueue_script("shortcode-js", "/wp-content/plugins/BSBA/front/bsba.js", array('jquery'), '', true );
}
    add_action('admin_enqueue_scripts', 'addAdminStyles');
    add_action('wp_enqueue_scripts', 'addShortcodeStyles');

/**
 * create admin menu 
 */
function createPluginMenu()
{
    add_menu_page( 'Custom Menu Page Title', 'BSBA', 'manage_options', 'BSBA/front/index.php', '', 'dashicons-welcome-widgets-menus', 90 );
}
    add_action( 'admin_menu', 'createPluginMenu' );

/**
 * Session start & destroy
 */
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy ();
}

add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

/**
 * create shortcode
 */
function createShortcode()
{
    return createTemplate();
}

add_shortcode('bsba_shortcode', 'createShortcode');     

/**
 * create db
 */
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE `{$wpdb->base_prefix}BSBA` (
    id int unsigned NOT NULL auto_increment,
    pic_name varchar(255) NOT NULL,
    created_at datetime NULL,
    expires_at datetime NULL,
    PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
?>