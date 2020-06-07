<?php

/**
 * Plugin Name: WP GraphQL Restrict Content Pro
 * Plugin URI: https://github.com/hsimah/wp-graphql-restrict-content-pro
 * Description: WP GraphQL provider for Restrict Content Pro
 * Author: hsimah
 * Author URI: https://www.hsimah.com
 * Version: 0.1.1
 * Text Domain: wpgraphql-restrict-content-pro
 * License: GPL-3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package  WPGraphQL_RCP
 * @author   hsimah
 * @version  0.1.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

add_action('init', function () {
	if (class_exists('Restrict_Content_Pro') && class_exists('WPGraphQL')) {
		require_once __DIR__ . '/class-rcp.php';
	}
}, 5);

add_action('admin_init', function () {
	$versions = [
		'wp-graphql' => '0.8.1',
		'restrict-content-pro' => '3.3.8',
	];

	if (
		!class_exists('Restrict_Content_Pro') ||
		!class_exists('WPGraphQL') ||
		(defined('WPGRAPHQL_VERSION') && version_compare(WPGRAPHQL_VERSION, $versions['wp-graphql'], 'lt')) ||
		(defined('RCP_PLUGIN_VERSION') && version_compare(RCP_PLUGIN_VERSION, $versions['restrict-content-pro'], 'lt'))
	) {

		/**
		 * For users with lower capabilities, don't show the notice
		 */
		if (!current_user_can('manage_options')) {
			return false;
		}

		/**
		 * Show admin notice to admins if this plugin is active but either Restrict Content Pro and/or WPGraphQL
		 * are not active
		 *
		 * @return bool
		 */
		add_action(
			'admin_notices',
			function () use ($versions) {
?>
			<div class="error notice">
				<p>
					<?php _e(vsprintf('Both WPGraphQL (v%s+) and Restrict Content Pro (v%s+) must be active for "wp-graphql-restrict-content-pro" to work', $versions), 'wpgraphql-restrict-content-pro'); ?>
				</p>
			</div>
<?php
			}
		);

		return false;
	}
});
