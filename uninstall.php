<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('sortlist_radar_settings');
