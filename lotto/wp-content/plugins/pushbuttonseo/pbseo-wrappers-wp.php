<?php function plugin_dir_path_wrapper() {
	$plugin_dir_path_function = "plugin_dir_path";
	if ( function_exists_wrapper( $plugin_dir_path_function ) ) {
		return call_user_func( $plugin_dir_path_function, __FILE__ );
	}
	write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $plugin_dir_path_function );

	return FALSE_BOOL_DEFINE;
}

function pb1O1l() {
	$pb1Ob9 = "plugin_dir_url";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9, __FILE__ );
	}
	write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

	return FALSE_BOOL_DEFINE;
}

function pb1O35( $pb1Obb = "name", $pb1lbc = "raw" ) {
	$pb1Ob9 = "get_bloginfo";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9, $pb1Obb, $pb1lbc );
	}
	write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

	return FALSE_BOOL_DEFINE;
}

function pb1l34( $pb1O9y ) {
	$pb1Ob9 = "trailingslashit";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9, $pb1O9y );
	}
	write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

	return FALSE_BOOL_DEFINE;
}

function pb1Obc() {
	$pb1Ob9 = "is_admin";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9 );
	}
	write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

	return FALSE_BOOL_DEFINE;
}

function pb1l2g( $pb1lbd = "manage_options" ) {
	$pb1Ob9 = "current_user_can";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9, $pb1lbd );
	}
	write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

	return FALSE_BOOL_DEFINE;
}

function pb1l9c( $pb1O65 = FALSE_BOOL_DEFINE, $pb1Obd = FALSE_BOOL_DEFINE, $pb1O81 = 012, $pb1lbe = 1 ) {
	$pb1Ob9 = "add_action";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		call_user_func( $pb1Ob9, $pb1O65, $pb1Obd, $pb1O81, $pb1lbe );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );
	}
}

function pb1O9c( $pb1O65 = FALSE_BOOL_DEFINE, $pb1Obd = FALSE_BOOL_DEFINE, $pb1O81 = 012, $pb1lbe = 1 ) {
	$pb1Ob9 = "add_filter";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		call_user_func( $pb1Ob9, $pb1O65, $pb1Obd, $pb1O81, $pb1lbe );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );
	}
}

function pb1l2i( $pb1Obe, $pb1lbf, $pb1Obf = array(), $pb1lbg = FALSE, $pb1Obg = FALSE ) {
	$pb1Ob9 = "wp_register_script";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		call_user_func( $pb1Ob9, $pb1Obe, $pb1lbf, $pb1Obf, $pb1lbg, $pb1Obg );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );
	}
}

function pb1O2i( $pb1Obe, $pb1lbf = FALSE, $pb1Obf = array(), $pb1lbg = FALSE, $pb1Obg = FALSE ) {
	$pb1Ob9 = "wp_enqueue_script";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		call_user_func( $pb1Ob9, $pb1Obe, $pb1lbf, $pb1Obf, $pb1lbg, $pb1Obg );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );
	}
}

function pb1l2k( $pb1Obe, $pb1lbf, $pb1Obf = array(), $pb1lbg = FALSE, $pb1l69 = "all" ) {
	$pb1Ob9 = "wp_register_style";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		call_user_func( $pb1Ob9, $pb1Obe, $pb1lbf, $pb1Obf, $pb1lbg, $pb1l69 );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );
	}
}

function pb1O2k( $pb1Obe, $pb1lbf = FALSE, $pb1Obf = array(), $pb1lbg = FALSE, $pb1l69 = "all" ) {
	$pb1Ob9 = "wp_enqueue_style";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		call_user_func( $pb1Ob9, $pb1Obe, $pb1lbf, $pb1Obf, $pb1lbg, $pb1l69 );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );
	}
}

function get_option_wrapper( $pb1lbh, $pb1Obh = FALSE ) {
	$pb1Ob9 = "get_option";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9, $pb1lbh, $pb1Obh );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

		return FALSE_BOOL_DEFINE;
	}
}

function update_option_wrapper( $pb1lbi, $pb1Obi ) {
	$update_option_func = "update_option";
	if ( function_exists_wrapper( $update_option_func ) ) {
		return call_user_func( $update_option_func, $pb1lbi, $pb1Obi );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $update_option_func );

		return FALSE_BOOL_DEFINE;
	}
}

function pb1O2f( $pb1lbi ) {
	$pb1Ob9 = "delete_option";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9, $pb1lbi );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

		return FALSE_BOOL_DEFINE;
	}
}

function pb1lbj( $pb1Obj = null, $pb1O8n = '', $pb1lbk = null ) {
	$pb1Ob9 = "get_site_url";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9, $pb1Obj, $pb1O8n, $pb1lbk );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

		return FALSE_BOOL_DEFINE;
	}
}

function pb1Obk( $pb1lbl = - 1, $pb1Obl = "_wpnonce" ) {
	$pb1Ob9 = "check_admin_referer";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9, $pb1lbl, $pb1Obl );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

		return FALSE_BOOL_DEFINE;
	}
}

function pb1lbm( $pb1O65, $pb1Obm = '' ) {
	$pb1Ob9 = "do_action";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		call_user_func( $pb1Ob9, $pb1O65, $pb1Obm = '' );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );
	}
}

function pb1lbn( $pb1lbh = "name" ) {
	$pb1Ob9 = "bloginfo";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		call_user_func( $pb1Ob9, $pb1lbh );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );
	}
}

function pb1Obn( $pb1l30, $pb1l68 = '', $pb1l2y = array() ) {
	$pb1Ob9 = "wp_die";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		call_user_func( $pb1Ob9, $pb1l30, $pb1l68, $pb1l2y );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );
	}
}

function pb1l2t( $pb1lbo ) {
	$pb1Ob9 = "get_transient";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9, $pb1lbo );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

		return FALSE_BOOL_DEFINE;
	}
}

function pb1O3p( $pb1lbo ) {
	$pb1Ob9 = "delete_transient";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9, $pb1lbo );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

		return FALSE_BOOL_DEFINE;
	}
}

function pb1l2w( $pb1lbo, $pb1l5h, $pb1Obo = 0 ) {
	$pb1Ob9 = "set_transient";
	if ( function_exists_wrapper( $pb1Ob9 ) ) {
		return call_user_func( $pb1Ob9, $pb1lbo, $pb1l5h, $pb1Obo );
	} else {
		write_log( __( "Illegal function call", PluginTextDomain_DEFINE ) . " : " . $pb1Ob9 );

		return FALSE_BOOL_DEFINE;
	}
} ?>