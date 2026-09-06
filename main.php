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

osc_get_header();
?>
<div class="stack">
    <section>
        <div class="ruled">
            <h1><?php _e('Latest listings', 'folio'); ?></h1>
            <a class="push" href="<?php echo osc_esc_html(folio_browse_all_url()); ?>"><?php
                _e('Browse everything', 'folio'); ?></a>
        </div>

        <?php if (osc_count_latest_items() === 0) { ?>
            <p class="empty">
                <strong><?php _e('Nothing has been published yet', 'folio'); ?></strong>
                <?php _e('The first listing on this site will appear here.', 'folio'); ?>
            </p>
        <?php } else { ?>
            <ol class="index">
                <?php View::newInstance()->_exportVariableToView('folio_heading', 'h2');
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
                <?php // A shelf with nothing on it is still a real page, so it keeps its
                // link -- but it is dimmed, because a visitor scanning for somewhere to
                // go should be able to see which rows have nothing behind them.
                while (osc_has_categories()) {
                    $folio_stock = (int) osc_category_total_items(); ?>
                    <li>
                        <a href="<?php echo osc_esc_html(osc_search_category_url()); ?>"<?php
                            echo $folio_stock === 0 ? ' class="empty-shelf"' : ''; ?>>
                            <span class="name"><?php echo osc_esc_html(osc_category_name()); ?></span>
                            <span class="count"><?php echo osc_esc_html(number_format($folio_stock)); ?></span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </section>
    <?php } ?>
</div>
<?php osc_get_footer(); ?>
