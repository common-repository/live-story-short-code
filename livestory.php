<?php

/*
 * Plugin Name:       Live Story
 * Plugin URI:        https://livestory.nyc/how-it-works/
 * Description:       Embed Live Story experiences in pages with a shortcode
 * Version:           1.0.2
 * Author:            Live Story
 * Author URI:        https://www.livestory.nyc
 */

if (!defined('ABSPATH')) {
    // Exit if accessed directly
    exit;
}

define('LIVESTORY_API_URL', 'https://api.livestory.io');

function livestory_register_settings() {

    register_setting('livestory_settings', 'livestory_enable', array('type' => 'string', 'default' => 'enabled'));
    register_setting('livestory_settings', 'livestory_brandcode', array('type' => 'string', 'default' => ''));
}

function livestory_register_adminpage() {

    add_menu_page('Live Story', 'Live Story', 'manage_options', 'live-story-short-code/livestory-config.php', '', plugins_url('live-story-short-code/images/icon.png'));
}

function livestory_load_mainscript() {

    $lsEnabled = get_option('livestory_enable', 'enabled') === 'enabled';
    $lsBrandCode = get_option('livestory_brandcode');

    if (!$lsBrandCode && defined('LIVESTORY_BRANDCODE') && LIVESTORY_BRANDCODE) {
        $lsBrandCode = LIVESTORY_BRANDCODE;
    }

    if (!$lsEnabled || !$lsBrandCode) {
        return;
    }

    wp_register_script(
        'livestory-mainscript',
        'https://assets.livestory.io/dist/livestory-' . $lsBrandCode . '.min.js',
        array('jquery')
    );

    wp_enqueue_script( 'livestory-mainscript' );
}

function livestory_shortcode($atts) {

    /* var_dump(get_option('livestory_enable', 'default')); */
    $lsEnabled = get_option('livestory_enable', 'enabled') === 'enabled';

    if (!$lsEnabled) {
        return;
    }

    /* var_dump($lsEnabled); */

    if (!$atts['id'] || !$atts['type']) {
        return;
    }

    $ls_id = $atts['id'];

    $ls_container = 'id="ls-' . $ls_id . '" data-id="' . $ls_id . '"';
    if ($atts['store']) {
        $ls_container .= ' data-store="' . $atts['store'] . '"';
    } else {
        $ls_container .= ' data-store="STORE_ID"';
    }

    if ($atts['lang']) {
        $ls_container .= ' data-lang="' . $atts['lang'] . '"';
    }

    $ls_type = ($atts['type'] == 'layout') ? 'wall' : (($atts['type'] == 'destination') ? 'wallgroup' : '');

    $seo_content = '';

    if ($ls_type === 'wall') {

        $wallURL = LIVESTORY_API_URL . '/content/layout/' . $ls_id;

        if ($atts['lang']) {
            $wallURL .= "?lang_code=" . $atts['lang'];
        }

        $seo_response = wp_remote_get($wallURL);
        $seo_response_code = $seo_response['response']['code'];

        if ($seo_response_code === 200) {

            $seo_content .= $seo_response['body'];
        }
    }

    if ($ls_type === 'wallgroup') {

        $wallgroupURL = LIVESTORY_API_URL . '/content/destination/' . $ls_id;

        if ($atts['lang']) {
            $wallgroupURL .= "?lang_code=" . $atts['lang'];
        }

        $seo_response = wp_remote_get($wallgroupURL);
        $seo_response_code = $seo_response['response']['code'];

        if ($seo_response_code === 200) {

            $seo_content .= $seo_response['body'];
        }
    }

    $allowed_tags = array (
        'style' => array( 'type' => true),
        'iframe' => array( 'style', 'src', 'width', 'height', 'frameborder', 'allowfullscreen', 'allow', 'loading' ),
        'div' => array ( 
            'id' => true,
            'data-id' => true,
            'data-store' => true,
            'data-lang' => true,
            'data-ssr' => true,
            'class' => true,
            'style' => true,
            'data-layout_id' => true,
            'data-layout_types' => true,
            'data-layout_placeholder' => true,
            'ssr-breakpoint-wrapper' => true,
            'data-ssr-processed' => true,
            'ssr-breakpoint' => true,
            'data-wall-id' => true,
            'data-revision' => true,
            'data-wall-lang' => true,
            'data-breakpoint' => true,
            'data-placeholder_id' => true,
            'data-item-id' => true,
            'data-width' => true,
            'data-height' => true,
            'data-left' => true,
            'data-right' => true,
            'data-top' => true,
            'data-bottom' => true,
            'data-zindex' => true,
            'data-columns' => true,
            'data-item-class' => true,
            'data-alt' => true,
            'muted' => true,
            'aria-label' => true,
            'data-timestamp' => true
        ),
        'ul' => array( 'class' => true, 'role' => true),
        'li' => array( 'class' => true, 'role' => true ),
        'a' => array( 'aria-label' => true, 'data-target' => true, 'href' => true ),
        'p' => array( '"' => true ),
        'h2' => array(),
        'span' => array(),
        'h1' => array(),
        'video' => array(),
        'img' => array( 'class' => true, 'role' => true, 'data-src' => true, 'srcset' => true, 'sizes' => true, 'alt' => true),
        'script' => array( 'src')
    );

    ob_start();
    ?>

    <div <?php echo wp_kses($ls_container, 'entities'); ?>><?php echo wp_kses( $seo_content, $allowed_tags ); ?></div>
    <script type="text/javascript">(function(w){w.fpls_load=w.fpls_load||[];w.fpls_load.push(function(){
    w.ls_<?php echo wp_kses($ls_id, 'entities'); ?>=w.ls_<?php echo wp_kses($ls_id, 'entities'); ?>||new LiveStory("ls-<?php echo wp_kses($ls_id, 'entities'); ?>", {type:"<?php echo wp_kses($ls_type, 'entities'); ?>"})})})(window);</script>

    <?php
    return wp_kses(ob_get_clean(), $allowed_tags);
}

add_action('admin_init', 'livestory_register_settings');
add_action('admin_menu', 'livestory_register_adminpage');
add_action('wp_enqueue_scripts', 'livestory_load_mainscript');
add_shortcode('livestory', 'livestory_shortcode');
