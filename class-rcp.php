<?php

use WPGraphQL_RCP_Types;

final class WPGraphQL_RCP
{

  /**
   * Stores the instance of the WPGraphQL_RCP class
   *
   * @var WPGraphQL_RCP The one true WPGraphQL_RCP
   * @since  0.0.1
   * @access private
   */
  private static $instance;

  /**
   * The instance of the WPGraphQL_RCP object
   *
   * @return object|WPGraphQL_RCP - The one true WPGraphQL_RCP
   * @since  0.0.1
   * @access public
   */
  public static function instance()
  {

    if (!isset(self::$instance) && !(self::$instance instanceof WPGraphQL_RCP)) {
      self::$instance = new WPGraphQL_RCP();
      self::$instance->init();
    }

    /**
     * Return the WPGraphQL_RCP Instance
     */
    return self::$instance;
  }

  /**
   * Throw error on object clone.
   * The whole idea of the singleton design pattern is that there is a single object
   * therefore, we don't want the object to be cloned.
   *
   * @since  0.0.1
   * @access public
   * @return void
   */
  public function __clone()
  {
    // Cloning instances of the class is forbidden.
    _doing_it_wrong(__FUNCTION__, esc_html__('The WPGraphQL_RCP class should not be cloned.', 'wpgraphql-restrict-content-pro'), '0.0.1');
  }

  /**
   * Disable unserializing of the class.
   *
   * @since  0.0.1
   * @access protected
   * @return void
   */
  public function __wakeup()
  {
    // De-serializing instances of the class is forbidden.
    _doing_it_wrong(__FUNCTION__, esc_html__('De-serializing instances of the WPGraphQL_RCP class is not allowed', 'wpgraphql-restrict-content-pro'), '0.0.1');
  }

  /**
   * Initialise plugin.
   *
   * @access private
   * @since  0.0.1
   * @return void
   */
  private function init()
  {
    WPGraphQL_RCP_Types::register_enum();
    $this->register_user_fields();
  }

  /**
   * Register a post type as restricted via RCP
   *
   * @param string $type_name The name of the WP object type to register
   * @param bool $allow_inactive Whether to allow inactive users to see the post
   */
  public static function register_access_check(string $post_type_name, bool $allow_inactive)
  {
    add_filter('graphql_data_is_private', function ($is_private, $model_name, $data) use ($post_type_name, $allow_inactive) {
      if ($model_name === 'PostObject') {
        if ($data->post_type === $post_type_name) {
          $user_id = get_current_user_id();
          if (!$allow_inactive && !rcp_user_has_active_membership($user_id)) return true;
          if (!rcp_user_can_access($user_id, $data->ID)) return true;
        }
      }

      return $is_private;
    }, 10, 3);
  }

  /**
   * Register RCP User fields.
   *
   * @access public
   * @since  0.0.1
   * @return void
   */
  private function register_user_fields()
  {
    // register_graphql_fields(
    //   'User',
    //   []
    // );
  }
}

add_action('init', 'WPGraphQL_RCP_init');

if (!function_exists('WPGraphQL_RCP_init')) {
  /**
   * Function that instantiates the plugins main class
   *
   * @since 0.0.1
   */
  function WPGraphQL_RCP_init()
  {
    /**
     * Return an instance of the action
     */
    return \WPGraphQL_RCP::instance();
  }
}

/**
 * Register a post type as restricted via RCP
 *
 * @param string $type_name The name of the WP object type to register
 * @param bool $allow_inactive Whether to allow inactive users to see the post
 */
function register_graphql_post_type_restriction($type_name, $allow_inactive)
{
  \WPGraphQL_RCP::register_access_check($type_name, $allow_inactive);
}
