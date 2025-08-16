## Auto Email Cron
Contributors: vinay
Tags: cron, email, automation, wp-cron
Requires at least: 5.0
Tested up to: 6.6
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically send emails using WP-Cron at a scheduled interval.

## Description 

This plugin demonstrates how to use WP-Cron to send automated emails.
When activated, it will schedule a recurring event every 2 minutes 
and send an email to the configured address.

You can customize:
- Email recipient
- Subject
- Message
- Schedule interval

## Installation

1. Download the plugin as a ZIP file or clone it into your `wp-content/plugins` directory.
2. Activate the plugin from the **Plugins** menu in WordPress.
3. The plugin will automatically schedule the cron event and start sending emails.

 ## Frequently Asked Questions 

= How often does the email get sent? =
By default, every 2 minutes (you can change it in the code).

= Can I change the recipient email? =
Yes, open the plugin file and replace the `$to` email address.

= Will this work if my site has low traffic? =
WordPress cron jobs are traffic-dependent. If you want exact scheduling,
you may need to set up a real server cron job to call `wp-cron.php`.


## Changelog 

= 1.0 =
* Initial release with WP-Cron email functionality.

== Upgrade Notice ==

= 1.0 =
First release - sends an email automatically every 2 minutes.

== Screenshots ==

1. No UI, runs in the background.


## 🕒 Scheduled Actions / Cron Jobs

This plugin uses WordPress Action Scheduler to handle background tasks.

A cron event action_scheduler_run_queue is scheduled automatically.

This ensures queued actions (like background processing, API sync, etc.) run without affecting page load.

The original cron event is not modified, only additional tasks are scheduled when required.

⚠️ Note: If Action Scheduler is disabled or WP-Cron is turned off, some background tasks may not run.


## Features
- Register custom post type **Books**
- Add custom taxonomies (Genre, Author, etc.)
- Manage book metadata (Publisher, Year, ISBN, etc.)
- Shortcode to display books
- Scheduled cron job to handle background tasks

## Installation
1. Download or clone this repository into your `wp-content/plugins/` directory.
2. Activate the plugin from the WordPress admin dashboard.
3. Start adding and managing your books.

## Shortcodes
- `[wp_books]` → Display a list of books on any page or post.

Example:
```html
[wp_books]
