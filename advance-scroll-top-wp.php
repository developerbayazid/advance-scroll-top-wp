<?php
/*
 * Plugin Name:       Advance Scroll To Top
 * Plugin URI:        https://github.com/developerbayazid/advance-scroll-top-wp
 * Description:       Smoothly scroll to top of the page.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Bayazid Hasan
 * Author URI:        https://github.com/developerbayazid
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       astt
*/

// Including CSS
add_action('wp_enqueue_scripts', 'astt_enqueue_style');
function astt_enqueue_style(){
    wp_enqueue_style( 'astt-style', plugins_url('css/astt-style.css', __FILE__), array(), '1.0.0');
}

//Including Admin Css
add_action('admin_enqueue_scripts', 'astt_admin_enqueue_style');
function astt_admin_enqueue_style(){
    wp_enqueue_style('astt-admin-style', plugins_url('css/astt-admin-styles.css', __FILE__), array(), '1.0.0');
}

// Including JS
add_action('wp_enqueue_scripts', 'astt_enqueue_scripts');
function astt_enqueue_scripts(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('astt-plugin', plugins_url('js/astt-plugin.js', __FILE__), array('jquery'),'1.0.0', true);
}

// jQuery plugin setting activation
add_action('wp_footer', 'astt_scroll_script');
function astt_scroll_script(){
    ?>
    <script>
        jQuery(document).ready(function () {
            jQuery.scrollUp();
        });
    </script>

    <?php
}

/**
 * Plugin Options Page functions
 */

add_action('admin_menu', 'astt_create_admin_menu_page');
function astt_create_admin_menu_page(){
    add_menu_page('Scroll To Top Page', 'Scroll To Top', 'manage_options', 'astt_create_admin_menu', 'astt_create_admin_page', 'dashicons-arrow-up-alt', 100);
}

function astt_create_admin_page(){
    ?>
    <div class="astt_main_area">
        <div class="astt_body_area astt_common">
            <h3 id="title"><?php echo esc_attr('Scroll To Top', 'astt'); ?></h3>
            <form action="options.php" method="post">
                <?php wp_nonce_field('update-options'); ?>
                
                <!-- Background Color -->
                <label for="astt-bg-color" id="astt-bg-color"><?php echo esc_attr('Background Color', 'astt'); ?></label>
                <small>Change your background color.</small>
                <input type="color" name="astt-bg-color" id="astt-bg-color" value="<?php echo get_option('astt-bg-color'); ?>">
                <!-- Border Radius -->
                <label for="astt-border-rad" id="astt-border-rad"><?php echo esc_attr('Border Radius', 'astt') ?></label>
                <small>You can use border radius from here.(use 25px for better look)</small>
                <input type="text" name="astt-border-rad" id="astt-border-rad" placeholder="use 25px for better look" value="<?php echo get_option('astt-border-rad'); ?>">

                <input type="hidden" name="action" value="update">
                <input type="hidden" name="page_options" value="astt-bg-color, astt-border-rad">
                <input type="submit" value="<?php _e('Save Change', 'astt'); ?>">
            </form>
        </div>
        <div class="astt_sidebar_area astt_common">
            <h3 id="title"><?php echo esc_attr('About Author', 'astt'); ?></h3>
            <img src="https://avatars.githubusercontent.com/u/70211199?v=4" alt=<?php echo esc_attr('Bayazid Hasan'); ?>>
            <p> <b><i>Hi, I am Bayazid Hasan. I am a web application developer.</i></b> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum voluptas assumenda quam? Delectus alias distinctio odit? Excepturi distinctio nobis sit, hic ipsa ut maiores earum. Enim quidem odit fuga nisi, ipsam, numquam impedit voluptatibus tempore, iste id nesciunt dolorum facere?</p>
        </div>
    </div>

    <?php
}

add_action('wp_head', 'astt_scroll_customize');
function astt_scroll_customize(){
    ?>
    <style>
        #scrollUp {
            background-color: <?php echo get_option('astt-bg-color'); ?>;
            border-radius: <?php echo get_option('astt-border-rad'); ?>;
        }
    </style>

    <?php
}

/**
 * Plugin Redirect Function
 */

 register_activation_hook( __FILE__, 'astt_activation_plugin');
 function astt_activation_plugin(){
   add_option('astt_plugin_activation_do_redirect', true);
 }
 
 add_action('admin_init', 'astt_plugin_redirect');
 function astt_plugin_redirect(){
   if(get_option('astt_plugin_activation_do_redirect', false)){
     delete_option('astt_plugin_activation_do_redirect');
     if(!isset($_GET['active-multi'])){
       wp_safe_redirect(admin_url('admin.php?page=astt_create_admin_menu'));
       exit;
     }
   }
 }


?>