<?php pb1l9d();
function pbseo_plugin_settings_screen() {
	; ?>
	<div class="wrap">
		<div id="pbseo_icon_options_general" class="icon32"><br/></div>
		<h2><?php echo pb_htmlspecialchars( PushButtonSEO_DEFINE ) . ' ' . __( "General Settings", PluginTextDomain_DEFINE ) . " (v" . pb_htmlspecialchars( pb1Oc ) . ")"; ?></h2>

		<?php if ( isset ( $_REQUEST["settings-updated"] ) && ( "true" == $_REQUEST["settings-updated"] ) ) {
			; ?>
			<div id="message" class="updated"><p><strong><?php echo __( "Settings updated", PluginTextDomain_DEFINE ); ?></strong>.</p></div>
		<?php } ?>
		<div id="pbseo_admin_wrapper">

			<?php ; ?>
			<table id="pbseo_settings_layout" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr valign="top">
					<td id="pbseo_settings_form">

						<?php $pb1O9d = get_option_wrapper( "pbseo_panel_id" );
						if ( empty( $pb1O9d ) ) {
							$pb1O9d = pb1lr;
						} ?>

						<ul class="pbseo_tabs">
							<li><a href="#" <?php echo ( pb1lr == $pb1O9d ) ? " class=\"pbseo_defaulttab\"" : ""; ?>rel="pbseo_general"><?php echo __( "General", PluginTextDomain_DEFINE ); ?></a></li>
							<?php if ( pb1O3u( pb1O1 ) ) {
								; ?>
								<li><a href="#" <?php echo ( pb1Ot == $pb1O9d ) ? " class=\"pbseo_defaulttab\"" : ""; ?>rel="pbseo_optimizer"><?php echo pb1l27; ?></a></li>
								<li><a href="#" <?php echo ( pb1ls == $pb1O9d ) ? " class=\"pbseo_defaulttab\"" : ""; ?>rel="pbseo_links"><?php echo pb1O25; ?></a></li>
								<li><a href="#" <?php echo ( pb1Os == $pb1O9d ) ? " class=\"pbseo_defaulttab\"" : ""; ?>rel="pbseo_content"><?php echo pb1l26; ?></a></li>
							<?php } ?>
							<?php if ( pb1l0 ) {
								; ?>
								<li><a href="#" rel="pbseo_debug">Debug</a></li> <?php ; ?>
							<?php } ?>
						</ul>

						<?php pb1l9e();
						pb1O2f( pbseo_opt_DEFINE . "auth_code" );
						if ( pb1O3u( pb1O1 ) ) {
							pb1O9e();
						}
						if ( pb1O3u( pb1O1 ) ) {
							pb1l9f();
						}
						if ( pb1O3u( pb1O1 ) ) {
							pb1O9f();
						}
						if ( pb1l0 ) {
							pb1l9g();
						} ?>

					</td>
					<td id="pbseo_settings_info" width="240" style="padding: 12px 0 0 16px; ">

						<?php if ( FALSE_BOOL_DEFINE !== pb1O2b ) {
							; ?>
							<div class="pbseo_m_content" id="pbseo_general_m">
								<?php echo pb1O3t( pb1O1h, "settings_general" ); ?>
							</div>
							<div class="pbseo_m_content" id="pbseo_optimizer_m">
								<?php echo pb1O3t( pb1O1h, "settings_optimizer" ); ?>
							</div>
							<div class="pbseo_m_content" id="pbseo_links_m">
								<?php echo pb1O3t( pb1O1h, "settings_links" ); ?>
							</div>
							<div class="pbseo_m_content" id="pbseo_content_m">
								<?php echo pb1O3t( pb1O1h, "settings_content" ); ?>
							</div>
						<?php } ?>

						<?php ; ?>
					</td>
				</tr>
			</table>

			<?php ; ?>
		</div>

		<?php ; ?>
	</div>

<?php }

