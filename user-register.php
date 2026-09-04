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
    <div class="ruled"><h1><?php _e('Create an account', 'folio'); ?></h1></div>

    <form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="post" name="register">
        <input type="hidden" name="page" value="register">
        <input type="hidden" name="action" value="register_post">

        <div class="field">
            <label for="s_name"><?php _e('Name', 'folio'); ?></label>
            <?php UserForm::name_text(); ?>
        </div>
        <div class="field">
            <label for="s_email"><?php _e('Email address', 'folio'); ?></label>
            <?php UserForm::email_text(); ?>
        </div>
        <div class="field">
            <label for="s_password"><?php _e('Password', 'folio'); ?></label>
            <?php UserForm::password_text(); ?>
        </div>
        <div class="field">
            <label for="s_password2"><?php _e('Repeat password', 'folio'); ?></label>
            <?php UserForm::check_password_text(); ?>
        </div>

        <?php osc_run_hook('user_register_form'); ?>

        <div class="actions">
            <button class="btn" type="submit"><?php _e('Create account', 'folio'); ?></button>
        </div>
    </form>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
