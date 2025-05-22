<?php
/**
 * Plugin Name: WhatsApp Chat Button
 * Description: Adds a floating WhatsApp chat button to your site with settings for number, message, business hours, device visibility, and button position (left/right).
 * Version: 1.0
 * Author: Prathap Rathod
 * Author URI: https://prathaprathod.in
 * Plugin URI: https://prathaprathod.in/whatsapp-chat-button
 * Text Domain: whatsapp-chat-button
 */

defined('ABSPATH') or die('No script kiddies please!');

// Register Settings
function wcb_register_settings() {
    add_option('wcb_whatsapp_number', '');
    add_option('wcb_chat_message', 'Hello! I am interested in your services.');
    add_option('wcb_enable_button', '1');
    add_option('wcb_business_hours_start', '09:00');
    add_option('wcb_business_hours_end', '18:00');
    add_option('wcb_mobile_only', '0');
    add_option('wcb_position', 'right');
    add_option('wcb_offset_bottom', '20');
    add_option('wcb_offset_side', '20');
    add_option('wcb_theme', 'light');

    register_setting('wcb_options_group', 'wcb_whatsapp_number');
    register_setting('wcb_options_group', 'wcb_chat_message');
    register_setting('wcb_options_group', 'wcb_enable_button');
    register_setting('wcb_options_group', 'wcb_business_hours_start');
    register_setting('wcb_options_group', 'wcb_business_hours_end');
    register_setting('wcb_options_group', 'wcb_mobile_only');
    register_setting('wcb_options_group', 'wcb_position');
    register_setting('wcb_options_group', 'wcb_offset_bottom');
    register_setting('wcb_options_group', 'wcb_offset_side');
    register_setting('wcb_options_group', 'wcb_theme');
}
add_action('admin_init', 'wcb_register_settings');

// Admin Menu
function wcb_register_menu_page() {
    add_menu_page(
        'WhatsApp Chat Settings',
        'WhatsApp Chat',
        'manage_options',
        'wcb-settings',
        'wcb_settings_page',
        'dashicons-format-chat',
        90
    );
}
add_action('admin_menu', 'wcb_register_menu_page');

