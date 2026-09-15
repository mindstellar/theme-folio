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

osc_get_header();

$folio_total   = osc_search_total_items();
$folio_pattern = osc_search_pattern();
$folio_page    = osc_search_page();
$folio_pages   = osc_search_total_pages();

// Normalised in functions.php, because the searchbar needs the same value and a
// second copy of that cast is how one of the two copies goes wrong.
$folio_cat      = folio_search_category_id();
$folio_cat_name = $folio_cat > 0 ? osc_search_category_name() : '';

/*
 * The shelf whose sections the facet column opens: the current category when it
 * is a root, its parent when it is not. Standing in a section, the useful list
 * is that section's neighbours, not the whole library.
 */
$folio_cat_row = $folio_cat > 0 ? osc_get_category('id', $folio_cat) : null;
$folio_branch  = is_array($folio_cat_row) && (int) ($folio_cat_row['fk_i_parent_id'] ?? 0) > 0
    ? (int) $folio_cat_row['fk_i_parent_id']
    : $folio_cat;

/*
 * Where the visitor is standing, for the empty state. A shelf and a town are one
 * kind of narrowing and read after "in"; a price range is another and gets its
 * own clause, because "nothing in Cell Phones and that price range" is not a
 * sentence anyone writes.
 */
$folio_scope = array_filter(array($folio_cat_name, osc_search_city()), 'strlen');
$folio_priced = osc_search_price_min() !== '' || osc_search_price_max() !== '';

/*
 * Order. Four plain links, each one the current query with two parameters
 * rewritten, so a catalogue can be read by price as well as front to back. Core
 * allows i_price, dt_pub_date, dt_expiration and relevance as columns and
 * asc/desc as the type; it hands the type back as 0 or 1, which is what the
 * current-marker compares against.
 *
 * Declared up here rather than beside the facet that renders it, because the
 * heading needs the active order's name too: the results heading read the same
 * words whether the set was ordered by date or by price, so the one control a
 * visitor is most likely to have just used confirmed nothing.
 */
$folio_order      = osc_search_order();
$folio_order_desc = (int) osc_search_order_type() === 1;
$folio_orders     = array(
    array('dt_pub_date', 'desc', __('Newest first', 'folio')),
    array('dt_pub_date', 'asc', __('Oldest first', 'folio')),
    array('i_price', 'asc', __('Price: low to high', 'folio')),
    array('i_price', 'desc', __('Price: high to low', 'folio')),
);

$folio_order_name = '';
foreach ($folio_orders as $folio_o) {
    if ($folio_order === $folio_o[0] && $folio_order_desc === ($folio_o[1] === 'desc')) {
        $folio_order_name = $folio_o[2];
        break;
    }
}

