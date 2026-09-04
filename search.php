<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * Results. The index carries the whole page; facets are native <details>
 * groups beside it, each one an ordinary link that reloads with a narrower
 * query, so filtering works with scripting off.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

osc_current_web_theme_path('common/header.php');

$folio_total   = osc_search_total_items();
$folio_pattern = osc_search_pattern();
$folio_page    = osc_search_page();
$folio_pages   = osc_search_total_pages();
?>
<div class="record-sheet">
    <section>
        <div class="ruled">
            <h1><?php
                if ($folio_pattern !== '') {
                    printf(osc_esc_html(__('Results for “%s”', 'folio')), osc_esc_html($folio_pattern));
                } else {
                    _e('All listings', 'folio');
                } ?></h1>
            <output class="muted push small"><?php
                printf(osc_esc_html(_n('%s listing', '%s listings', $folio_total, 'folio')),
                    osc_esc_html(number_format($folio_total))); ?></output>
        </div>

        <?php if ($folio_total === 0) { ?>
            <p class="empty">
                <strong><?php _e('Nothing matched', 'folio'); ?></strong>
                <?php _e('Try fewer words, or widen the area.', 'folio'); ?><br>
                <a href="<?php echo osc_esc_html(osc_search_show_all_url()); ?>"><?php _e('Show everything', 'folio'); ?></a>
            </p>
        <?php } else { ?>
            <ol class="index">
                <?php $GLOBALS['folio_heading'] = 'h2';
                while (osc_has_items()) {
                    osc_current_web_theme_path('common/record.php');
                } ?>
            </ol>

            <?php if ($folio_pages > 1) { ?>
                <nav class="pager" aria-label="<?php echo osc_esc_html(__('Pages', 'folio')); ?>">
                    <span><?php if ($folio_page > 0) { ?>
                        <a rel="prev" href="<?php echo osc_esc_html(osc_update_search_url(array('iPage' => $folio_page))); ?>">
                            &larr; <?php _e('Newer', 'folio'); ?></a>
                    <?php } ?></span>
                    <span class="muted small"><?php
                        printf(osc_esc_html(__('Page %1$s of %2$s', 'folio')),
                            osc_esc_html(number_format($folio_page + 1)),
                            osc_esc_html(number_format($folio_pages))); ?></span>
                    <span><?php if ($folio_page + 1 < $folio_pages) { ?>
                        <a rel="next" href="<?php echo osc_esc_html(osc_update_search_url(array('iPage' => $folio_page + 2))); ?>">
                            <?php _e('Older', 'folio'); ?> &rarr;</a>
                    <?php } ?></span>
                </nav>
            <?php } ?>
        <?php } ?>
    </section>

    <aside class="facets" aria-label="<?php echo osc_esc_html(__('Narrow these results', 'folio')); ?>">
        <h2><?php _e('Narrow these results', 'folio'); ?></h2>

        <?php if (osc_count_categories() > 0) { ?>
            <details open>
                <summary><?php _e('Category', 'folio'); ?></summary>
                <ul>
                    <?php $folio_cat = (int) osc_search_category_id();
                    while (osc_has_categories()) { ?>
                        <li><a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory' => osc_category_id()))); ?>"
                               <?php echo $folio_cat === (int) osc_category_id() ? 'aria-current="true"' : ''; ?>><?php
                            echo osc_esc_html(osc_category_name()); ?></a></li>
                    <?php } ?>
                </ul>
            </details>
        <?php } ?>

        <?php // Every narrowing carries the query it narrows, so a price range
        // applied to a search does not throw the search away. ?>
        <details<?php echo osc_search_price_min() !== '' || osc_search_price_max() !== '' ? ' open' : ''; ?>>
            <summary><?php _e('Price', 'folio'); ?></summary>
            <form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="get">
                <input type="hidden" name="page" value="search">
                <input type="hidden" name="sPattern" value="<?php echo osc_esc_html($folio_pattern); ?>">
                <input type="hidden" name="sCity" value="<?php echo osc_esc_html(osc_search_city()); ?>">
                <?php if (osc_search_category_id() !== '' && (int) osc_search_category_id() > 0) { ?>
                    <input type="hidden" name="sCategory" value="<?php echo (int) osc_search_category_id(); ?>">
                <?php } ?>
                <div class="field">
                    <label for="folio-min"><?php _e('From', 'folio'); ?></label>
                    <input id="folio-min" type="number" name="sPriceMin" min="0" step="any" inputmode="numeric"
                           value="<?php echo osc_esc_html(osc_search_price_min()); ?>">
                </div>
                <div class="field">
                    <label for="folio-max"><?php _e('To', 'folio'); ?></label>
                    <input id="folio-max" type="number" name="sPriceMax" min="0" step="any" inputmode="numeric"
                           value="<?php echo osc_esc_html(osc_search_price_max()); ?>">
                </div>
                <button class="btn btn-quiet btn-block" type="submit"><?php _e('Apply', 'folio'); ?></button>
            </form>
        </details>
    </aside>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