function pb1l9e() {
	; ?>

	<div class="pbseo_tab_content" id="pbseo_general">
		<form name="pbseo_options_general" action="options.php" method="post">
			<?php settings_fields( "pbseo_options_general" ); ?>
			<input name="pbseo_panel_id" type="hidden" value="pbseo_general"/>
			<?php $pb1O9g = get_option_wrapper( pbseo_opt_DEFINE . "activation_flag" );
			$pb1l30       = get_option_wrapper( pbseo_opt_DEFINE . "auth_error" );
			if ( ! empty( $pb1l30 ) ) {
				echo "<div class=\"pbseo_notice error_notice\"><p><strong>" . htmlspecialchars( $pb1l30 ) . "</strong></p></div>";
				pb1O2f( pbseo_opt_DEFINE . "auth_error" );
			}
			if ( ! empty( $pb1O9g ) ) {
				$pb1l30 = get_option_wrapper( pbseo_opt_DEFINE . "auth_success" );
				if ( ! empty( $pb1l30 ) ) {
					echo "<div class=\"pbseo_notice update_notice\"><p><strong>" . htmlspecialchars( $pb1l30 ) . "</strong></p></div>";
					pb1O2f( pbseo_opt_DEFINE . "auth_success" );
				}
			}
			pb1O2f( pbseo_opt_DEFINE . "activation_flag" ); ?>
			<h3><?php echo __( "General Settings", PluginTextDomain_DEFINE ); ?></h3>

			<p><?php echo __( "Remember to click the Save Changes button to apply your changes", PluginTextDomain_DEFINE ) . ". "; ?></p>

			<p>
				<?php if ( ! pb1O2a ) {
					echo __( "You must enter your activation code to enable the plugin", PluginTextDomain_DEFINE ) . ". ";
					echo __( "Your activation code was sent to you by email when you downloaded the plugin", PluginTextDomain_DEFINE ) . ". ";
					echo __( "If you did not receive your activation code or have lost it, please contact customer support for assistance", PluginTextDomain_DEFINE ) . ". ";
				} ?>
			</p>
			<table class="form-table">

				<?php $pb1l5o = "activation_code";
				$pb1O5o       = pbseo_opt_DEFINE . $pb1l5o;
				$pb1l9h       = trim_wrapper( get_option_wrapper( pbseo_opt_DEFINE . $pb1l5o ) );
				$pb1O9h       = __( "Activation Code", PluginTextDomain_DEFINE );
				$pb1l9i       = '';
				if ( ! pb1O2a ) {
					$pb1l9i = __( "Please enter the Activation Code sent to you by email and click the Save Changes button", PluginTextDomain_DEFINE ) . ".<br />";
					$pb1l9i .= __( "This code is 36 characters in length", PluginTextDomain_DEFINE ) . ". ";
					$pb1l9i .= __( "Please enter the entire code including dashes", PluginTextDomain_DEFINE ) . ".";
				} else {
					$pb1l9i = __( "Delete code and click Save Changes button to deactivate the license on this domain", PluginTextDomain_DEFINE ) . ". ";
					$pb1l9i .= __( "This will allow you to use the license on a different domain", PluginTextDomain_DEFINE ) . ". ";
				} ?>
				<tr valign="top">
					<th scope="row"><?php echo esc_attr( $pb1O9h ); ?></th>
					<td>
						<input id="<?php echo esc_attr( $pb1O5o ); ?>" name="<?php echo esc_attr( $pb1O5o ); ?>" size="60" type="<?php if ( ! pb1O2a ) {
							echo "text";
						} else {
							echo "password";
						} ?>" value="<?php echo esc_attr( $pb1l9h ); ?>"/>
						<?php echo pb1O9i( $pb1l9i ); ?>
					</td>
				</tr>

				<?php ; ?>

			</table>
			<input name="pbseo_submit" type="submit" class="button-primary" value="<?php echo __( "Save Changes", PluginTextDomain_DEFINE ); ?>"/>
		</form>
	</div>
<?php }

