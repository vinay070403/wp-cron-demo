<?php
/*
Plugin Name: Auto Email Cron
Description: WP-Cron example to send email automatically
Version: 1.0
Author: Vinay
*/

defined('ABSPATH') || exit;

// 1. Custom cron schedule (optional)
add_filter('cron_schedules', function($schedules){
    $schedules['every_minute'] = [
        'interval' => 120, // seconds
        'display'  => 'Every Minute'
    ];
    return $schedules;
});

// 2. Activate plugin -> schedule event
register_activation_hook(__FILE__, function() {
    if(!wp_next_scheduled('send_daily_email_event')){
        wp_schedule_event(time(), 'every_minute', 'send_daily_email_event');
    }
});

// 3. Deactivate plugin -> clear scheduled event
register_deactivation_hook(__FILE__, function() {
    $timestamp = wp_next_scheduled('send_daily_email_event');
    if($timestamp){
        wp_unschedule_event($timestamp, 'send_daily_email_event');
    }
});
// 4. Function jo email bheje
add_action('send_daily_email_event', function() {
    $to = 'tanish.chavada@gmail.com'; // Apna email daalo
    $subject = 'Daily Report';
    $message = 'Ye tumhara daily report email hai! 😎';
    $headers = ['Content-Type: text/html; charset=UTF-8'];

    wp_mail($to, $subject, $message, $headers);
});


// Admin Menu
add_action('admin_menu', function() {
    add_options_page(
        'Auto Email Cron Settings',
        'Auto Email Cron',
        'manage_options',
        'auto-email-cron',
        'auto_email_cron_settings_page'
    );
});

// Settings Page UI
function auto_email_cron_settings_page() {
    ?>
    <div class="wrap">
        <h1>Auto Email Cron Settings</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('auto_email_cron_settings');
                do_settings_sections('auto_email_cron_settings');
                submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register Settings
add_action('admin_init', function() {
    register_setting('auto_email_cron_settings', 'auto_email_to');
    register_setting('auto_email_cron_settings', 'auto_email_subject');
    register_setting('auto_email_cron_settings', 'auto_email_message');

    add_settings_section('auto_email_cron_main', 'Email Settings', null, 'auto_email_cron_settings');

    add_settings_field('auto_email_to', 'Recipient Email', function() {
        echo '<input type="email" name="auto_email_to" value="'.esc_attr(get_option('auto_email_to', 'you@example.com')).'" class="regular-text">';
    }, 'auto_email_cron_settings', 'auto_email_cron_main');

    add_settings_field('auto_email_subject', 'Email Subject', function() {
        echo '<input type="text" name="auto_email_subject" value="'.esc_attr(get_option('auto_email_subject', 'Daily Report')).'" class="regular-text">';
    }, 'auto_email_cron_settings', 'auto_email_cron_main');

    add_settings_field('auto_email_message', 'Email Message', function() {
        echo '<textarea name="auto_email_message" rows="5" class="large-text">'.esc_textarea(get_option('auto_email_message', 'Ye tumhara daily report email hai! 😎')).'</textarea>';
    }, 'auto_email_cron_settings', 'auto_email_cron_main');
});
