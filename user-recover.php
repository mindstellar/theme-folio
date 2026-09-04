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
    <h1><?php _e('Reset your password', 'folio'); ?></h1>
    <p class="muted"><?php _e('Enter the address you registered with. We will email you a link to set a new password.', 'folio'); ?></p>

    <form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="post">
        <input type="hidden" name="page" value="login">
        <input type="hidden" name="action" value="recover_post">
        <div class="field">
            <label for="s_email"><?php _e('Email address', 'folio'); ?></label>
            <?php UserForm::email_text(); ?>
        </div>
        <div class="actions">
            <button class="btn" type="submit"><?php _e('Send the link', 'folio'); ?></button>
        </div>
    </form>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
