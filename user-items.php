<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * The seller's own listings, in the same ruled index the public pages use, with
 * the status flag each record needs and the owner's two actions.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

osc_current_web_theme_path('common/header.php');
?>
<div class="record-sheet">
    <section>
        <div class="ruled"><h1><?php _e('Your listings', 'folio'); ?></h1></div>

        <?php if (osc_count_items() === 0) { ?>
            <p class="empty">
                <strong><?php _e('You have not published anything yet', 'folio'); ?></strong>
                <a href="<?php echo osc_esc_html(osc_item_post_url_in_category()); ?>"><?php _e('Publish your first listing', 'folio'); ?></a>
            </p>
        <?php } else { ?>
            <ol class="index">
                <?php while (osc_has_items()) { ?>
                    <li class="record">
                        <?php if (osc_images_enabled_at_items() && osc_has_item_resources()) { ?>
                            <img class="plate" src="<?php echo osc_esc_html(osc_resource_thumbnail_url()); ?>" alt=""
                                 width="240" height="200" loading="lazy" decoding="async">
                        <?php } else { ?>
                            <span class="plate plate-empty"><?php _e('No photo', 'folio'); ?></span>
                        <?php } ?>

                        <div class="record-body">
                            <p class="classmark"><?php echo osc_esc_html(osc_item_category()); ?></p>

                            <h2><a href="<?php echo osc_esc_html(osc_item_url()); ?>"><?php echo osc_esc_html(osc_item_title()); ?></a></h2>

                            <p class="meta">
                                <?php if (osc_item_is_expired()) { ?>
                                    <span class="flag flag-stop"><span aria-hidden="true">&#8856;</span> <?php _e('Expired', 'folio'); ?></span>
                                <?php } elseif (!osc_item_is_active()) { ?>
                                    <span class="flag flag-warn"><span aria-hidden="true">&#9675;</span> <?php _e('Awaiting validation', 'folio'); ?></span>
                                <?php } else { ?>
                                    <span class="flag flag-ok"><span aria-hidden="true">&#9679;</span> <?php _e('Published', 'folio'); ?></span>
                                <?php } ?>
                                <span class="sep" aria-hidden="true">&middot;</span>
                                <time datetime="<?php echo osc_esc_html(folio_iso_date(osc_item_pub_date())); ?>"><?php
                                    echo osc_esc_html(osc_format_date(osc_item_pub_date())); ?></time>
                                <span class="sep" aria-hidden="true">&middot;</span>
                                <a href="<?php echo osc_esc_html(osc_item_edit_url()); ?>"><?php _e('Edit', 'folio'); ?></a>
                            </p>
                        </div>

                        <p class="price"><?php echo folio_price_html(); ?></p>
                    </li>
                <?php } ?>
            </ol>
        <?php } ?>
    </section>

    <?php osc_current_web_theme_path('common/account-nav.php'); ?>
</div>
<?php osc_current_web_theme_path('common/footer.php'); ?>