// Admin Page
function wcb_settings_page() {
    ?>
    <div class="wrap">
        <h1>WhatsApp Chat Button Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('wcb_options_group'); ?>
            <table class="form-table">
                <tr>
                    <th>Enable Button</th>
                    <td><input type="checkbox" name="wcb_enable_button" value="1" <?php checked(1, get_option('wcb_enable_button'), true); ?> /></td>
                </tr>
                <tr>
                    <th>WhatsApp Number</th>
                    <td><input type="text" name="wcb_whatsapp_number" value="<?php echo esc_attr(get_option('wcb_whatsapp_number')); ?>" /></td>
                </tr>
                <tr>
                    <th>Default Message</th>
                    <td><input type="text" name="wcb_chat_message" value="<?php echo esc_attr(get_option('wcb_chat_message')); ?>" style="width:400px;" /></td>
                </tr>
                <tr>
                    <th>Business Hours</th>
                    <td>
                        <input type="time" name="wcb_business_hours_start" value="<?php echo esc_attr(get_option('wcb_business_hours_start')); ?>" />
                        to
                        <input type="time" name="wcb_business_hours_end" value="<?php echo esc_attr(get_option('wcb_business_hours_end')); ?>" />
                    </td>
                </tr>
                <tr>
                    <th>Show on Mobile Only</th>
                    <td><input type="checkbox" name="wcb_mobile_only" value="1" <?php checked(1, get_option('wcb_mobile_only'), true); ?> /></td>
                </tr>
                <tr>
                    <th>Button Position</th>
                    <td>
                        <select name="wcb_position">
                            <option value="right" <?php selected('right', get_option('wcb_position')); ?>>Right</option>
                            <option value="left" <?php selected('left', get_option('wcb_position')); ?>>Left</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Bottom Offset (px)</th>
                    <td><input type="number" name="wcb_offset_bottom" value="<?php echo esc_attr(get_option('wcb_offset_bottom')); ?>" /></td>
                </tr>
                <tr>
                    <th>Side Offset (px)</th>
                    <td><input type="number" name="wcb_offset_side" value="<?php echo esc_attr(get_option('wcb_offset_side')); ?>" /></td>
                </tr>
                <tr>
                    <th>Theme</th>
                    <td>
                        <select name="wcb_theme">
                            <option value="light" <?php selected('light', get_option('wcb_theme')); ?>>Light</option>
                            <option value="dark" <?php selected('dark', get_option('wcb_theme')); ?>>Dark</option>
                        </select>
                    </td>
                </tr>
            </table>

            <h3>Preview</h3>
            <div id="wcb-preview" style="position:relative; height:100px;">
                <div style="
                    position: absolute;
                    bottom: <?php echo esc_attr(get_option('wcb_offset_bottom', '20')); ?>px;
                    <?php echo get_option('wcb_position', 'right'); ?>: <?php echo esc_attr(get_option('wcb_offset_side', '20')); ?>px;
                    background-color: <?php echo get_option('wcb_theme') === 'dark' ? '#075E54' : '#25D366'; ?>;
                    color: white;
                    padding: 10px 16px;
                    border-radius: 50px;
                    font-size: 16px;
                    display: inline-flex;
                    align-items: center;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
                    transition: transform 0.3s;
                    cursor: pointer;
                " onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                    <span style="margin-right: 8px;"><svg width="31" height="30" class="_96z7 _brandPortalIcon__whatsappLogo" fill="none"><title id="whatsapp-logo">WhatsApp logo</title><path d="M15.565 0C7.057 0 .133 6.669.13 14.865c-.002 2.621.71 5.179 2.06 7.432L0 30l8.183-2.067a15.89 15.89 0 007.376 1.81h.006c8.508 0 15.432-6.67 15.435-14.866.002-3.97-1.602-7.707-4.517-10.516C23.569 1.551 19.694.001 15.565 0zm0 27.232h-.005c-2.302 0-4.56-.596-6.53-1.722l-.47-.268-4.854 1.226 1.296-4.56-.305-.467a11.983 11.983 0 01-1.962-6.576C2.738 8.052 8.494 2.511 15.57 2.511c3.426.001 6.647 1.288 9.07 3.623s3.756 5.44 3.754 8.742c-.003 6.813-5.758 12.356-12.83 12.356zm7.037-9.255c-.386-.185-2.282-1.084-2.636-1.209-.353-.123-.61-.187-.867.185-.256.372-.996 1.209-1.22 1.456-.226.248-.451.278-.837.093-.386-.186-1.629-.578-3.101-1.844-1.147-.984-1.921-2.2-2.146-2.573-.225-.371-.024-.572.169-.757.173-.165.386-.433.578-.65.192-.217.256-.372.386-.62.128-.247.064-.465-.033-.65-.097-.187-.867-2.015-1.19-2.758-.312-.724-.63-.627-.867-.639-.225-.01-.481-.013-.74-.013-.255 0-.674.093-1.028.465-.353.372-1.35 1.27-1.35 3.098 0 1.829 1.382 3.595 1.575 3.843.193.247 2.72 4 6.589 5.61.92.381 1.638.61 2.199.782.924.283 1.765.242 2.429.147.74-.107 2.282-.898 2.602-1.765.322-.867.322-1.611.226-1.766-.094-.155-.352-.248-.738-.435z" fill="currentColor"></path></svg></span> Chat with us
                </div>
            </div>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Display Button
function wcb_add_whatsapp_chat_button() {
    if (get_option('wcb_enable_button') != '1') return;

    $start = get_option('wcb_business_hours_start', '09:00');
    $end = get_option('wcb_business_hours_end', '18:00');
    $timezone = get_option('timezone_string') ?: 'Asia/Kolkata';
    date_default_timezone_set($timezone);

    $current_time = date('H:i');
    if ($current_time < $start || $current_time > $end) return;

    $is_mobile_only = get_option('wcb_mobile_only') === '1';
    $position = get_option('wcb_position', 'right');
    $offset_bottom = get_option('wcb_offset_bottom', '20');
    $offset_side = get_option('wcb_offset_side', '20');
    $theme = get_option('wcb_theme', 'light');

    $number = preg_replace('/\D/', '', get_option('wcb_whatsapp_number'));
    if (!$number) return;

    $message = urlencode(get_option('wcb_chat_message'));

    ?>
    <style>
        #wcb-whatsapp-button {
            position: fixed;
            bottom: <?php echo esc_attr($offset_bottom); ?>px;
            <?php echo $position; ?>: <?php echo esc_attr($offset_side); ?>px;
            background-color: <?php echo $theme === 'dark' ? '#075E54' : '#25D366'; ?>;
            color: white;
            padding: 12px 20px;
            border-radius: 50px;
            font-size: 16px;
            z-index: 9999;
            display: flex;
            align-items: center;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            transition: transform 0.3s;
        }
        #wcb-whatsapp-button:hover {
            transform: scale(1.1);
        }
        <?php if ($is_mobile_only): ?>
        @media (min-width: 768px) {
            #wcb-whatsapp-button { display: none !important; }
        }
        <?php endif; ?>
    </style>
    <a id="wcb-whatsapp-button"
       href="https://wa.me/<?php echo esc_attr($number); ?>?text=<?php echo esc_attr($message); ?>"
       target="_blank"
       style="position:fixed; bottom:20px; <?php echo esc_attr($side_position); ?> background-color:#25D366; color:white; padding:12px 20px; border-radius:50px; font-size:16px; z-index:9999; display:flex; align-items:center; text-decoration:none; box-shadow:0 4px 6px rgba(0,0,0,0.2);">
        <svg width="31" height="30" class="_96z7 _brandPortalIcon__whatsappLogo" fill="none"><title id="whatsapp-logo">WhatsApp logo</title><path d="M15.565 0C7.057 0 .133 6.669.13 14.865c-.002 2.621.71 5.179 2.06 7.432L0 30l8.183-2.067a15.89 15.89 0 007.376 1.81h.006c8.508 0 15.432-6.67 15.435-14.866.002-3.97-1.602-7.707-4.517-10.516C23.569 1.551 19.694.001 15.565 0zm0 27.232h-.005c-2.302 0-4.56-.596-6.53-1.722l-.47-.268-4.854 1.226 1.296-4.56-.305-.467a11.983 11.983 0 01-1.962-6.576C2.738 8.052 8.494 2.511 15.57 2.511c3.426.001 6.647 1.288 9.07 3.623s3.756 5.44 3.754 8.742c-.003 6.813-5.758 12.356-12.83 12.356zm7.037-9.255c-.386-.185-2.282-1.084-2.636-1.209-.353-.123-.61-.187-.867.185-.256.372-.996 1.209-1.22 1.456-.226.248-.451.278-.837.093-.386-.186-1.629-.578-3.101-1.844-1.147-.984-1.921-2.2-2.146-2.573-.225-.371-.024-.572.169-.757.173-.165.386-.433.578-.65.192-.217.256-.372.386-.62.128-.247.064-.465-.033-.65-.097-.187-.867-2.015-1.19-2.758-.312-.724-.63-.627-.867-.639-.225-.01-.481-.013-.74-.013-.255 0-.674.093-1.028.465-.353.372-1.35 1.27-1.35 3.098 0 1.829 1.382 3.595 1.575 3.843.193.247 2.72 4 6.589 5.61.92.381 1.638.61 2.199.782.924.283 1.765.242 2.429.147.74-.107 2.282-.898 2.602-1.765.322-.867.322-1.611.226-1.766-.094-.155-.352-.248-.738-.435z" fill="currentColor"></path></svg> &nbsp;
        Chat with us
    </a>
    <?php
}
add_action('wp_footer', 'wcb_add_whatsapp_chat_button');

