<?php
if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Mindstellar Community
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

/**
 * Editing a listing is the publishing form with the values filled in, and that
 * file already branches on osc_is_edit_page() for the two places they differ.
 * Core asks for this view by name, so the file has to exist -- it just has no
 * business being a second copy of the other one.
 */
require __DIR__ . '/item-post.php';
