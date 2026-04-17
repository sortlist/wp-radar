<?php
/**
 * Plugin Name: Sortlist Radar
 * Plugin URI: https://www.sortlist.com
 * Description: Integrate the Sortlist Radar tracking script on your website. Configure your Profile ID in Settings > Sortlist Radar.
 * Version: 1.0.0
 * Author: Sortlist
 * Author URI: https://www.sortlist.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sortlist-radar
 */

if (!defined('ABSPATH')) {
    exit;
}

class Sortlist_Radar {

    private const OPTION_KEY = 'sortlist_radar_settings';

    public function __construct() {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_script']);
        add_filter('script_loader_tag', [$this, 'add_script_attributes'], 10, 2);
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'add_settings_link']);
    }

    public function get_defaults(): array {
        return [
            'profile_id'    => '',
            'form_tracking'  => '1',
        ];
    }

    public function get_settings(): array {
        return wp_parse_args(get_option(self::OPTION_KEY, []), $this->get_defaults());
    }

    public function add_settings_link(array $links): array {
        $url = admin_url('options-general.php?page=sortlist-radar');
        array_unshift($links, '<a href="' . esc_url($url) . '">' . __('Settings', 'sortlist-radar') . '</a>');
        return $links;
    }

    public function add_settings_page(): void {
        add_options_page(
            __('Sortlist Radar', 'sortlist-radar'),
            __('Sortlist Radar', 'sortlist-radar'),
            'manage_options',
            'sortlist-radar',
            [$this, 'render_settings_page']
        );
    }

    public function register_settings(): void {
        register_setting('sortlist_radar', self::OPTION_KEY, [
            'type'              => 'array',
            'sanitize_callback' => [$this, 'sanitize_settings'],
        ]);

        add_settings_section(
            'sortlist_radar_main',
            __('Configuration', 'sortlist-radar'),
            [$this, 'render_section_description'],
            'sortlist-radar'
        );

        add_settings_field(
            'profile_id',
            __('Profile ID', 'sortlist-radar'),
            [$this, 'render_profile_id_field'],
            'sortlist-radar',
            'sortlist_radar_main'
        );

        add_settings_field(
            'form_tracking',
            __('Form Tracking', 'sortlist-radar'),
            [$this, 'render_form_tracking_field'],
            'sortlist-radar',
            'sortlist_radar_main'
        );
    }

    public function sanitize_settings(array $input): array {
        return [
            'profile_id'    => sanitize_text_field($input['profile_id'] ?? ''),
            'form_tracking'  => !empty($input['form_tracking']) ? '1' : '0',
        ];
    }

    public function render_section_description(): void {
        echo '<p>' . esc_html__('Enter your Sortlist Profile ID to activate the Radar tracking script. You can find it in your Sortlist dashboard.', 'sortlist-radar') . '</p>';
    }

    public function render_profile_id_field(): void {
        $settings = $this->get_settings();
        printf(
            '<input type="text" name="%s[profile_id]" value="%s" class="regular-text" placeholder="e.g. rowaU6FsVWn" />',
            esc_attr(self::OPTION_KEY),
            esc_attr($settings['profile_id'])
        );
        echo '<p class="description">' . esc_html__('Required. The script will not load without a valid Profile ID.', 'sortlist-radar') . '</p>';
    }

    public function render_form_tracking_field(): void {
        $settings = $this->get_settings();
        printf(
            '<label><input type="checkbox" name="%s[form_tracking]" value="1" %s /> %s</label>',
            esc_attr(self::OPTION_KEY),
            checked($settings['form_tracking'], '1', false),
            esc_html__('Track form submissions', 'sortlist-radar')
        );
    }

    public function render_settings_page(): void {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <?php
            $settings = $this->get_settings();
            if (empty($settings['profile_id'])) {
                echo '<div class="notice notice-warning"><p>' .
                    esc_html__('Sortlist Radar is inactive. Please enter your Profile ID below.', 'sortlist-radar') .
                    '</p></div>';
            } else {
                echo '<div class="notice notice-success"><p>' .
                    sprintf(
                        esc_html__('Sortlist Radar is active with Profile ID: %s', 'sortlist-radar'),
                        '<code>' . esc_html($settings['profile_id']) . '</code>'
                    ) .
                    '</p></div>';
            }
            ?>
            <form method="post" action="options.php">
                <?php
                settings_fields('sortlist_radar');
                do_settings_sections('sortlist-radar');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function enqueue_script(): void {
        if (is_admin()) {
            return;
        }

        $settings = $this->get_settings();

        if (empty($settings['profile_id'])) {
            return;
        }

        $config = [
            'cdn'         => 'collector.sortlist.com',
            'apiEndpoint' => 'radar.sortlist.com',
            'profileId'   => $settings['profile_id'],
            'namespace'   => 'SortlistRadar',
            'features'    => [
                'sessionTracking' => true,
                'formTracking'    => $settings['form_tracking'] === '1',
                'clickTracking'   => true,
            ],
        ];

        wp_enqueue_script(
            'sortlist-radar',
            'https://collector.sortlist.com/releases/latest/radar.min.js',
            [],
            null,
            false
        );

        wp_script_add_data('sortlist-radar', 'sortlist_config', wp_json_encode($config, JSON_UNESCAPED_SLASHES));
    }

    public function add_script_attributes(string $tag, string $handle): string {
        if ($handle !== 'sortlist-radar') {
            return $tag;
        }

        $config = wp_scripts()->get_data($handle, 'sortlist_config');

        return str_replace(
            '<script ',
            '<script async id="__radar__" data-settings="' . esc_attr($config) . '" ',
            $tag
        );
    }
}

new Sortlist_Radar();