// Gutenberg Block
function wcb_register_block() {
    wp_register_script(
        'wcb-block-editor',
        plugins_url('block/index.js', __FILE__),
        ['wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'],
        filemtime(plugin_dir_path(__FILE__) . 'block/index.js')
    );

    wp_register_style(
        'wcb-block-style',
        plugins_url('block/style.css', __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . 'block/style.css')
    );

    register_block_type('wcb/whatsapp-chat-button', [
        'editor_script' => 'wcb-block-editor',
        'style' => 'wcb-block-style',
        'render_callback' => 'wcb_block_render',
    ]);
}
add_action('init', 'wcb_register_block');

function wcb_block_render() {
    ob_start();
    wcb_add_whatsapp_chat_button();
    return ob_get_clean();
}

// Elementor Widget
function wcb_register_elementor_widget() {
    if (!did_action('elementor/loaded')) return;

    require_once plugin_dir_path(__FILE__) . 'elementor/widget.php';
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \WCB_WhatsApp_Widget());
}
add_action('elementor/widgets/widgets_registered', 'wcb_register_elementor_widget');

// Enqueue Admin Styles
function wcb_enqueue_admin_styles($hook) {
    if ($hook !== 'toplevel_page_wcb-settings') return;

    wp_enqueue_style('wcb-admin-style', plugins_url('admin-style.css', __FILE__), [], time());
}
add_action('admin_enqueue_scripts', 'wcb_enqueue_admin_styles');
