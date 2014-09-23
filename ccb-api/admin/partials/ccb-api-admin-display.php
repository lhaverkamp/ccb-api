<?php

/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Ccb_Api
 * @subpackage Ccb_Api/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2>Community Church Builder Configuration</h2>
    <?php settings_errors(); ?>
    
    <form method="post" action="options.php">
        <?php settings_fields( 'ccb_plugin_options' ); ?>
        <?php do_settings_sections( 'ccb_plugin_options' ); ?>
        <?php submit_button(); ?>
    </form>
</div>
