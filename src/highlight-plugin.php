<?php 

/**
 * Plugin Name: Code Highlight Plugin
 * Plugin URI: http://wajek.id/wordpress/docs-plugin
 * Description: Plugin for highlighting code
 * Version: 1.0
 * Author: Moch. Rizal Rachmadani
 * Author URI: http://blog.wajek.id
 */

class WajekHighlightPlugin {

    private static $instance;

    public static function instance() {
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'scripts'));
        add_action('wp_print_footer_scripts', array($this, 'footer'));
    }

    function scripts() {
        if(!is_admin()) {
            wp_enqueue_style('highlight.js-css', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/atom-one-dark-reasonable.min.css', array(), false);
            wp_enqueue_style('highlight.js-custom-css', plugins_url('style.css', __FILE__), array(), false, 'all');
            wp_enqueue_script('highlight.js-script', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/highlight.min.js', array(), false, true);
            wp_enqueue_script('perfect-scrollbar-script', plugins_url('scripts/perfect-scrollbar.min.js', __FILE__), array(), false, true);
        }
    }

    function footer() {
        if(!is_admin()) {
        ?>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', (event) => {
                document.querySelectorAll('pre code').forEach((block) => {
                    hljs.highlightBlock(block);
                    const ps = new PerfectScrollbar(block);
                });
            });
        </script>
        <?php
        }
    }

}

WajekHighlightPlugin::instance();