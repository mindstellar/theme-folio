<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * The catalogue entry. Plates, description, a <dl> of specifications, and the
 * seller record beside it. The contact form is a native <dialog>: no library,
 * no focus-trapping of our own, and the browser closes it on Escape.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

osc_get_header();

// There is no core "may I edit this" helper; ownership is the seller id against
// the session, the same test storefront makes.
$folio_seller   = (int) osc_item_user_id();
$folio_is_owner = $folio_seller > 0 && $folio_seller === (int) osc_logged_user_id();
$folio_shots    = osc_images_enabled_at_items() ? osc_count_item_resources() : 0;
$folio_place    = array_filter(array(osc_item_city(), osc_item_region(), osc_item_country()), 'strlen');
$folio_expired  = osc_item_is_expired();

/*
 * Three blocks, not two. The lead (what it is) and the body (what it says about
 * itself) sit in one column with the aside beside them on a wide screen; below
 * 60rem the grid collapses and the source order becomes the reading order --
 * title, photographs, price and contact, then the description. The aside is
 * placed by grid, never by `order`, so the tab order and the accessibility tree
 * agree with the eye at every width.
 */
?>
<article class="record-sheet" itemscope itemtype="https://schema.org/Product">
    <div class="entry-lead">
        <nav class="crumbs" aria-label="<?php echo osc_esc_html(__('Breadcrumb', 'folio')); ?>">
            <a href="<?php echo osc_esc_html(osc_base_url()); ?>"><?php _e('Home', 'folio'); ?></a>
            <span aria-hidden="true">&rsaquo;</span>
            <a href="<?php echo osc_esc_html(osc_search_category_url()); ?>"><?php
                echo osc_esc_html(osc_item_category()); ?></a>
        </nav>

        <header class="entry-head">
            <h1 itemprop="name"><?php echo osc_esc_html(osc_item_title()); ?></h1>
            <p class="entry-meta">
                <?php if ($folio_place !== array()) { ?>
                    <span><?php echo osc_esc_html(implode(', ', $folio_place)); ?></span>
                    <span class="sep" aria-hidden="true">&middot;</span>
                <?php } ?>
                <?php _e('Published', 'folio'); ?>
                <time datetime="<?php echo osc_esc_html(folio_iso_date(osc_item_pub_date())); ?>"><?php
                    echo osc_esc_html(osc_format_date(osc_item_pub_date())); ?></time>
            </p>
        </header>

        <?php if ($folio_shots > 0) { ?>
            <?php // The first photograph is the page's LCP candidate, so it is not
            // deferred. The rest are, and each is numbered in its alt text -- three
            // links reading "Apple iPhone 13 Pro, link" told a screen-reader user
            // nothing about which one they were on. ?>
            <ul class="plates<?php echo $folio_shots === 1 ? ' plates-single' : ''; ?>">
                <?php $folio_shot_n = 0;
                while (osc_has_item_resources()) {
                    $folio_shot_n++; ?>
                    <li>
                        <a href="<?php echo osc_esc_html(osc_resource_url()); ?>">
                            <img src="<?php echo osc_esc_html(osc_resource_preview_url()); ?>"
                                 alt="<?php printf(
                                     osc_esc_html(__('%1$s — photograph %2$s of %3$s', 'folio')),
                                     osc_esc_html(osc_item_title()),
                                     osc_esc_html(number_format($folio_shot_n)),
                                     osc_esc_html(number_format($folio_shots))
                                 ); ?>"
                                 decoding="async" itemprop="image"
                                 loading="<?php echo $folio_shot_n === 1 ? 'eager' : 'lazy'; ?>"<?php
                                 echo $folio_shot_n === 1 ? ' fetchpriority="high"' : ''; ?>>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php if ($folio_shots > 1) { ?>
                <p class="plate-count"><?php
                    printf(osc_esc_html(_n('%s photograph', '%s photographs', $folio_shots, 'folio')),
                        osc_esc_html(number_format($folio_shots))); ?></p>
            <?php } ?>
        <?php } ?>
    </div>

    <?php // Named, so it is announced as what it is rather than as a bare
    // "complementary" -- this block is the whole decision: price, seller, action. ?>
    <aside class="aside" aria-label="<?php echo osc_esc_html(__('Price and seller', 'folio')); ?>">
        <p class="figure-price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <span itemprop="price"><?php echo folio_price_html(); ?></span>
        </p>

        <?php if (osc_item_is_premium() || $folio_expired) { ?>
            <p>
                <?php if ($folio_expired) { ?>
                    <span class="flag flag-stop"><span aria-hidden="true">&#8856;</span> <?php _e('Expired', 'folio'); ?></span>
                <?php } elseif (osc_item_is_premium()) { ?>
                    <span class="flag flag-brand"><span aria-hidden="true">&#9733;</span> <?php _e('Featured', 'folio'); ?></span>
                <?php } ?>
            </p>
        <?php } ?>

        <dl class="attrib">
            <dt><?php _e('Seller', 'folio'); ?></dt>
            <dd><?php if ($folio_seller > 0) { ?>
                    <a href="<?php echo osc_esc_html(osc_user_public_profile_url($folio_seller)); ?>"><?php
                        echo osc_esc_html(osc_item_contact_name()); ?></a>
                <?php } else {
                    echo osc_esc_html(osc_item_contact_name());
                } ?></dd>

            <?php if ($folio_place !== array()) { ?>
                <dt><?php _e('Location', 'folio'); ?></dt>
                <dd><?php echo osc_esc_html(implode(', ', $folio_place)); ?></dd>
            <?php } ?>

            <dt><?php _e('Filed under', 'folio'); ?></dt>
            <dd><a href="<?php echo osc_esc_html(osc_search_category_url()); ?>"><?php
                echo osc_esc_html(osc_item_category()); ?></a></dd>

            <dt><?php _e('Reference', 'folio'); ?></dt>
            <dd><?php echo (int) osc_item_id(); ?></dd>
        </dl>

        <?php if ($folio_expired) { ?>
            <p class="notice notice-warn"><?php
                _e('This listing has expired and the seller can no longer be contacted through it.', 'folio'); ?></p>
        <?php } else { ?>
            <div class="aside-actions">
                <?php // A link first, so it works with no script and no <dialog>
                // support; footer.php upgrades it to open the dialog in place. ?>
                <a class="btn btn-block" data-folio-dialog="folio-contact"
                   href="<?php echo osc_esc_html(osc_base_url(true) . '?page=item&amp;action=contact&amp;id=' . (int) osc_item_id()); ?>">
                    <?php _e('Contact the seller', 'folio'); ?>
                </a>
                <a class="btn btn-quiet btn-block" href="<?php echo osc_esc_html(osc_item_send_friend_url()); ?>"><?php
                    _e('Send to a friend', 'folio'); ?></a>
                <?php if ($folio_is_owner) { ?>
                    <a class="btn btn-quiet btn-block" href="<?php echo osc_esc_html(osc_item_edit_url()); ?>"><?php
                        _e('Edit this listing', 'folio'); ?></a>
                <?php } ?>
            </div>

            <dialog id="folio-contact" aria-labelledby="folio-contact-title">
                <h2 id="folio-contact-title"><?php _e('Contact the seller', 'folio'); ?></h2>
                <p class="dialog-subject">
                    <span class="name"><?php echo osc_esc_html(osc_item_title()); ?></span>
                    <span class="price"><?php echo folio_price_html(); ?></span>
                </p>
                <?php osc_current_web_theme_path('common/contact-fields.php'); ?>
            </dialog>
        <?php } ?>

        <p class="safety"><?php
            _e('Meet in a public place, inspect the item before paying, and never send money in advance.', 'folio'); ?></p>
    </aside>

    <div class="entry-body">
        <div class="prose" itemprop="description">
            <?php echo osc_item_description(); ?>
        </div>

        <?php
        // Custom fields are the specification list. <dl> is what a spec sheet
        // literally is, so it needs no class of its own to mean the right thing.
        if (osc_count_item_meta() > 0) { ?>
            <div class="ruled"><h2><?php _e('Specifications', 'folio'); ?></h2></div>
            <dl class="spec">
                <?php while (osc_has_item_meta()) { ?>
                    <dt><?php echo osc_esc_html(osc_item_meta_name()); ?></dt>
                    <dd><?php echo osc_item_meta_value(); ?></dd>
                <?php } ?>
            </dl>
        <?php } ?>

        <?php osc_run_hook('item_detail', osc_item()); ?>

        <?php // Thread and form both come from core; the classes below are ours to style.
        osc_show_item_comments(); ?>
    </div>
</article>
<?php osc_get_footer(); ?>
