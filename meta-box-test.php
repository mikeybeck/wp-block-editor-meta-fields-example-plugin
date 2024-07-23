<?php

/*
Plugin Name: Sidebar example
*/

function sidebar_plugin_register() {
    wp_register_script(
        'plugin-sidebar-js',
        plugins_url( 'plugin-sidebar.js', __FILE__ ),
        array(
            'react',
            'wp-plugins',
            'wp-editor',
            'wp-components',
            'wp-data',
        )
    );
//    wp_register_style(
//        'plugin-sidebar-css',
//        plugins_url( 'plugin-sidebar.css', __FILE__ )
//    );
}
add_action( 'init', 'sidebar_plugin_register' );

function sidebar_plugin_add_meta_block_field() {
    register_post_meta( 'post', '_sidebar_plugin_meta_block_field', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ) );
    register_post_meta( 'page', '_sidebar_plugin_meta_block_field', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'auth_callback' => function() {
            return current_user_can('edit_pages');
        }
    ) );
}
add_action( 'init', 'sidebar_plugin_add_meta_block_field' );


function custom_post_type_support() {
    add_post_type_support( 'post', 'custom-fields' );
    add_post_type_support( 'page', 'custom-fields' );
}
add_action( 'init', 'custom_post_type_support' );

function sidebar_plugin_script_enqueue() {
    wp_enqueue_script( 'plugin-sidebar-js' );
    wp_enqueue_style( 'plugin-sidebar-css' );
}
add_action( 'enqueue_block_editor_assets', 'sidebar_plugin_script_enqueue' );


