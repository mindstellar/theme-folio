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
<div class="sheet-wide stack">
    <h1><?php _e('Send this listing to someone', 'folio'); ?></h1>

    <form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="post" name="sendfriend">
        <input type="hidden" name="page" value="item">
        <input type="hidden" name="action" value="send_friend_post">
        <input type="hidden" name="id" value="<?php echo (int) osc_item_id(); ?>">

        <div class="field">
            <label for="yourName"><?php _e('Your name', 'folio'); ?></label>
            <input id="yourName" type="text" name="yourName" autocomplete="name" required>
        </div>
        <div class="field">
            <label for="yourEmail"><?php _e('Your email address', 'folio'); ?></label>
            <input id="yourEmail" type="email" name="yourEmail" autocomplete="email" required>
        </div>
        <div class="field">
            <label for="friendName"><?php _e('Their name', 'folio'); ?></label>
            <input id="friendName" type="text" name="friendName" required>
        </div>
        <div class="field">
            <label for="friendEmail"><?php _e('Their email address', 'folio'); ?></label>
            <input id="friendEmail" type="email" name="friendEmail" required>
        </div>
        <div class="field">
            <label for="message"><?php _e('Message', 'folio'); ?></label>
            <textarea id="message" name="message" rows="4"></textarea>
        </div>

        <div class="actions">
            <button class="btn" type="submit"><?php _e('Send', 'folio'); ?></button>
        </div>
    </form>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
