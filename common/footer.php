<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Navjot Tomer (Mindstellar) and contributors
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * Closes the document. Declared as the second half of the theme's chrome in
 * functions.php; core renders its own pages between this and common/header.php.
 */

if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}
?>
</main>

<footer class="colophon">
    <div class="spine">
        <div class="colophon-grid">
            <div>
                <p class="colophon-mark"><?php echo osc_esc_html(osc_page_title()); ?></p>
                <?php if (osc_page_description() !== '') { ?>
                    <p><?php echo osc_esc_html(osc_page_description()); ?></p>
                <?php } ?>
            </div>

            <div>
                <h2><?php _e('Listings', 'folio'); ?></h2>
                <nav aria-label="<?php echo osc_esc_html(__('Listings', 'folio')); ?>">
                    <a href="<?php echo osc_esc_html(folio_browse_all_url()); ?>"><?php _e('Browse everything', 'folio'); ?></a>
                    <?php if (osc_item_post_url_in_category() !== '') { ?>
                        <a href="<?php echo osc_esc_html(osc_item_post_url_in_category()); ?>"><?php _e('Publish a listing', 'folio'); ?></a>
                    <?php } ?>
                    <a href="<?php echo osc_esc_html(osc_search_url(array('sFeed' => 'rss'))); ?>"><?php _e('Latest listings feed', 'folio'); ?></a>
                </nav>
            </div>

            <?php if (osc_users_enabled()) { ?>
                <div>
                    <h2><?php _e('Your account', 'folio'); ?></h2>
                    <nav aria-label="<?php echo osc_esc_html(__('Your account', 'folio')); ?>">
                        <?php if (osc_is_web_user_logged_in()) { ?>
                            <a href="<?php echo osc_esc_html(osc_user_dashboard_url()); ?>"><?php _e('Overview', 'folio'); ?></a>
                            <a href="<?php echo osc_esc_html(osc_user_list_items_url()); ?>"><?php _e('Your listings', 'folio'); ?></a>
                            <a href="<?php echo osc_esc_html(osc_user_logout_url()); ?>"><?php _e('Log out', 'folio'); ?></a>
                        <?php } else { ?>
                            <a href="<?php echo osc_esc_html(osc_user_login_url()); ?>"><?php _e('Log in', 'folio'); ?></a>
                            <a href="<?php echo osc_esc_html(osc_register_account_url()); ?>"><?php _e('Register', 'folio'); ?></a>
                        <?php } ?>
                    </nav>
                </div>
            <?php } ?>

            <div>
                <h2><?php _e('This site', 'folio'); ?></h2>
                <nav aria-label="<?php echo osc_esc_html(__('Footer', 'folio')); ?>">
                    <?php
                    // Static pages the owner published, in their own order.
                    if (osc_count_static_pages() > 0) {
                        while (osc_has_static_pages()) { ?>
                            <a href="<?php echo osc_esc_html(osc_static_page_url()); ?>"><?php echo osc_esc_html(osc_static_page_title()); ?></a>
                        <?php }
                    }
                    ?>
                    <a href="<?php echo osc_esc_html(osc_contact_url()); ?>"><?php _e('Contact', 'folio'); ?></a>
                </nav>
            </div>
        </div>

        <?php folio_widget_zone('footer', 'colophon-widgets'); ?>

        <?php $folio_note = (string) folio_setting('footer_note', ''); ?>
        <?php if ($folio_note !== '') { ?>
            <p class="colophon-note"><?php echo osc_esc_html($folio_note); ?></p>
        <?php } ?>

        <div class="colophon-foot">
            <span><?php printf(osc_esc_html(__('© %1$s %2$s', 'folio')), osc_esc_html(date('Y')), osc_esc_html(osc_page_title())); ?></span>

            <?php if (osc_count_web_enabled_locales() > 1) { ?>
                <nav class="colophon-langs" aria-label="<?php echo osc_esc_html(__('Language', 'folio')); ?>">
                    <?php
                    $folio_locale = osc_current_user_locale();
                    osc_goto_first_locale();
                    while (osc_has_web_enabled_locales()) {
                        $folio_code = osc_locale_code(); ?>
                        <a href="<?php echo osc_esc_html(osc_change_language_url($folio_code)); ?>"
                           hreflang="<?php echo osc_esc_html(str_replace('_', '-', $folio_code)); ?>"
                           <?php echo $folio_code === $folio_locale ? 'aria-current="true"' : ''; ?>><?php
                            echo osc_esc_html(osc_locale_name()); ?></a>
                    <?php } ?>
                </nav>
            <?php } ?>
        </div>
    </div>
</footer>

<?php
/*
 * The theme's entire script budget, and all of it is enhancement: every control
 * it touches either works without it or is hidden until it runs.
 *
 * Any link carrying data-folio-dialog opens the matching <dialog> in place
 * instead of navigating; without this the link still goes to the page it names,
 * which is why it is a link and not a button. A dialog holding an
 * [data-folio-plate] image is a reusable frame: the link's own target and alt
 * text are moved into it, so one panel serves every photograph on the page.
 *
 * Core prints a dismiss control on its flash messages as an <a> with no href
 * and no role, and leaves operating it to the theme. It is given the role,
 * tab stop and name here -- the stylesheet keeps it out of the page until that
 * has happened, so with scripting off there is no button that does nothing.
 */
?>
<script>
document.querySelectorAll('.flashmessage .ico-close').forEach(function (b) {
    b.setAttribute('role', 'button');
    b.setAttribute('tabindex', '0');
    b.setAttribute('aria-label', b.dataset.ocCloseLabel || 'Close');
});

document.addEventListener('click', function (e) {
    var el = e.target instanceof Element ? e.target : null;
    if (!el) { return; }

    var x = el.closest('.flashmessage .ico-close[role="button"]');
    if (x) {
        e.preventDefault();
        x.closest('.flashmessage').remove();
        return;
    }

    var a = el.closest('[data-folio-dialog]');
    if (!a) { return; }
    var d = document.getElementById(a.dataset.folioDialog);
    if (!d || typeof d.showModal !== 'function') { return; }
    var plate = d.querySelector('[data-folio-plate]');
    if (plate) {
        var shot = a.querySelector('img');
        plate.src = a.href;
        plate.alt = shot ? shot.alt : '';
    }
    e.preventDefault();
    d.showModal();
});

/* A role=button element is not a button: Enter and Space have to be wired up. */
document.addEventListener('keydown', function (e) {
    if (e.key !== 'Enter' && e.key !== ' ') { return; }
    var x = e.target instanceof Element
        ? e.target.closest('.flashmessage .ico-close[role="button"]') : null;
    if (!x) { return; }
    e.preventDefault();
    x.click();
});
</script>

<?php // Deferred scripts and anything a plugin appends to the document. ?>
<?php osc_run_hook('footer'); ?>
</body>
</html>
