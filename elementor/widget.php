<?php
if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class c2c_WhatsApp_Widget extends Widget_Base {
    public function get_name() {
        return 'c2c_whatsapp_chat';
    }

    public function get_title() {
        return __('WhatsApp Chat Button', 'click2chat-button');
    }

    public function get_icon() {
        return 'eicon-whatsapp';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function render() {
        if (get_option('c2c_enable_button') != '1') return;

        $start = get_option('c2c_business_hours_start', '09:00');
        $end = get_option('c2c_business_hours_end', '18:00');
        date_default_timezone_set(get_option('timezone_string') ?: 'Asia/Kolkata');
        $now = date('H:i');
        if ($now < $start || $now > $end) return;

        $number = preg_replace('/\D/', '', get_option('c2c_whatsapp_number'));
        if (!$number) return;

        $message = urlencode(get_option('c2c_chat_message'));
        $mobile_only = get_option('c2c_mobile_only') === '1';

        echo '<style>';
        if ($mobile_only) {
            echo '@media (min-width:768px) { .c2c-elementor-button { display:none !important; } }';
        }
        echo '</style>';

        echo '<a class="c2c-elementor-button" href="https://wa.me/' . esc_attr($number) . '?text=' . esc_attr($message) . '" 
                 target="_blank"
                 style="background:#25D366; color:white; padding:12px 20px; border-radius:8px; font-size:16px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:10px;">
                <svg width="31" height="30" class="_96z7 _brandPortalIcon__whatsappLogo" fill="none"><title id="whatsapp-logo">WhatsApp logo</title><path d="M15.565 0C7.057 0 .133 6.669.13 14.865c-.002 2.621.71 5.179 2.06 7.432L0 30l8.183-2.067a15.89 15.89 0 007.376 1.81h.006c8.508 0 15.432-6.67 15.435-14.866.002-3.97-1.602-7.707-4.517-10.516C23.569 1.551 19.694.001 15.565 0zm0 27.232h-.005c-2.302 0-4.56-.596-6.53-1.722l-.47-.268-4.854 1.226 1.296-4.56-.305-.467a11.983 11.983 0 01-1.962-6.576C2.738 8.052 8.494 2.511 15.57 2.511c3.426.001 6.647 1.288 9.07 3.623s3.756 5.44 3.754 8.742c-.003 6.813-5.758 12.356-12.83 12.356zm7.037-9.255c-.386-.185-2.282-1.084-2.636-1.209-.353-.123-.61-.187-.867.185-.256.372-.996 1.209-1.22 1.456-.226.248-.451.278-.837.093-.386-.186-1.629-.578-3.101-1.844-1.147-.984-1.921-2.2-2.146-2.573-.225-.371-.024-.572.169-.757.173-.165.386-.433.578-.65.192-.217.256-.372.386-.62.128-.247.064-.465-.033-.65-.097-.187-.867-2.015-1.19-2.758-.312-.724-.63-.627-.867-.639-.225-.01-.481-.013-.74-.013-.255 0-.674.093-1.028.465-.353.372-1.35 1.27-1.35 3.098 0 1.829 1.382 3.595 1.575 3.843.193.247 2.72 4 6.589 5.61.92.381 1.638.61 2.199.782.924.283 1.765.242 2.429.147.74-.107 2.282-.898 2.602-1.765.322-.867.322-1.611.226-1.766-.094-.155-.352-.248-.738-.435z" fill="currentColor"></path></svg>
                Chat on WhatsApp
              </a>';
    }
}
