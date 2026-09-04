<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * Home. No hero and no promotional band: the index is the page. The search
 * control sits in the masthead, so the first thing under the navy is a record.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

osc_current_web_theme_path('common/header.php');
?>
<div class="stack">
    <section>
        <div class="ruled">
            <h1><?php _e('Latest listings', 'folio'); ?></h1>
            <a class="push" href="<?php echo osc_esc_html(osc_search_show_all_url()); ?>"><?php
                _e('Browse everything', 'folio'); ?></a>
        </div>

        <?php if (osc_count_latest_items() === 0) { ?>
            <p class="empty">
                <strong><?php _e('Nothing has been published yet', 'folio'); ?></strong>
                <?php _e('The first listing on this site will appear here.', 'folio'); ?>
            </p>
        <?php } else { ?>
            <ol class="index">
                <?php $GLOBALS['folio_heading'] = 'h2';
                while (osc_has_latest_items()) {
                    osc_current_web_theme_path('common/record.php');
                } ?>
            </ol>
        <?php } ?>
    </section>

    <?php if (osc_count_categories() > 0) { ?>
        <section>
            <div class="ruled">
                <h2><?php _e('Browse by category', 'folio'); ?></h2>
            </div>
            <ul class="classmarks">
                <?php while (osc_has_categories()) { ?>
                    <li>
                        <a href="<?php echo osc_esc_html(osc_search_category_url()); ?>">
                            <span class="name"><?php echo osc_esc_html(osc_category_name()); ?></span>
                            <span class="count"><?php echo osc_esc_html(number_format((int) osc_category_total_items())); ?></span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </section>
    <?php } ?>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
