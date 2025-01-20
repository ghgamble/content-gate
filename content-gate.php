<?php

/**
* Plugin Name: Content Gate
* Plugin URI: https://www.scaledagile.com/
* Description: Gate Content with CTA
* Version: 1.0
* Author: Grace Gamble
* Author URI: https://www.scaledagile.com/
**/

// don't execute if not WordPress
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'SAI_CONTENT_GATE_VERSION', '1.0.0' );

// Function to detect if the visitor is a Google crawler
function is_google_bot() {
    if (!isset($_SERVER['HTTP_USER_AGENT'])) {
        return false;
    }
    
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $crawler_patterns = array(
        'googlebot',
        'google-sitemaps',
        'mediapartners-google'
    );
    
    foreach ($crawler_patterns as $pattern) {
        if (strpos($user_agent, $pattern) !== false) {
            return true;
        }
    }
    
    return false;
}

// Register sidebar for the restricted content notice
register_sidebar(array(
    'name' => 'Content Gate CTA',
    'id' => 'content-gate-cta',
    'description' => 'Appears on gated content pages after the excerpt',
    'before_widget' => '<aside id="%1$s" class="widget-area %2$s content-center text-center mb-0">',
    'after_widget' => '</aside>',
    'before_sidebar' => '<div class="mt-5 has-primary-lightest-background-color">', 
    'after_sidebar' => '</div>',                    
    'before_title' => '',
    'after_title' => '',
));

// Filter the content to dynamically display the sidebar based on `tag-safe-next`
function content_gate_with_article_class($content) {
    if (is_admin() || is_feed()) {
        return $content;
    }
    
    if (!is_singular()) {
        return $content;
    }
    
    if (is_user_logged_in() || is_google_bot()) {
        return $content;
    }

    $post_tags = get_the_tags();

    $has_safe_next_tag = false;
    if ($post_tags) {
        foreach ($post_tags as $tag) {
            if ($tag->slug === 'safe-next') {
                $has_safe_next_tag = true;
                break;
            }
        }
    }

    if ($has_safe_next_tag) {
        $cta_sidebar = '';
        if (is_active_sidebar('content-gate-cta')) {
            ob_start();
            dynamic_sidebar('content-gate-cta');
            $cta_sidebar = ob_get_clean();
        }
        $content .= $cta_sidebar;
    }

    return $content;
}

add_filter('the_content', 'content_gate_with_article_class');

add_action('init', 'wpse325327_add_excerpts_to_pages');
function wpse325327_add_excerpts_to_pages() {
    add_post_type_support('page', 'excerpt');
}
