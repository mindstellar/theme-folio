<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * The account sidebar. Core owns some of these pages and this theme ships no
 * view for them (credits, account deletion) -- they render through core's own
 * chrome contract, inside this theme's header and footer.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}
?>
<nav class="facets" aria-label="<?php echo osc_esc_html(__('Your account', 'folio')); ?>">
    <h2><?php _e('Your account', 'folio'); ?></h2>
    <ul>
        <li><a href="<?php echo osc_esc_html(osc_user_dashboard_url()); ?>"><?php _e('Overview', 'folio'); ?></a></li>
        <li><a href="<?php echo osc_esc_html(osc_user_list_items_url()); ?>"><?php _e('Your listings', 'folio'); ?></a></li>
        <li><a href="<?php echo osc_esc_html(osc_user_alerts_url()); ?>"><?php _e('Alerts', 'folio'); ?></a></li>
        <li><a href="<?php echo osc_esc_html(osc_user_profile_url()); ?>"><?php _e('Profile', 'folio'); ?></a></li>
        <li><a href="<?php echo osc_esc_html(osc_change_user_email_url()); ?>"><?php _e('Email address', 'folio'); ?></a></li>
        <li><a href="<?php echo osc_esc_html(osc_change_user_password_url()); ?>"><?php _e('Password', 'folio'); ?></a></li>
        <li><a href="<?php echo osc_esc_html(osc_change_user_username_url()); ?>"><?php _e('Username', 'folio'); ?></a></li>
        <?php if (function_exists('osc_billing_enabled') && osc_billing_enabled()) { ?>
            <li><a href="<?php echo osc_esc_html(osc_billing_wallet_url()); ?>"><?php _e('Credits', 'folio'); ?></a></li>
        <?php } ?>
        <?php if (function_exists('osc_user_delete_url') && osc_user_delete_url() !== '') { ?>
            <li><a href="<?php echo osc_esc_html(osc_user_delete_url()); ?>"><?php _e('Delete your account', 'folio'); ?></a></li>
        <?php } ?>
    </ul>
</nav>
