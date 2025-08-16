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


register_activation_hook(__FILE__, 'wp_book_activate');
register_deactivation_hook(__FILE__, 'wp_book_deactivate');

function wp_book_activate() {
    // Create DB tables, default options, schedule cron jobs, etc.
    flush_rewrite_rules();
}

function wp_book_deactivate() {
    // Cleanup or remove scheduled events
    wp_clear_scheduled_hook('wp_book_cron_event');
    flush_rewrite_rules();
}

function wp_book_register_post_type() {
    register_post_type('book', [
        'labels' => [
            'name' => __('Books', 'wp-book'),
            'singular_name' => __('Book', 'wp-book'),
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-book',
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'wp_book_register_post_type');

function wp_book_register_taxonomy() {
    register_taxonomy('genre', 'book', [
        'labels' => [
            'name' => __('Genres', 'wp-book'),
            'singular_name' => __('Genre', 'wp-book'),
        ],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'wp_book_register_taxonomy');


function wp_book_list_shortcode($atts) {
    $args = [
        'post_type' => 'book',
        'posts_per_page' => 5
    ];
    $query = new WP_Query($args);

    $output = '<ul class="wp-book-list">';
    while ($query->have_posts()) {
        $query->the_post();
        $output .= '<li><a href="'. get_permalink() .'">'. get_the_title() .'</a></li>';
    }
    wp_reset_postdata();
    $output .= '</ul>';

    return $output;
}
add_shortcode('wp_book_list', 'wp_book_list_shortcode');


function wp_book_add_admin_menu() {
    add_options_page(
        'WP Book Settings',
        'WP Book',
        'manage_options',
        'wp-book',
        'wp_book_settings_page'
    );
}
add_action('admin_menu', 'wp_book_add_admin_menu');

function wp_book_settings_page() {
    echo '<div class="wrap"><h1>WP Book Settings</h1><p>Here you can manage settings.</p></div>';
}

// Shortcode for displaying cron demo status
function wp_cron_demo_shortcode() {
    // Schedule event if not already
    if ( ! wp_next_scheduled( 'wp_cron_demo_event' ) ) {
        wp_schedule_single_event( time() + 60, 'wp_cron_demo_event' );
    }

    // Return message for frontend
    return '<p>✅ Cron scheduled! It will run in 60 seconds.</p>';
}
add_shortcode( 'wp_cron_demo', 'wp_cron_demo_shortcode' );

// Hook for cron event
add_action( 'wp_cron_demo_event', 'wp_cron_demo_task' );

function wp_cron_demo_task() {
    // Example task: create a new book post
    wp_insert_post( array(
        'post_title'   => 'Cron Generated Book - ' . current_time( 'mysql' ),
        'post_content' => 'This book was auto-created by WP Cron.',
        'post_status'  => 'publish',
        'post_type'    => 'book',
    ) );
}