function pb1O9e() {
	; ?>
	<div class="pbseo_tab_content" id="pbseo_optimizer">
		<form name="pbseo_options_optimizer" action="options.php" method="post">
			<?php settings_fields( "pbseo_options_optimizer" ); ?>
			<input name="pbseo_panel_id" type="hidden" value="pbseo_optimizer"/>

			<h3><?php echo __( "Optimizer Settings", PluginTextDomain_DEFINE ); ?></h3>

			<p><?php echo __( "Remember to click the Save Changes button to apply your changes", PluginTextDomain_DEFINE ) . ". "; ?></p>
			<table class="form-table">

				<?php $pb1l5o = "enable_warnings";
				$pb1O5o       = pbseo_opt_DEFINE . $pb1l5o;
				$pb1l9h       = trim_wrapper( get_option_wrapper( pbseo_opt_DEFINE . $pb1l5o, "1" ) );
				$pb1l9h       = ( "1" == $pb1l9h ? "checked=\"checked\"" : "" );
				$pb1O9h       = __( "Enable In-page Warnings", PluginTextDomain_DEFINE );
				$pb1l9i       = __( "Enable in-screen optimization warnings and feedback", PluginTextDomain_DEFINE ) . "."; ?>
				<tr valign="top">
					<th scope="row"><?php echo esc_attr( $pb1O9h ); ?></th>
					<td>
						<input id="<?php echo esc_attr( $pb1O5o ); ?>" name="<?php echo esc_attr( $pb1O5o ); ?>" type="checkbox" value="1"<?php echo $pb1l9h; ?> />
						<?php echo pb1O9i( $pb1l9i ); ?>
					</td>
				</tr>

				<?php $pb1l5o = "disable_autosave_warning";
				$pb1O5o       = pbseo_opt_DEFINE . $pb1l5o;
				$pb1l9h       = trim_wrapper( get_option_wrapper( pbseo_opt_DEFINE . $pb1l5o, "0" ) );
				$pb1l9h       = ( "1" == $pb1l9h ? "checked=\"checked\"" : "" );
				$pb1O9h       = __( "Disable Autosave Warnings", PluginTextDomain_DEFINE );
				$pb1l9i       = __( "Disable autosave warning", PluginTextDomain_DEFINE ) . ". " . __( "This only disables the warning message not the autosave process itself", PluginTextDomain_DEFINE ) . "."; ?>
				<tr valign="top">
					<th scope="row"><?php echo esc_attr( $pb1O9h ); ?></th>
					<td>
						<input id="<?php echo esc_attr( $pb1O5o ); ?>" name="<?php echo esc_attr( $pb1O5o ); ?>" type="checkbox" value="1"<?php echo $pb1l9h; ?> />
						<?php echo pb1O9i( $pb1l9i ); ?>
					</td>
				</tr>

				<?php $pb1l5o = "proximity_threshold";
				$pb1O5o       = pbseo_opt_DEFINE . $pb1l5o;
				$pb1l9h       = trim_wrapper( get_option_wrapper( pbseo_opt_DEFINE . $pb1l5o, pb1Ov ) );
				$pb1O9h       = __( "Proximity Matching Threshold", PluginTextDomain_DEFINE );
				$pb1l9i       = __( "Enable partial keyword matching based on the order and proximity of words in a keyword phrase", PluginTextDomain_DEFINE ) . ". " . __( "Set to zero to disable or a number from 1 to 4 to signify how many non-keywords are permitted between significant words in a keyword phrase", PluginTextDomain_DEFINE ) . "."; ?>
				<?php ; ?>

				<?php ; ?>

			</table>
			<input id="<?php echo esc_attr( $pb1O5o ); ?>" name="<?php echo esc_attr( $pb1O5o ); ?>" type="hidden" value="<?php echo esc_attr( $pb1l9h ); ?>"/>
			<input name="pbseo_submit" type="submit" class="button-primary" value="<?php echo __( "Save Changes", PluginTextDomain_DEFINE ); ?>"/>

		</form>
	</div>
<?php }

function pb1l9f() {
	; ?>
	<div class="pbseo_tab_content" id="pbseo_links">
		<form name="pbseo_options_links" action="options.php" method="post">
			<?php settings_fields( "pbseo_options_links" ); ?>
			<input name="pbseo_panel_id" type="hidden" value="pbseo_links"/>

			<h3><?php echo __( "Links Settings", PluginTextDomain_DEFINE ); ?></h3>

			<p><?php echo __( "Remember to click the Save Changes button to apply your changes", PluginTextDomain_DEFINE ) . ". "; ?></p>
			<table class="form-table">

				<?php if ( pb1O3u( pb1O1 ) ) {
					$pb1l5o = "homepage_keyword";
					$pb1O5o = pbseo_opt_DEFINE . $pb1l5o;
					$pb1l9h = trim_wrapper( get_option_wrapper( pbseo_opt_DEFINE . $pb1l5o ) );
					$pb1O9h = __( "Home Page Primary Keyword", PluginTextDomain_DEFINE );
					$pb1l9i = __( "Enter the primary keyword you are targeting for your home page", PluginTextDomain_DEFINE ); ?>
					<tr valign="top">
						<th scope="row"><?php echo esc_attr( $pb1O9h ); ?></th>
						<td>
							<input id="<?php echo esc_attr( $pb1O5o ); ?>" name="<?php echo esc_attr( $pb1O5o ); ?>" size="40" type="text" value="<?php echo esc_attr( $pb1l9h ); ?>"/>
							<?php echo pb1O9i( $pb1l9i ); ?>
						</td>
					</tr>
				<?php } ?>
			</table>
			<input name="pbseo_submit" type="submit" class="button-primary" value="<?php echo __( "Save Changes", PluginTextDomain_DEFINE ); ?>"/>

		</form>
	</div>
<?php }

