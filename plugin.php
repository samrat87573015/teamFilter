<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/*
 * Plugin Name:       teamFilter
 * Description:       Handle the Team Filter with this plugin.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Samrat
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       teamfilter
 * Domain Path:       /languages
 */


function teamFilter_enqueue_scripts()
{

    wp_enqueue_script('teamFilterVueJS', plugin_dir_url(__FILE__) . 'dist/assets/index-CkYVyPyT.js', array(), '1.0', true);

    wp_enqueue_style('teamFilterCSS', plugin_dir_url(__FILE__) . 'dist/assets/index-CEFA59VZ.css', array(), '1.0', 'all');

}

add_action('wp_enqueue_scripts', 'teamFilter_enqueue_scripts');


function teamFilter_shortcode()
{

    return '<div id="app"></div>';

}

add_shortcode('teamFilter', 'teamFilter_shortcode');


// Register Custom Post Type
function create_team_post_type()
{
    $labels = array(
        'name' => __('Teams', 'teamfilter'),
        'singular_name' => __('Team', 'teamfilter'),
        'menu_name' => __('Team', 'teamfilter'),
        'name_admin_bar' => __('Team', 'teamfilter'),
        'add_new' => __('Add New', 'teamfilter'),
        'add_new_item' => __('Add New Team Member', 'teamfilter'),
        'new_item' => __('New Team Member', 'teamfilter'),
        'edit_item' => __('Edit Team Member', 'teamfilter'),
        'view_item' => __('View Team Member', 'teamfilter'),
        'all_items' => __('All Team Members', 'teamfilter'),
        'search_items' => __('Search Team Members', 'teamfilter'),
        'parent_item_colon' => __('Parent Team Members:', 'teamfilter'),
        'not_found' => __('No team members found.', 'teamfilter'),
        'not_found_in_trash' => __('No team members found in Trash.', 'teamfilter')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'team'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('team', $args);
}

add_action('init', 'create_team_post_type');

// Register Custom Taxonomies
function create_team_taxonomies()
{
    // Add new taxonomy 'Location'
    register_taxonomy(
        'location',
        'team',
        array(
            'labels' => array(
                'name' => __('Locations', 'teamfilter'),
                'singular_name' => __('Location', 'teamfilter'),
                'search_items' => __('Search Locations', 'teamfilter'),
                'all_items' => __('All Locations', 'teamfilter'),
                'edit_item' => __('Edit Location', 'teamfilter'),
                'update_item' => __('Update Location', 'teamfilter'),
                'add_new_item' => __('Add New Location', 'teamfilter'),
                'new_item_name' => __('New Location Name', 'teamfilter'),
                'menu_name' => __('Location', 'teamfilter'),
            ),
            'hierarchical' => true, // Set this to false if you want a non-hierarchical taxonomy
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'location')
        )
    );

    // Add new taxonomy 'Role'
    register_taxonomy(
        'role',
        'team',
        array(
            'labels' => array(
                'name' => __('Roles', 'teamfilter'),
                'singular_name' => __('Role', 'teamfilter'),
                'search_items' => __('Search Roles', 'teamfilter'),
                'all_items' => __('All Roles', 'teamfilter'),
                'edit_item' => __('Edit Role', 'teamfilter'),
                'update_item' => __('Update Role', 'teamfilter'),
                'add_new_item' => __('Add New Role', 'teamfilter'),
                'new_item_name' => __('New Role Name', 'teamfilter'),
                'menu_name' => __('Role', 'teamfilter'),
            ),
            'hierarchical' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'role')
        )
    );
}

add_action('init', 'create_team_taxonomies');


