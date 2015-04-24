<?php
/*
Plugin Name: Simply Hide Pages
Plugin URI: http://silicone.homelinux.org/projects/simply-hide-pages
Description: Easy way to hide some pages from wp_list_pages output. Simply add the custom field 'hide' with any value to your page, and this page will no longer appear on the page list.
Version: 1.0
Author: Julien Viard de Galbert
Author URI: http://silicone.homelinux.org/
License: GPL2+
*/
/*  Copyright (C) 2010  Julien Viard de Galbert <julien@silicone.homelinux.org>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA.
*/

add_filter('wp_list_pages_excludes', simply_hide_pages_wp_list_pages_excludes);

function simply_hide_pages_wp_list_pages_excludes($exclude_array) {
	global $wpdb;
	$table=_get_meta_table('post');
	$sql = "SELECT post_id FROM ".$table." WHERE meta_key ='hide'";
	$id_array = $wpdb->get_col($sql);
	$exclude_array=array_merge($id_array, $exclude_array);
	return $exclude_array;
}
?>
