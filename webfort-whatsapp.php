<?php
/**
 * Plugin Name:       Webfort Whatsapp
 * Description:       Simple Whatsapp Chat Plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Webfort Technologies
 * Author URI:        https://thewebfort.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

add_action('admin_menu', 'wf_add_menu');

function wf_add_menu() { 
    add_menu_page( 
        'Page Title', 
        'Whatsapp Chat', 
        'edit_posts', 
        'menu_slug', 
        'wf_admin_page_contents', 
        'dashicons-whatsapp' 
    );
}

function wf_admin_page_contents() {
    ?>
        <!-- Page Title -->
        <h1> <?php esc_html_e( 'Whatsapp Chat Setting' ); ?> </h1>

        <form method="POST" action="options.php">
            <?php 
                settings_fields( 'chat-setting-page' );
                do_settings_sections( 'chat-setting-page' );
                submit_button();
            ?>
        </form>
    <?php
}


add_action( 'admin_init', 'wf_settings_init' );

function wf_settings_init() {

    add_settings_section(
        'wf_page_setting_section',
        '',
        '',
        'chat-setting-page'
    );

    add_settings_field(
        'whatsapp_number_setting_field',
        'WhatsApp Number',
        'chat_setting_markup',
        'chat-setting-page',
        'wf_page_setting_section'
    );

    register_setting( 'chat-setting-page', 'whatsapp_number_setting_field' );


    add_settings_field(
        'whatsapp_message_setting_field',
        'Pre-Filled Message',
        'chat_setting_markup2',
        'chat-setting-page',
        'wf_page_setting_section'
    );

    register_setting( 'chat-setting-page', 'whatsapp_message_setting_field' );


    add_settings_field(
        'whatsapp_display_setting_field',
        'Display Settings',
        'chat_setting_markup3',
        'chat-setting-page',
        'wf_page_setting_section'
    );

    register_setting( 'chat-setting-page', 'whatsapp_display_setting_field' );
}


function chat_setting_markup() {
    ?>  
        <div>
            <label for="my-input"></label>
            <input type="text" id="whatsapp_number_setting_field" name="whatsapp_number_setting_field" value="<?php echo get_option( 'whatsapp_number_setting_field' ); ?>">
            <div style="margin-top: 5px">( E.g. Enter number with country code +915123456789 )</div>
        <div>
    <?php
}

function chat_setting_markup2() {
    ?>  
        <div class="mb-3">
            <textarea id="whatsapp_message_setting_field" name="whatsapp_message_setting_field" rows="3"><?php echo get_option( 'whatsapp_message_setting_field' ); ?></textarea>
        </div>
    <?php
}

function chat_setting_markup3() {
    ?>  
        <div class="mb-3">
            <input class="form-check-input" type="checkbox" <?php echo ( get_option( 'whatsapp_display_setting_field' ) == "on") ? 'checked="checked"': ''; ?> id="whatsapp_display_setting_field" name="whatsapp_display_setting_field" role="switch">
        </div>
        <div><?php echo get_option( 'whatsapp_display_setting_field' ); ?></div>
    <?php
}

function func_load_wc_whatsapp_chat() {
    wp_register_style( 'wc_style_plugin', plugin_dir_url( __FILE__ ).'css/wc-style.css');
	wp_enqueue_style('wc_style_plugin');
}
add_action('wp_enqueue_scripts', 'func_load_wc_whatsapp_chat');

function whatsapp_button_after_body_open_tag() {
	include('html-layout.php');
}

if( get_option( 'whatsapp_display_setting_field' ) == "on"){
    add_action('wp_body_open', 'whatsapp_button_after_body_open_tag');
}


?>