function pb1O9f() {
	; ?>
	<div class="pbseo_tab_content" id="pbseo_content">
		<form name="pbseo_options_content" action="options.php" method="post">
			<?php settings_fields( "pbseo_options_content" ); ?>
			<input name="pbseo_panel_id" type="hidden" value="pbseo_content"/>

			<h3><?php echo __( "Content Settings", PluginTextDomain_DEFINE ); ?></h3>

			<p><?php echo __( "Remember to click the Save Changes button to apply your changes", PluginTextDomain_DEFINE ) . ". "; ?></p>
			<table class="form-table">

				<?php $pb1l5o = "flickr_api";
				$pb1O5o       = pbseo_opt_DEFINE . $pb1l5o;
				$pb1l9h       = trim_wrapper( get_option_wrapper( pbseo_opt_DEFINE . $pb1l5o ) );
				$pb1O9h       = __( "Flickr API Key", PluginTextDomain_DEFINE );
				$pb1l9i       = __( "Enter your Flickr API key, you will need this to retrieve related images", PluginTextDomain_DEFINE ) . ". ";
				$pb1l9i .= "<a href=\"http://www.flickr.com/services/api/misc.api_keys.html\" target=\"_blank\">" . __( "Get a Flickr API Key", PluginTextDomain_DEFINE ) . "</a>"; ?>
				<tr valign="top">
					<th scope="row"><?php echo esc_attr( $pb1O9h ); ?></th>
					<td>
						<input id="<?php echo esc_attr( $pb1O5o ); ?>" name="<?php echo esc_attr( $pb1O5o ); ?>" size="40" type="password" value="<?php echo esc_attr( $pb1l9h ); ?>"/>
						<?php echo pb1O9i( $pb1l9i ); ?>
					</td>
				</tr>

				<?php $pb1l5o = "content_region";
				$pb1O5o       = pbseo_opt_DEFINE . $pb1l5o;
				$pb1l9h       = trim_wrapper( get_option_wrapper( pbseo_opt_DEFINE . $pb1l5o ) );
				if ( empty( $pb1l9h ) ) {
					$pb1l9h = pb1O1t;
				}
				$pb1O9h = __( "Language", PluginTextDomain_DEFINE );
				$pb1l9i = __( "Select if you want content to be resticted to a specific language", PluginTextDomain_DEFINE ) . ". ";
				$pb1l9j = pb1l1t(); ?>
				<tr valign="top">
					<th scope="row"><?php echo esc_attr( $pb1O9h ); ?></th>
					<td>
						<select id="<?php echo esc_attr( $pb1O5o ); ?>" name="<?php echo esc_attr( $pb1O5o ); ?>">
							<?php foreach ( $pb1l9j as $pb1O9j => $pb1l9k ) {
								if ( $pb1O9j == $pb1l9h ) {
									$pb1O9k = " selected=\"selected\"";
								} else {
									$pb1O9k = '';
								} ?>
								<option value="<?php echo $pb1O9j; ?>"<?php echo $pb1O9k; ?>><?php echo $pb1l9k; ?></option>
							<?php } ?>
						</select>
						<?php echo pb1O9i( $pb1l9i ); ?>
					</td>
				</tr>


			</table>
			<input name="pbseo_submit" type="submit" class="button-primary" value="<?php echo __( "Save Changes", PluginTextDomain_DEFINE ); ?>"/>

		</form>
	</div>
<?php }

