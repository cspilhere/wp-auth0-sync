<?php

  class WPAuth0SyncAdmin {

    private $options;

    public function __construct() {
      add_action('admin_menu', array($this, 'admin_page'));
      add_action('admin_init', array($this, 'init'));
    }

    public function admin_page() {
      add_options_page('WP Auth0 Sync Settings', 'WP Auth0 Sync', 'manage_options', 'wp-auth0-sync', array($this, 'create_admin_page'));
    }

    public function create_admin_page() {
      $options = get_option('wp_auth0_sync');
      $wp_auth0_sync_client = $options['wp_auth0_sync_client'];
      $wp_auth0_sync_token = $options['wp_auth0_sync_token'];
      $wp_auth0_sync_json = $options['wp_auth0_sync_json'];
    ?>
      <div class="wrap">
        <h2>WP Auth0 Sync - Settings</h2>
        <form method="post" action="options.php">
          <?php
            settings_fields('wp_auth0_sync_options');
            do_settings_sections('my-setting-admin');
          ?>

            <input
              id="wp_auth0_sync_client"
              type="text"
              name="wp_auth0_sync[wp_auth0_sync_client]"
              value="<?php echo $wp_auth0_sync_client; ?>"
              placeholder="Client"
              style="width: 100%;"
            >

            <hr>

            <input
              id="wp_auth0_sync_token"
              type="text"
              name="wp_auth0_sync[wp_auth0_sync_token]"
              value="<?php echo $wp_auth0_sync_token; ?>"
              placeholder="Token"
              style="width: 100%;"
            >

            <hr>

            <textarea
              id="wp_auth0_sync_json"
              name="wp_auth0_sync[wp_auth0_sync_json]"
              value=""
              placeholder="Json Filter"
              style="width: 100%; height: 200px;"
            ><?php echo $wp_auth0_sync_json; ?></textarea>

          <?php submit_button(); ?>
        </form>
      </div>
    <?php
    }

    public function init() {
      register_setting(
        'wp_auth0_sync_options', // Option group
        'wp_auth0_sync', // Option name
        array($this, 'sanitize') // Sanitize
      );
    }

    public function sanitize($input) {
      $temp_input = array();

      if(isset($input['wp_auth0_sync_client']))
      $temp_input['wp_auth0_sync_client'] = sanitize_text_field($input['wp_auth0_sync_client']);

      if(isset($input['wp_auth0_sync_token']))
      $temp_input['wp_auth0_sync_token'] = sanitize_text_field($input['wp_auth0_sync_token']);

      if(isset($input['wp_auth0_sync_json']))
      $temp_input['wp_auth0_sync_json'] = sanitize_text_field($input['wp_auth0_sync_json']);

      return $temp_input;
    }

  }

  if(is_admin())
  $my_settings_page = new WPAuth0SyncAdmin();

?>
