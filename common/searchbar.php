<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Navjot Tomer (Mindstellar) and contributors
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * The site's one search control, in the native <search> landmark. GET to the
 * base URL with the parameter names core's search route already reads, so it
 * needs no JavaScript and survives with the stylesheet switched off.
 *
 * $folio_search_band renders the variant that sits on the navy masthead; unset,
 * it renders on the reading surface.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

// Set by the caller through the View container: core require()s this file from a
// function, so a local in the calling template is not in scope here.
$folio_band = (bool) __get('folio_search_band');
View::newInstance()->_erase('folio_search_band');
?>
<search>
    <form action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="get" role="search"
          class="searchbar<?php echo $folio_band ? ' searchbar-band' : ''; ?>">
        <input type="hidden" name="page" value="search">

        <?php
        /*
         * Search inside the shelf the visitor is standing on. Without this the
         * field submitted only the pattern and the town, so typing into the box
         * in front of you on a category page threw that category away and
         * answered site-wide -- the most natural action on the page, silently
         * undoing the narrowing that got you there.
         */
        $folio_bar_cat = folio_search_category_id();
        if ($folio_bar_cat > 0) { ?>
            <input type="hidden" name="sCategory" value="<?php echo $folio_bar_cat; ?>">
        <?php } ?>
        <div class="field field-wide">
            <label for="folio-q"><?php _e('What are you looking for?', 'folio'); ?></label>
            <input id="folio-q" type="search" name="sPattern" autocomplete="off"
                   value="<?php echo osc_esc_html(osc_search_pattern()); ?>"
                   placeholder="<?php echo osc_esc_html(__('Bicycle, sofa, guitar…', 'folio')); ?>">
        </div>
        <div class="field field-narrow">
            <label for="folio-city"><?php _e('Town or city', 'folio'); ?></label>
            <?php // data-ac is core's contract: it binds the field to the city endpoint
            // and writes the chosen row's id into cityId. Without the script the field
            // still submits as free text, which core's search reads just the same. ?>
            <input id="folio-city" type="text" name="sCity" autocomplete="off"
                   placeholder="<?php echo osc_esc_html(__('Anywhere', 'folio')); ?>"
                   value="<?php echo osc_esc_html(osc_search_city()); ?>"
                   data-ac="location_cities"
                   data-ac-url="<?php echo osc_esc_html(osc_base_url(true)); ?>"
                   data-ac-target="#folio-city-id">
            <input type="hidden" name="cityId" id="folio-city-id" value="">
        </div>
        <button class="btn" type="submit"><?php _e('Search', 'folio'); ?></button>
    </form>
</search>
