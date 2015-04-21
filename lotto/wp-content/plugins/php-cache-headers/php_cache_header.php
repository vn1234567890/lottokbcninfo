<?php
/*
Plugin Name: PHP Cache Headers
Description: Add PHP Cache Headers Automaticaly
Version: 1.2
Author: Michael Park 
License: GPL2
*/

  add_action('wp', 'phpch_headers' );
  add_action('admin_menu', 'phpch_setting');

  function phpch_headers() { 
		$expires = get_option( 'phpch_setting', 3600 );
		
		if ( $expires >= 0 ) {
			header("Pragma: public");
			//header("Cache-Control: max-age=".$expires.", must-revalidate");
            header("Cache-Control: max-age=".$expires.", public, must-revalidate, proxy-revalidate");
		} else {
			header("Pragma: no-cache");
			header("Cache-Control: max-age=".$expires.", no-cache");
		}
		
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
  }

  function phpch_setting() {
    add_options_page(__('PHP Cache Header','menu-test'), __('PHP Cache Headers','menu-test'), 'manage_options', 'phpch_setting', 'phpch_setting_page');
  }

  function phpch_setting_page() {
    global $opt_value;

	if (!current_user_can('manage_options')) 
		wp_die( __('You do not have sufficient permissions to access this page.') );
		
    $opt_value = get_option( 'phpch_setting', 3600 );

	if ( is_numeric($_POST['phpch_value']) ) {
        $opt_value = $_POST['phpch_value'];
        update_option( 'phpch_setting', $opt_value );
?>
<div class="updated"><p><strong><?php _e('Settings saved.', 'phpch-menu' ); ?></strong></p></div>
<?php
    } elseif ( isset($_POST['phpch_submit_hidden']) && $_POST['phpch_submit_hidden'] = 'Y' )  {
?>
<div class="updated"><p><strong><?php _e('Numeric values only!', 'phpch-menu' ); ?></strong></p></div>
<?php
	}

    echo '<div class="wrap">';
    echo "<h2>" . __( 'PHP Cache Headers', 'phpch-menu' ) . "</h2>";
    ?>

<form name="form1" method="post" action="">
<input type="hidden" name="phpch_submit_hidden" value="Y" />

<p><?php _e("<p><b>Option:</b></p>", 'phpch-menu' ); ?> 

<label for="input1">Cache time in seconds</label>  
<input type="input" name="phpch_value" id="input1" value="<?php echo $opt_value; ?>" size="20" /> (enter 0 for no cache)

</p><hr />

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
</div>

<?php
 
}   // end function phpch_setting_page()

?>