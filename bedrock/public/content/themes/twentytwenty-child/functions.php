<?php

add_action('wp_enqueue_scripts', 'tt_child_enqueue_parent_styles');

function tt_child_enqueue_parent_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

add_action('after_setup_theme', 'generate_child_setup');

function generate_child_setup()
{
    add_editor_style('editor.css');
}
