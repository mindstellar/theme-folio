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
<div class="record-sheet">
    <section class="stack">
        <h1><?php printf(osc_esc_html(__('Hello, %s', 'folio')), osc_esc_html(osc_logged_user_name())); ?></h1>

        <div class="row">
            <a class="btn" href="<?php echo osc_esc_html(osc_item_post_url_in_category()); ?>"><?php
                _e('Publish a listing', 'folio'); ?></a>
            <a class="btn btn-quiet" href="<?php echo osc_esc_html(osc_user_list_items_url()); ?>"><?php
                _e('Your listings', 'folio'); ?></a>
        </div>

        <?php osc_run_hook('user_dashboard'); ?>
    </section>

    <?php osc_current_web_theme_path('common/account-nav.php'); ?>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
