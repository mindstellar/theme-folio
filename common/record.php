<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * One entry in the index. Rendered inside the loop, so it reads osc_item()
 * rather than taking arguments. The heading level differs between the home
 * page and a search results page; $folio_heading carries it.
 *
 * Three lines: the class mark it is filed under, the title, and where and when
 * it was published. The price is a figure in its own column.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

$folio_h    = $GLOBALS['folio_heading'] ?? 'h2';
$folio_shot = osc_images_enabled_at_items() && osc_has_item_resources();
?>
<li class="record">
    <?php if ($folio_shot) { ?>
        <img class="plate" src="<?php echo osc_esc_html(osc_resource_thumbnail_url()); ?>" alt=""
             width="240" height="200" loading="lazy" decoding="async">
    <?php } else { ?>
        <span class="plate plate-empty"><?php _e('No photo', 'folio'); ?></span>
    <?php } ?>

    <div class="record-body">
        <p class="classmark"><?php echo osc_esc_html(osc_item_category()); ?></p>

        <<?php echo $folio_h; ?>>
            <a href="<?php echo osc_esc_html(osc_item_url()); ?>"><?php echo osc_esc_html(osc_item_title()); ?></a>
        </<?php echo $folio_h; ?>>

        <p class="meta">
            <?php if (osc_item_city() !== '') { ?>
                <span><?php echo osc_esc_html(osc_item_city()); ?></span>
                <span class="sep" aria-hidden="true">&middot;</span>
            <?php } ?>
            <time datetime="<?php echo osc_esc_html(folio_iso_date(osc_item_pub_date())); ?>"><?php
                echo osc_esc_html(osc_format_date(osc_item_pub_date())); ?></time>
            <?php if (osc_item_is_premium()) { ?>
                <span class="flag flag-brand"><span aria-hidden="true">&#9733;</span> <?php _e('Featured', 'folio'); ?></span>
            <?php } ?>
        </p>
    </div>

    <p class="price"><?php echo folio_price_html(); ?></p>
</li>