function pbseo_plugin_training_screen() {
	echo "<div class=\"wrap\">";
	echo "<div id=\"pbseo_icon_options_general\" class=\"icon32\"><br /></div>";
	echo "<h2>" . pb_htmlspecialchars( PushButtonSEO_DEFINE ) . " " . __( "Training and Support", PluginTextDomain_DEFINE ) . "</h2>";
	echo "<div id=\"pbseo_admin_wrapper\">"; ?>
	<table id="pbseo_settings_layout" width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr valign="top">
			<td id="pbseo_settings_form">
				<?php echo pb1O3t( pb1l1i, "panel_1" ); ?>
				<?php if ( ! pb1O3u( pb1O1 ) ) {
					echo pb1O3t( pb1l1i, "panel_2" );
				} ?>
				<?php echo pb1O3t( pb1l1i, "panel_3" ); ?>
			</td>
			<td id="pbseo_settings_info" width="240" style="padding: 12px 0 0 16px; ">
				<?php echo pb1O3t( pb1l1i, "panel_4" ); ?>
				<?php echo pb1O3t( pb1l1i, "panel_5" ); ?>
			</td>
		</tr>
	</table>
	<?php echo "</div>";
	echo "</div>";
}

function pb1O9i( $pb1l9l = "" ) {
	$pb1l9l = trim_wrapper( $pb1l9l );
	if ( ! empty( $pb1l9l ) ) {
		$pb1O4x = "<br />";
		$pb1O4x .= "<small>" . $pb1l9l . "</small>";

		return $pb1O4x;
	}

	return "";
}

function pb1l9d() {
	if ( isset ( $_REQUEST["pbseo_panel_id"] ) ) {
		$pb1O9d = $_REQUEST["pbseo_panel_id"];
		switch ( $pb1O9d ) {
			case "pbseo_general":
				update_option_wrapper( "pbseo_panel_id", pb1lr );
				break;
			case "pbseo_optimizer":
				update_option_wrapper( "pbseo_panel_id", pb1Ot );
				break;
			case "pbseo_links":
				update_option_wrapper( "pbseo_panel_id", pb1ls );
				break;
			case "pbseo_content":
				update_option_wrapper( "pbseo_panel_id", pb1Os );
				break;
			default :
				update_option_wrapper( "pbseo_panel_id", pb1lr );
				break;
		}
	}
}

function pbseo_options_sanitize_proximity_threshold( $pb1O9l ) {
	$pb1O9l = intval( $pb1O9l );
	if ( ( $pb1O9l < 0 ) || ( $pb1O9l > 4 ) ) {
		$pb1O9l = pb1Ov;
	}

	return $pb1O9l;
}

function pbseo_options_sanitize_unlock_code( $pb1O9l ) {
	$pb1O9l = trim_wrapper( pb1O2p( @preg_replace( '/[^a-z]/ui', '', $pb1O9l ) ) );

	return $pb1O9l;
}

function pbseo_options_sanitize_content_region( $pb1O9l ) {
	$pb1O9l = trim_wrapper( pb1l1q( $pb1O9l ) );
	$pb1l9m = pb1l1t();
	if ( ! array_key_exists( $pb1O9l, $pb1l9m ) ) {
		$pb1O9l = pb1l1r;
	}

	return $pb1O9l;
}

function pbseo_options_sanitize_activation_code( $pb1O9l ) {
	$pb1O9l = @preg_replace( '/[^a-zA-Z0-9\\-]/', '', $pb1O9l );
	$pb1l3e = trim_wrapper( $pb1O9l );
	if ( ! empty( $pb1l3e ) ) {
		$pb1O9m = get_option_wrapper( pbseo_opt_DEFINE . "activation_code" );
		if ( $pb1O9m == $pb1l3e ) {
			return $pb1l3e;
		}
		pb1l3p( pb1O23() );
		update_option_wrapper( pbseo_opt_DEFINE . "activation_flag", "1" );
	} else {
		$pb1O9m = get_option_wrapper( pbseo_opt_DEFINE . "activation_code" );
		if ( empty( $pb1O9m ) ) {
			return $pb1l3e;
		} else {
			pbseo_deactivate();
		}
	}

	return $pb1O9l;
}

function pb1l9g() {
	global $wpdb, $pb1l9n;
	echo "<div class=\"pbseo_tab_content\" id=\"pbseo_debug\">";
	echo "<h3>Development Debug</h3>";
	echo "<div style=\"width:500px;padding:10px;overflow:auto;\"><pre>" . print_r( $pb1l9n, TRUE ) . "</pre></div>";
	$_pbseo_temp = get_defined_constants( TRUE );
	if ( isset ( $_pbseo_temp["user"] ) ) {
		echo "<div style=\"width:500px;padding:10px;overflow:auto;\"><pre>" . print_r( $_pbseo_temp["user"], TRUE ) . "</pre></div>";
	}
	echo "</div>";
} ?>