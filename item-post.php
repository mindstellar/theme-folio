<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Navjot Tomer (Mindstellar) and contributors
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * Publish and edit share this file; $folio_edit decides which. The fields come
 * from core's ItemForm so the contract stays core's, not the theme's.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

// Publishing and editing are the same form. Core decides which one this is --
// the action, the hidden fields, which record the location defaults come from --
// so the only thing left here is the wording.
$folio_edit = osc_is_edit_page();

osc_get_header();
?>
<div class="sheet-wide stack">
    <div class="ruled"><h1><?php echo $folio_edit ? osc_esc_html(__('Edit your listing', 'folio')) : osc_esc_html(__('Publish a listing', 'folio')); ?></h1></div>

    <form name="item" action="<?php echo osc_esc_html(osc_base_url(true)); ?>" method="post"
          enctype="multipart/form-data" id="item-post">
        <?php ItemForm::route_hidden(); ?>

        <div class="field">
            <label for="catId"><?php _e('Category', 'folio'); ?></label>
            <?php ItemForm::category_select(); ?>
        </div>

        <div class="field">
            <label for="<?php echo osc_esc_html(ItemForm::locale_field_id('title')); ?>"><?php
                _e('Title', 'folio'); ?></label>
            <?php ItemForm::title_input('title', null, osc_esc_html(osc_item_title())); ?>
        </div>

        <div class="field">
            <label for="<?php echo osc_esc_html(ItemForm::locale_field_id('description')); ?>"><?php
                _e('Description', 'folio'); ?></label>
            <?php ItemForm::description_textarea('description', null, osc_esc_html(osc_item_description())); ?>
        </div>

        <?php if (osc_price_enabled_at_items()) { ?>
            <div class="field">
                <label for="price"><?php _e('Price', 'folio'); ?></label>
                <?php ItemForm::price_input_text(); ?>
                <?php ItemForm::currency_select(osc_get_currencies(), osc_item()); ?>
            </div>
        <?php } ?>

        <div class="field">
            <label for="countryId"><?php _e('Country', 'folio'); ?></label>
            <?php ItemForm::country_select(osc_get_countries(), ItemForm::location_record()); ?>
            <noscript>
                <span class="hint"><?php _e('The region and city lists follow the country once the form is sent back. Both may be left blank.', 'folio'); ?></span>
            </noscript>
        </div>
        <div class="field">
            <label for="regionId"><?php _e('Region', 'folio'); ?></label>
            <?php ItemForm::region_select(osc_get_regions(ItemForm::selected_country()), ItemForm::location_record()); ?>
        </div>
        <div class="field">
            <label for="cityId"><?php _e('City', 'folio'); ?></label>
            <?php ItemForm::city_select(osc_get_cities(ItemForm::selected_region()), ItemForm::location_record()); ?>
        </div>

        <?php ItemForm::plugin_item_fields(); ?>

        <?php if (osc_images_enabled_at_items()) { ?>
            <div class="field">
                <label><?php _e('Photographs', 'folio'); ?></label>
                <?php ItemForm::ajax_photos(); ?>
            </div>
        <?php } ?>

        <?php if (!osc_is_web_user_logged_in()) { ?>
            <div class="field">
                <label for="contactName"><?php _e('Your name', 'folio'); ?></label>
                <?php ItemForm::contact_name_text(); ?>
            </div>
            <div class="field">
                <label for="contactEmail"><?php _e('Your email address', 'folio'); ?></label>
                <?php ItemForm::contact_email_text(); ?>
            </div>
        <?php } ?>

        <div class="actions">
            <button class="btn" type="submit"><?php echo $folio_edit
                ? osc_esc_html(__('Save changes', 'folio'))
                : osc_esc_html(__('Publish', 'folio')); ?></button>
        </div>
    </form>

    <?php
    /*
     * Core's own cascade for dropdown location fields. Called after the form so
     * the selects exist when it runs -- it wires them on execution rather than on
     * DOMContentLoaded. location_javascript_new() is the wrong twin here: it wires
     * an autocomplete UI (#countryName, free-text #region/#city) and, against
     * selects, only clears the dependent fields without ever repopulating them.
     */
    ItemForm::location_javascript();
    ?>
</div>
<?php osc_get_footer(); ?>
