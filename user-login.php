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
    <div class="ruled"><h1><?php _e('Log in', 'folio'); ?></h1></div>

    <form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="post">
        <input type="hidden" name="page" value="login">
        <input type="hidden" name="action" value="login_post">

        <div class="field">
            <label for="email"><?php _e('Email address', 'folio'); ?></label>
            <?php UserForm::email_login_text(); ?>
        </div>
        <div class="field">
            <label for="password"><?php _e('Password', 'folio'); ?></label>
            <?php UserForm::password_login_text(); ?>
        </div>
        <label class="field-check">
            <?php UserForm::rememberme_login_checkbox(); ?>
            <?php _e('Keep me logged in', 'folio'); ?>
        </label>

        <?php osc_run_hook('user_form'); ?>

        <div class="actions">
            <button class="btn" type="submit"><?php _e('Log in', 'folio'); ?></button>
            <a href="<?php echo osc_esc_html(osc_recover_user_password_url()); ?>"><?php _e('Forgotten your password?', 'folio'); ?></a>
        </div>
    </form>

    <?php if (osc_users_enabled()) { ?>
        <p class="muted"><?php _e('No account yet?', 'folio'); ?>
            <a href="<?php echo osc_esc_html(osc_register_account_url()); ?>"><?php _e('Register', 'folio'); ?></a></p>
    <?php } ?>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
