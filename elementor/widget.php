<?php
if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class c2c_WhatsApp_Widget extends Widget_Base {
    public function get_name() {
        return 'c2c_whatsapp_chat';
    }

    public function get_title() {
        return __('WhatsApp Chat Button', 'c2c');
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
                 style="background:#25D366; color:white; padding:12px 20px; border-radius:8px; font-size:16px; text-decoration:none; display:inline-flex; align-items:center; gap:10px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="height:20px;" />
                Chat on WhatsApp
              </a>';
    }
}
