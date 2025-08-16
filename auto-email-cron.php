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
        'interval' => 60, // seconds
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
    $to = 'your-email@example.com'; // Apna email daalo
    $subject = 'Daily Report';
    $message = 'Ye tumhara daily report email hai! 😎';
    $headers = ['Content-Type: text/html; charset=UTF-8'];

    wp_mail($to, $subject, $message, $headers);
});