// What is currently narrowing the set, in the words the facets use for it.
$folio_applied = array();
if ($folio_order_name !== '') {
    $folio_applied[] = $folio_order_name;
}
if (osc_search_price_min() !== '' && osc_search_price_max() !== '') {
    $folio_applied[] = sprintf(
        __('%1$s to %2$s', 'folio'),
        osc_format_price(((float) osc_search_price_min()) * 1000000),
        osc_format_price(((float) osc_search_price_max()) * 1000000)
    );
} elseif (osc_search_price_min() !== '') {
    $folio_applied[] = sprintf(__('From %s', 'folio'), osc_format_price(((float) osc_search_price_min()) * 1000000));
} elseif (osc_search_price_max() !== '') {
    $folio_applied[] = sprintf(__('Up to %s', 'folio'), osc_format_price(((float) osc_search_price_max()) * 1000000));
}
?>
<div class="record-sheet">
    <section>
        <?php // The filters come after every result in the source, so on a long page
        // they are a long way down for a keyboard or a screen reader. This is the
        // same object as the masthead's skip link: invisible until it has focus. ?>
        <a class="skip" href="#folio-facets"><?php _e('Skip to filters', 'folio'); ?></a>

        <?php if ($folio_cat_name !== '') {
            /*
             * The same trail a listing shows, so one category reads the same way
             * whether it is reached as a result set or through a listing. The last
             * step is dropped: it is the page, and the heading under this says it.
             */
            $folio_crumbs = folio_category_trail($folio_cat);
            array_pop($folio_crumbs); ?>
            <nav class="crumbs" aria-label="<?php echo osc_esc_html(__('Breadcrumb', 'folio')); ?>">
                <a href="<?php echo osc_esc_html(osc_base_url()); ?>"><?php _e('Home', 'folio'); ?></a>
                <span aria-hidden="true">&rsaquo;</span>
                <a href="<?php echo osc_esc_html(folio_browse_all_url()); ?>"><?php _e('All listings', 'folio'); ?></a>
                <?php foreach ($folio_crumbs as $folio_step) { ?>
                    <span aria-hidden="true">&rsaquo;</span>
                    <a href="<?php echo osc_esc_html($folio_step['url']); ?>"><?php
                        echo osc_esc_html($folio_step['name']); ?></a>
                <?php } ?>
            </nav>
        <?php } ?>

        <div class="ruled">
            <h1><?php
                /*
                 * The heading names the shelf you are standing on. Branching on the
                 * pattern alone headed every category page "All listings", which is
                 * the same words the browse-everything link uses -- so a visitor who
                 * clicked a category got no confirmation that anything had happened.
                 */
                if ($folio_pattern !== '' && $folio_cat_name !== '') {
                    printf(
                        osc_esc_html(__('Results for “%1$s” in %2$s', 'folio')),
                        osc_esc_html($folio_pattern),
                        osc_esc_html($folio_cat_name)
                    );
                } elseif ($folio_pattern !== '') {
                    printf(osc_esc_html(__('Results for “%s”', 'folio')), osc_esc_html($folio_pattern));
                } elseif ($folio_cat_name !== '') {
                    echo osc_esc_html($folio_cat_name);
                } else {
                    _e('All listings', 'folio');
                } ?></h1>
            <p class="tally push"><?php
                printf(osc_esc_html(_n('%s listing', '%s listings', $folio_total, 'folio')),
                    osc_esc_html(number_format($folio_total))); ?></p>
        </div>

        <?php
        /*
         * What is applied, stated where the results are rather than only in the
         * facet column -- which on a phone begins three screens below this. The
         * trailing link is the only visible route to the filters at any width:
         * the skip link above is deliberately invisible until it has focus, which
         * serves a keyboard and abandons a thumb.
         */
        ?>
        <p class="applied">
            <?php if ($folio_applied !== array()) { ?>
                <span class="applied-terms"><?php
                    echo osc_esc_html(implode(' · ', $folio_applied)); ?></span>
            <?php } ?>
            <a class="applied-more" href="#folio-facets"><?php _e('Sort and filter', 'folio'); ?></a>
        </p>

        <?php if ($folio_total === 0) { ?>
            <p class="empty">
                <strong><?php _e('Nothing matched', 'folio'); ?></strong>
                <?php
                /*
                 * Name the constraint rather than guessing at it. "Try fewer words"
                 * was shown to visitors who had typed none, on a category page that
                 * simply had nothing in it.
                 */
                if ($folio_pattern !== '') {
                    printf(osc_esc_html(__('No listing matches “%s”.', 'folio')), osc_esc_html($folio_pattern));
                } elseif ($folio_priced && $folio_scope !== array()) {
                    // The shelf is not empty -- the price range emptied it. Saying
                    // "nothing here yet" would be a claim the page cannot support.
                    printf(
                        osc_esc_html(__('Nothing in %s falls in that price range.', 'folio')),
                        osc_esc_html(implode(', ', $folio_scope))
                    );
                } elseif ($folio_priced) {
                    _e('Nothing falls in that price range.', 'folio');
                } elseif ($folio_scope !== array()) {
                    printf(
                        osc_esc_html(__('There is nothing in %s yet.', 'folio')),
                        osc_esc_html(implode(', ', $folio_scope))
                    );
                } else {
                    _e('There is nothing published here yet.', 'folio');
                } ?><br>

                <?php // The price is the narrowing most likely to be the culprit and
                // the one a visitor is least likely to remember setting, so dropping
                // it is offered as an action rather than described as advice.
                if ($folio_priced) { ?>
                    <a href="<?php echo osc_esc_html(osc_update_search_url(array(
                        'sPriceMin' => null, 'sPriceMax' => null, 'iPage' => null,
                    ))); ?>"><?php _e('Remove the price range', 'folio'); ?></a>
                    <span class="sep" aria-hidden="true">&middot;</span>
                <?php } ?>
                <a href="<?php echo osc_esc_html(folio_browse_all_url()); ?>"><?php _e('Show everything', 'folio'); ?></a>
            </p>
        <?php } else { ?>
            <ol class="index">
                <?php View::newInstance()->_exportVariableToView('folio_heading', 'h2');
                while (osc_has_items()) {
                    osc_current_web_theme_path('common/record.php');
                } ?>
            </ol>

            <?php if ($folio_pages > 1) { ?>
                <?php // Previous and next, not newer and older: the set can be ordered
                // by price now, and on that ordering a date word is simply wrong. ?>
                <nav class="pager" aria-label="<?php echo osc_esc_html(__('Pages', 'folio')); ?>">
                    <?php if ($folio_page > 0) { ?>
                        <a class="prev" rel="prev" href="<?php echo osc_esc_html(osc_update_search_url(array('iPage' => $folio_page))); ?>">&larr;
                            <?php _e('Previous', 'folio'); ?></a>
                    <?php } ?>
                    <span class="tally small"><?php
                        printf(osc_esc_html(__('Page %1$s of %2$s', 'folio')),
                            osc_esc_html(number_format($folio_page + 1)),
                            osc_esc_html(number_format($folio_pages))); ?></span>
                    <?php if ($folio_page + 1 < $folio_pages) { ?>
                        <a class="next" rel="next" href="<?php echo osc_esc_html(osc_update_search_url(array('iPage' => $folio_page + 2))); ?>"><?php
                            _e('Next', 'folio'); ?> &rarr;</a>
                    <?php } ?>
                </nav>
            <?php } ?>
        <?php } ?>
    </section>

    <aside class="facets" id="folio-facets" tabindex="-1"
           aria-label="<?php echo osc_esc_html(__('Refine these results', 'folio')); ?>">
        <h2><?php _e('Refine these results', 'folio'); ?></h2>

        <?php
        /*
         * Order. Four plain links, each one the current query with two parameters
         * rewritten, so a catalogue can be read by price as well as front to back.
         * Core allows i_price, dt_pub_date, dt_expiration and relevance as columns
         * and asc/desc as the type; it hands the type back as 0 or 1, which is what
         * the current-marker compares against.
         */
        ?>
        <details open>
            <summary><?php _e('Order', 'folio'); ?></summary>
            <ul>
                <?php foreach ($folio_orders as $folio_o) {
                    $folio_on = $folio_order === $folio_o[0]
                        && $folio_order_desc === ($folio_o[1] === 'desc'); ?>
                    <li><a href="<?php echo osc_esc_html(osc_update_search_url(array(
                        'sOrder' => $folio_o[0], 'iOrderType' => $folio_o[1], 'iPage' => null,
                    ))); ?>"<?php echo $folio_on ? ' aria-current="true"' : ''; ?>><?php
                        echo osc_esc_html($folio_o[2]); ?></a></li>
                <?php } ?>
            </ul>
        </details>

        <?php if (osc_count_categories() > 0) { ?>
            <details open>
                <summary><?php _e('Category', 'folio'); ?></summary>
                <ul>
                    <?php // The way back out. Without it a narrowed search can only be
                    // widened by editing the address bar. ?>
                    <li><a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory' => null, 'iPage' => null))); ?>"
                           <?php echo $folio_cat === 0 ? 'aria-current="true"' : ''; ?>><?php
                        _e('All categories', 'folio'); ?></a></li>

                    <?php
                    /*
                     * The shelves, and inside the one the visitor is standing in, its
                     * sections. Listing only the roots meant a page filed under a
                     * subcategory marked nothing as current and offered no way to a
                     * neighbouring section -- the taxonomy was legible in the index,
                     * as a class mark on every record, and unreachable from here.
                     */
                    while (osc_has_categories()) {
                        $folio_root  = (int) osc_category_id();
                        $folio_stock = (int) osc_category_total_items();
                        $folio_open  = $folio_root === $folio_branch; ?>
                        <li>
                            <a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory' => $folio_root, 'iPage' => null))); ?>"
                               <?php echo $folio_stock === 0 ? 'class="empty-shelf"' : ''; ?>
                               <?php echo $folio_cat === $folio_root ? 'aria-current="true"' : ''; ?>><span class="name"><?php
                                echo osc_esc_html(osc_category_name()); ?></span><span class="count"><?php
                                echo osc_esc_html(number_format($folio_stock)); ?></span></a>

                            <?php if ($folio_open && osc_count_subcategories() > 0) { ?>
                                <ul class="facet-sub">
                                    <?php
                                    /*
                                     * A section with nothing in it is dropped here, not
                                     * dimmed. The home page lists shelves and is a
                                     * directory of what exists; this is a filter, and an
                                     * option that returns nothing is not an option. The
                                     * current section always stays, so a selection can
                                     * never vanish from under the visitor.
                                     */
                                    while (osc_has_subcategories()) {
                                        $folio_sub = (int) osc_category_total_items();
                                        $folio_on  = $folio_cat === (int) osc_category_id();
                                        if ($folio_sub === 0 && !$folio_on) {
                                            continue;
                                        } ?>
                                        <li><a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory' => osc_category_id(), 'iPage' => null))); ?>"
                                               <?php echo $folio_sub === 0 ? 'class="empty-shelf"' : ''; ?>
                                               <?php echo $folio_on ? 'aria-current="true"' : ''; ?>><span class="name"><?php
                                            echo osc_esc_html(osc_category_name()); ?></span><span class="count"><?php
                                            echo osc_esc_html(number_format($folio_sub)); ?></span></a></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
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
                <?php if ($folio_cat > 0) { ?>
                    <input type="hidden" name="sCategory" value="<?php echo $folio_cat; ?>">
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

        <?php
        // Save this search. Core owns the form and its hidden fields; the theme
        // only decides where it sits. Guests see it too unless the site requires
        // an account, so the feature stays discoverable.
        if (osc_users_enabled()
            && (osc_is_web_user_logged_in() || !osc_get_preference('alerts_require_login'))
        ) { ?>
            <details class="folio-alert">
                <summary><?php _e('Get an email alert', 'folio'); ?></summary>
                <p class="muted small"><?php
                    _e('We email you when a new listing matches this search.', 'folio'); ?></p>
                <?php osc_alert_form(); ?>
            </details>
        <?php } ?>
    </aside>
</div>
<?php osc_get_footer(); ?>
