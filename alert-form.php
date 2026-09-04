<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * The save-this-search control, rendered by core inside the results page.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}
?>
<div class="field">
    <label for="alert_email"><?php _e('Email me when something new matches', 'folio'); ?></label>
    <input id="alert_email" type="email" name="alert_email" autocomplete="email"
           value="<?php echo osc_esc_html(osc_logged_user_email()); ?>">
</div>
