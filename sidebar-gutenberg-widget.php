<?php
register_sidebar(array(
    'name' => 'Content Gate CTA',
    'id' => 'content-gate-cta',
    'description' => 'Appears on gated content pages',
    'before_widget' => '<aside id="%1$s" class="widget-area %2$s w-full content-center text-center bg-tertiary mb-0">',
    'after_widget' => '</aside>',
    'before_title' => '',
    'after_title' => '',
));
function register_content_gate_cta_block() {
    // Register the block for the widget area
    register_block_type('theme/content-gate-cta', array(
        'render_callback' => 'render_content_gate_cta_block',
    ));
}
add_action('init', 'register_content_gate_cta_block');

// Render the widget area in the block
function render_content_gate_cta_block() {
    ob_start();
    dynamic_sidebar('content-gate-cta'); // Render the 'content-gate-cta' sidebar
    return ob_get_clean();
}

function enqueue_content_gate_cta_block_editor_assets() {
    wp_enqueue_script(
        'content-gate-cta-block',
        get_template_directory_uri() . '/block-editor.js', // Update path as needed
        array('wp-blocks', 'wp-element', 'wp-editor'),
        '1.0',
        true
    );
}
add_action('enqueue_block_editor_assets', 'enqueue_content_gate_cta_block_editor_assets');
