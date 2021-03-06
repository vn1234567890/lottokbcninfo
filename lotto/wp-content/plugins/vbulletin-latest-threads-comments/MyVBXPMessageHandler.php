<?php
 
class MyVBXPMessageHandler {
	
	private $error = "";
	private $notice = "";
	
	function __construct() {
	}
	
	function has_messages() {
		return $this->error != "" || $this->notice != "";
	}
	
	function sql_error($sql, $file, $line) {
		$this->error .= ('(' . basename($file) . ':' . $line . ') An SQL error occured with the following query: "' . $this->prepare_for_debug_output($sql) . '"<br/>');
	}
	
	function http_error($url, $post_data, $result, $file, $line) {
		$this->error .= '(' . basename($file) . ':' . $line . ') An error occured with the following http request:<br/><br/>URL:<br/>' . $url . '<br/><br/>POST data:<br/>' . $this->prepare_for_debug_output($post_data) . '<br/><br/>WP ERROR:<br/>' . $this->prepare_for_debug_output($result) . '<br/>';
	}
	
	function iframe_error($msg, $html) {
		$this->error .= $msg;
		$this->error .= '<br/><iframe src="' . get_settings('siteurl') . '/wp-content/plugins/mybb-cross-postalicious/view-response.php" style="width:100%; height=200px;"></iframe><br/>';
		$html = preg_replace('/http-equiv/', 'norefreshplskthxbye', $html);
		update_option('mybbxp_mybb_content_buffer', base64_encode($html)); // not sure if base64 encoding is really necessary, but better safe than sory, eh?
	}
	
	function error($msg, $file, $line) {
		$this->error .= '(' . basename($file) . ':' . $line . ') ' . $msg . '<br/>';
	}
		
	function notice($htmlstring) {
		$this->notice .= $htmlstring;
	}
	
	function flush_messages() {
		if ($this->error != "") {
			update_option('mybbxp_admin_message', '<div id="mybbxp_message" class="error" style="background-color: #FFEBE8 !important;"><strong>MyBBXP ERROR:</strong><br/>' . $this->error . '</div>');
		} elseif ($this->notice != "") {
			update_option('mybbxp_admin_message', '<div id="mybbxp_message" class="updated">MyBBXP NOTICE:<br/>' . $this->notice . '</div>');
		}
	}
	
	function display_buffered_admin_message() {
		if (get_option('mybbxp_admin_message')) {
		    add_action('admin_notices' , array('MyBBXPMessageHandler', 'admin_notice_callback'));
		}
	}
	
	private function prepare_for_debug_output($s) {
		return nl2br(htmlentities(print_r($s, true)));
	}
	
	static function admin_notice_callback() {
		echo get_option('mybbxp_admin_message');
		delete_option('mybbxp_admin_message');
	}
}

?>
