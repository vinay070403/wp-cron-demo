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

