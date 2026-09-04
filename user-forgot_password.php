<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

osc_current_web_theme_path('common/header.php');
?>
<div class="sheet stack">
    <h1><?php _e('Choose a new password', 'folio'); ?></h1>

    <form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="post">
        <input type="hidden" name="page" value="login">
        <input type="hidden" name="action" value="forgot_post">
        <input type="hidden" name="userId" value="<?php echo (int) Params::getParam('userId'); ?>">
        <input type="hidden" name="code" value="<?php echo osc_esc_html(Params::getParam('code')); ?>">

        <div class="field">
            <label for="new_password"><?php _e('New password', 'folio'); ?></label>
            <input id="new_password" type="password" name="new_password" autocomplete="new-password" required minlength="6">
        </div>
        <div class="field">
            <label for="new_password2"><?php _e('Repeat the new password', 'folio'); ?></label>
            <input id="new_password2" type="password" name="new_password2" autocomplete="new-password" required minlength="6">
        </div>
        <div class="actions">
            <button class="btn" type="submit"><?php _e('Save the new password', 'folio'); ?></button>
        </div>
    </form>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
