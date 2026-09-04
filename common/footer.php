<?php
/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
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
                    <a href="<?php echo osc_esc_html(osc_search_show_all_url()); ?>"><?php _e('Browse everything', 'folio'); ?></a>
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

        <div class="colophon-foot">
            <span><?php printf(osc_esc_html(__('© %1$s %2$s', 'folio')), osc_esc_html(date('Y')), osc_esc_html(osc_page_title())); ?></span>
        </div>
    </div>
</footer>

<?php
/*
 * The theme's entire script budget. Any link carrying data-folio-dialog opens
 * the matching <dialog> in place instead of navigating; without this the link
 * still goes to the page it names, which is why it is a link and not a button.
 */
?>
<script>
document.addEventListener('click', function (e) {
    var a = e.target instanceof Element ? e.target.closest('[data-folio-dialog]') : null;
    if (!a) { return; }
    var d = document.getElementById(a.dataset.folioDialog);
    if (!d || typeof d.showModal !== 'function') { return; }
    e.preventDefault();
    d.showModal();
});
</script>

<?php // Deferred scripts and anything a plugin appends to the document. ?>
<?php osc_run_hook('footer'); ?>
</body>
</html>
