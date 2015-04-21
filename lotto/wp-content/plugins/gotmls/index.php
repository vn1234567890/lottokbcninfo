<?php
/*
Plugin Name: Anti-Malware and Brute-Force Security by ELI
Plugin URI: http://gotmls.net/
Author: Eli Scheetz
Text Domain: gotmls
Author URI: http://wordpress.ieonly.com/category/my-plugins/anti-malware/
Contributors: scheeeli, gotmls
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZHD8QHZ2E7PE
Description: This Anti-Virus/Anti-Malware plugin searches for Malware and other Virus like threats and vulnerabilities on your server and helps you remove them. It's always growing and changing to adapt to new threats so let me know if it's not working for you.
Version: 4.14.59
*/
if (isset($_SERVER["DOCUMENT_ROOT"]) && ($SCRIPT_FILE = str_replace($_SERVER["DOCUMENT_ROOT"], "", isset($_SERVER["SCRIPT_FILENAME"])?$_SERVER["SCRIPT_FILENAME"]:isset($_SERVER["SCRIPT_NAME"])?$_SERVER["SCRIPT_NAME"]:"")) && strlen($SCRIPT_FILE) > strlen("/".basename(__FILE__)) && substr(__FILE__, -1 * strlen($SCRIPT_FILE)) == substr($SCRIPT_FILE, -1 * strlen(__FILE__)))
	include(dirname(__FILE__)."/safe-load/index.php");
else
	require_once(dirname(__FILE__)."/images/index.php");
/*            ___
 *           /  /\     GOTMLS Main Plugin File
 *          /  /:/     @package GOTMLS
 *         /__/::\
 Copyright \__\/\:\__  © 2012-2015 Eli Scheetz (email: eli@gotmls.net)
 *            \  \:\/\
 *             \__\::/ This program is free software; you can redistribute it
 *     ___     /__/:/ and/or modify it under the terms of the GNU General Public
 *    /__/\   _\__\/ License as published by the Free Software Foundation;
 *    \  \:\ /  /\  either version 2 of the License, or (at your option) any
 *  ___\  \:\  /:/ later version.
 * /  /\\  \:\/:/
  /  /:/ \  \::/ This program is distributed in the hope that it will be useful,
 /  /:/_  \__\/ but WITHOUT ANY WARRANTY; without even the implied warranty
/__/:/ /\__    of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
\  \:\/:/ /\  See the GNU General Public License for more details.
 \  \::/ /:/
  \  \:\/:/ You should have received a copy of the GNU General Public License
 * \  \::/ with this program; if not, write to the Free Software Foundation,    
 *  \__\/ Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA        */

load_plugin_textdomain('gotmls', false, basename(GOTMLS_plugin_path).'/languages');
require_once(GOTMLS_plugin_path.'images/index.php');

function GOTMLS_install() {
	global $wp_version;
	if (version_compare($wp_version, GOTMLS_require_version, "<"))
		die(GOTMLS_require_version_LANGUAGE);
}
register_activation_hook(__FILE__, "GOTMLS_install");

function GOTMLS_menu() {
	if (is_multisite())
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["user_can"] = "manage_network";
	elseif (!isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["user_can"]) || $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["user_can"] == "manage_network")
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["user_can"] = "activate_plugins";
	if (isset($_POST["GOTMLS_menu_group"]) && is_numeric($_POST["GOTMLS_menu_group"])) {
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["menu_group"] = $_POST["GOTMLS_menu_group"];
/*		$capabilities = array();
		if (current_user_can($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["user_can"]))
			foreach (get_editable_roles() as $role)
				$capabilities = array_merge($capabilities, $role["capabilities"]);
		if (isset($_POST["GOTMLS_user_can"]) && in_array($_POST["GOTMLS_user_can"], $capabilities))
			$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["user_can"] = $_POST["GOTMLS_user_can"];*/
		update_option('GOTMLS_settings_array', $GLOBALS["GOTMLS"]["tmp"]["settings_array"]);
	}
	$GOTMLS_Full_plugin_logo_URL = GOTMLS_images_path.'GOTMLS-16x16.gif';
	$base_page = "GOTMLS-settings";
	$base_function = "GOTMLS_settings";
	$pluginTitle = "Anti-Malware";
	$pageTitle = "$pluginTitle ".GOTMLS_Scan_Settings_LANGUAGE;
	if (!function_exists("add_object_page") || $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["menu_group"])
		$my_admin_page = add_menu_page($pageTitle, $pluginTitle, $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["user_can"], $base_page, $base_function, $GOTMLS_Full_plugin_logo_URL);
	else
		$my_admin_page = add_object_page($pageTitle, $pluginTitle, $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["user_can"], $base_page, $base_function, $GOTMLS_Full_plugin_logo_URL);
	add_action('load-'.$my_admin_page, 'GOTMLS_admin_add_help_tab');
	add_submenu_page($base_page, "$pluginTitle ".GOTMLS_Scan_Settings_LANGUAGE, GOTMLS_Scan_Settings_LANGUAGE, $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["user_can"], $base_page, $base_function);
	add_submenu_page($base_page, "$pluginTitle ".GOTMLS_Run_Quick_Scan_LANGUAGE, GOTMLS_Run_Quick_Scan_LANGUAGE, $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["user_can"], "$base_page&scan_type=Quick+Scan", $base_function);
	add_submenu_page($base_page, "$pluginTitle ".GOTMLS_View_Quarantine_LANGUAGE, GOTMLS_View_Quarantine_LANGUAGE, $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["user_can"], "GOTMLS-View-Quarantine", "GOTMLS_View_Quarantine");
}

function GOTMLS_admin_add_help_tab() {
	$screen = get_current_screen();
	$screen->add_help_tab(array(
		'id'	=> "GOTMLS_Getting_Started",
		'title'	=> __("Getting Started", 'gotmls'),
		'content'	=> '<p>'.__("Make sure the Definition Updates are current and Run a Complete Scan.").'</p><p>'.sprintf(__("If Known Threats are found and displayed in red then there will be a button to '%s'. If only Potentional Threats are found then there is no automatic fix because those are probably not malicious."), GOTMLS_Automatically_Fix_LANGUAGE).'</p><p>'.__("A backup of the original infected files are placed in the Quarantine in case you need to restore them or just want to look at them later. You can delete these files if you don't want to save more.").'</p>'
	));
	$FAQMarker = '== Frequently Asked Questions ==';
 	if (is_file(dirname(__FILE__).'/readme.txt') && ($readme = explode($FAQMarker, @file_get_contents(dirname(__FILE__).'/readme.txt').$FAQMarker)) && strlen($readme[1]) && ($readme = explode("==", $readme[1]."==")) && strlen($readme[0])) {
		$screen->add_help_tab(array(
			'id'	=> "GOTMLS_FAQs",
			'title'	=> __("FAQs", 'gotmls'),
			'content'	=> '<p>'.preg_replace('/\[(.+?)\]\((.+?)\)/', "<a target=\"_blank\" href=\"\\2\">\\1</a>", preg_replace('/[\r\n]+= /', "</p><b>", preg_replace('/ =[\r\n]+/', "</b><p>", $readme[0]))).'</p>'
		));
	}
	if (is_multisite() && current_user_can("manage_network"))
		$GOTMLS_menu_groups = array(__("Main Menu Item placed at the <b>Top</b>",'gotmls'),__("Main Menu Item placed at the <b>Bottom</b>",'gotmls'));
	else
		$GOTMLS_menu_groups = array(__("Main Menu Item placed below <b>Comments</b> and above <b>Appearance</b>",'gotmls'),__("Main Menu Item placed below <b>Settings</b>",'gotmls'));
	$menu_opts = '<h5>'.__("Menu Item Placement Options",'gotmls').'</h5>';
	foreach ($GOTMLS_menu_groups as $mg => $GOTMLS_menu_group)
		$menu_opts .= '<div style="padding: 4px;" id="menu_group_div_'.$mg.'"><input type="radio" name="GOTMLS_menu_group" value="'.$mg.'"'.($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["menu_group"]==$mg?' checked':'').' onchange="document.GOTMLS_menu_Form.submit();" />'.$GOTMLS_menu_group.'</div>';
	$screen->add_help_tab(array(
		'id'	=> 'GOTMLS_Menu_Placement',
		'title'	=> __("Menu Placement", 'gotmls'),
		'content'	=> '<form method="POST" name="GOTMLS_menu_Form">'.$menu_opts.'</form>'
	));
}

function GOTMLS_display_header($optional_box = "") {
	global $GOTMLS_onLoad, $GOTMLS_loop_execution_time, $GOTMLS_update_home, $GOTMLS_plugin_home, $wp_version, $current_user;
	get_currentuserinfo();
	$GOTMLS_url_parts = explode('/', GOTMLS_siteurl);
	if (isset($_GET["check_site"]) && $_GET["check_site"] == 1)
		echo '<div id="check_site" style="z-index: 1234567;"><img src="'.GOTMLS_images_path.'checked.gif" height=16 width=16 alt="&#x2714;"> '.__("Tested your site. It appears we didn't break anything",'gotmls').' ;-)</div><script type="text/javascript">window.parent.document.getElementById("check_site_warning").style.backgroundColor=\'#0C0\';</script><li>Please <a target="_blank" href="https://wordpress.org/plugins/gotmls/stats/?compatibility%5Bversion%5D='.$wp_version.'&compatibility%5Btopic_version%5D='.GOTMLS_Version.'&compatibility%5Bcompatible%5D=1#compatibility-works">Vote "Works"</a> or <a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/gotmls#postform">write a "Five-Star" Reviews</a> on WordPress.org if you like this plugin.</li><style>#footer, #GOTMLS-metabox-container, #GOTMLS-right-sidebar, #admin-page-container, #wpadminbar, #adminmenuback, #adminmenuwrap, #adminmenu, .error, .updated, .update-nag {display: none !important;} #wpbody-content {padding-bottom: 0;} #wpbody, html.wp-toolbar {padding-top: 0 !important;} #wpcontent, #footer {margin-left: 5px !important;}';
	else
		echo '<style>#GOTMLS-right-sidebar {float: right; margin-right: 0px;}';
	$ver_info = GOTMLS_Version.'&p='.strtoupper(GOTMLS_plugin_dir).'&wp='.$wp_version.'&ts='.date("YmdHis").'&key='.GOTMLS_installation_key.'&d='.ur1encode(GOTMLS_siteurl);
	$Update_Link = '<div style="text-align: center;"><a href="';
	$new_version = "";
	$file = basename(GOTMLS_plugin_path).'/index.php';
	$current = get_site_transient("update_plugins");
	if (isset($current->response[$file]->new_version)) {
		$new_version = sprintf(__("Upgrade to %s now!",'gotmls'), $current->response[$file]->new_version).'<br /><br />';
		$Update_Link .= wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=').$file, 'upgrade-plugin_'.$file);
	}
	$Update_Link .= "\">$new_version</a></div>";
	$Update_Div ='<div id="findUpdates" style="display: none;"><center>'.__("Searching for updates ...",'gotmls').'<br /><img src="'.GOTMLS_images_path.'wait.gif" height=16 width=16 alt="Wait..." /><br /><input type="button" value="Cancel" onclick="cancelserver(\'findUpdates\');" /></center></div>';
	echo '
span.GOTMLS_date {float: right; width: 120px; white-space: nowrap;}
.rounded-corners {margin: 10px; border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; border: 1px solid #000;}
.shadowed-box {box-shadow: -3px 3px 3px #666; -moz-box-shadow: -3px 3px 3px #666; -webkit-box-shadow: -3px 3px 3px #666;}
.sidebar-box {background-color: #CCC;}
.GOTMLS-scanlog li a {display: none;}
.GOTMLS-scanlog li:hover a {display: block;}
.GOTMLS-sidebar-links {list-style: none;}
.GOTMLS-sidebar-links li img {margin: 3px; height: 16px; vertical-align: middle;}
.GOTMLS-sidebar-links li {margin-bottom: 0 !important;}
.popup-box {background-color: #FFC; display: none; position: absolute; left: 0px; z-index: 10;}
.shadowed-text {text-shadow: #00F -1px 1px 1px;}
.sub-option {float: left; margin: 3px 5px;}
.inside p {margin: 10px;}
.GOTMLS_li, .GOTMLS_plugin li {list-style: none;}
.GOTMLS_plugin {margin: 5px; background: #cfc; border: 1px solid #0f0; padding: 0 5px; border-radius: 3px;}
.GOTMLS_plugin.known, .GOTMLS_plugin.backdoor, .GOTMLS_plugin.htaccess, .GOTMLS_plugin.timthumb, .GOTMLS_plugin.errors {background: #f99; border: 1px solid #f00;}
.GOTMLS_plugin.potential, .GOTMLS_plugin.wp_login, .GOTMLS_plugin.skipdirs, .GOTMLS_plugin.skipped {background: #ffc; border: 1px solid #fc6;}
.GOTMLS ul li {margin-left: 20px;}
.GOTMLS h2 {margin: 0 0 10px;}
.postbox {margin-right: 10px;}
#pastDonations li {list-style: none;}
#main-page-title {
	background: url("'.$GLOBALS["GOTMLS"]["tmp"]["protocol"].'//gravatar.com/avatar/5feb789dd3a292d563fea3b885f786d6?s=64") no-repeat scroll 0 0 transparent;
	height: 64px;
	line-height: 58px;
	margin: 10px 0 0 0;
	max-width: 600px;
	padding: 0 110px 0 84px;
}
#main-page-title h1 {
	background: url("'.$GLOBALS["GOTMLS"]["tmp"]["protocol"].'//gravatar.com/avatar/69ad8428e97469d0dcd64f1f60c07bd8?s=64") no-repeat scroll top right transparent;
	height: 64px;
	line-height: 32px;
	margin: 0;
	padding: 0 84px 0 0;
	display: table-cell;
    text-align: center;
    vertical-align: middle;
}
</style>
<div id="div_file" class="shadowed-box rounded-corners sidebar-box" style="padding: 0; display: none; position: fixed; top: '.$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][1].'; left: '.$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][0].'; width: '.$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][3].'; height: '.$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][2].'; border: solid #c00; z-index: 112358;"><table style="width: 100%; height: 100%;" cellspacing="0" cellpadding="0"><tr><td style="border-bottom: 1px solid #EEEEEE;" colspan="2"><a class="rounded-corners" name="link_file" style="float: right; padding: 0 4px; margin: 6px; text-decoration: none; color: #C00; background-color: #FCC; border: solid #F00 1px;" href="#found_top" onclick="showhide(\'div_file\');">X</a><h3 onmousedown="grabDiv();" onmouseup="releaseDiv();" id="windowTitle" style="cursor: move; border-bottom: 0px none; z-index: 2345677; position: absolute; left: 0px; top: 0px; margin: 0px; padding: 6px; width: 90%; height: 20px;">'.GOTMLS_Loading_LANGUAGE.'</h3></td></tr><tr><td colspan="2" style="height: 100%"><div style="width: 100%; height: 100%; position: relative; padding: 0; margin: 0;" class="inside"><br /><br /><center><img src="'.GOTMLS_images_path.'wait.gif" height=16 width=16 alt="..."> '.GOTMLS_Loading_LANGUAGE.'<br /><br /><input type="button" onclick="showhide(\'GOTMLS_iFrame\', true);" value="'.__("If this is taking too long, click here.",'gotmls').'" class="button-primary" /></center><iframe id="GOTMLS_iFrame" name="GOTMLS_iFrame" style="top: 0px; left: 0px; position: absolute; width: 100%; height: 100%; background-color: #CCC;"></iframe></td></tr><tr><td style="height: 20px;"><iframe id="GOTMLS_statusFrame" name="GOTMLS_statusFrame" style="width: 100%; height: 20px; background-color: #CCC;"></iframe></div></td><td style="height: 20px; width: 20px;"><h3 id="cornerGrab" onmousedown="grabCorner();" onmouseup="releaseCorner();" style="cursor: move; height: 24px; width: 24px; margin: 0; padding: 0; z-index: 2345678; position: absolute; right: 0px; bottom: 0px;">&#8690;</h3></td></tr></table></div>
<script type="text/javascript">
function showhide(id) {
	divx = document.getElementById(id);
	if (divx) {
		if (divx.style.display == "none" || arguments[1]) {
			divx.style.display = "block";
			divx.parentNode.className = (divx.parentNode.className+"close").replace(/close/gi,"");
			return true;
		} else {
			divx.style.display = "none";
			return false;
		}
	}
}
function checkAllFiles(check) {
	var checkboxes = new Array(); 
	checkboxes = document["GOTMLS_Form_clean"].getElementsByTagName("input");
	for (var i=0; i<checkboxes.length; i++)
		if (checkboxes[i].type == "checkbox")
			checkboxes[i].checked = check;
}
function setvalAllFiles(val) {
	var checkboxes = document.getElementById("GOTMLS_fixing");
	if (checkboxes)
		checkboxes.value = val;
}
function getWindowWidth(min) {
	if (typeof window.innerWidth != "undefined" && window.innerWidth > min)
		min = window.innerWidth;
	else if (typeof document.documentElement != "undefined" && typeof document.documentElement.clientWidth != "undefined" && document.documentElement.clientWidth > min)
		min = document.documentElement.clientWidth;
	else if (typeof document.getElementsByTagName("body")[0].clientWidth != "undefined" && document.getElementsByTagName("body")[0].clientWidth > min)
		min = document.getElementsByTagName("body")[0].clientWidth;
	return min;
}
function getWindowHeight(min) {
	if (typeof window.innerHeight != "undefined" && window.innerHeight > min)
		min = window.innerHeight;
	else if (typeof document.documentElement != "undefined" && typeof document.documentElement.clientHeight != "undefined" && document.documentElement.clientHeight > min)
		min = document.documentElement.clientHeight;
	else if (typeof document.getElementsByTagName("body")[0].clientHeight != "undefined" && document.getElementsByTagName("body")[0].clientHeight > min)
		min = document.getElementsByTagName("body")[0].clientHeight;
	return min;
}
function loadIframe(title) {
	showhide("GOTMLS_iFrame", true);
	showhide("GOTMLS_iFrame");
	document.getElementById("windowTitle").innerHTML = title;
	if (curDiv) {
		windowW = getWindowWidth(200);
		windowH = getWindowHeight(200);
		if (windowW > 200)
			windowW -= 30;
		if (windowH > 200)
			windowH -= 20;
		if (px2num(curDiv.style.width) > windowW) {
			curDiv.style.width = windowW + "px";
			curDiv.style.left = "0px";
		} else if ((px2num(curDiv.style.left) + px2num(curDiv.style.width)) > windowW) {
			curDiv.style.left = (windowW - px2num(curDiv.style.width)) + "px";
		}
		if (px2num(curDiv.style.height) > windowH) {
			curDiv.style.height = windowH + "px";
			curDiv.style.top = "0px";
		} else if ((px2num(curDiv.style.top) + px2num(curDiv.style.height)) > windowH) {
			curDiv.style.top = (windowH - px2num(curDiv.style.height)) + "px";
		}
		if (px2num(curDiv.style.left) < 0)
			curDiv.style.left = "0px";
		if (px2num(curDiv.style.top)< 0)
			curDiv.style.top = "0px";
	}
	showhide("div_file", true);
	if (IE)
		curDiv.scrollIntoView(true);
}
function cancelserver(divid) {
	document.getElementById(divid).innerHTML = "<div class=\'error\'>'. __("No response from server!",'gotmls').'</div>";
}
function checkupdateserver(server, divid) {
	var updatescript = document.createElement("script");
	updatescript.setAttribute("src", server);
	divx = document.getElementById(divid);
	if (divx) {
		divx.appendChild(updatescript);
		if (arguments[2])
			return setTimeout("stopCheckingDefinitions = checkupdateserver(\'"+arguments[2]+"\',\'"+divid+"\')",15000);
		else
			return setTimeout("cancelserver(\'"+divid+"\')",'.($GOTMLS_loop_execution_time+1).'000+3000);
	}
}
var IE = document.all?true:false;
if (!IE) document.captureEvents(Event.MOUSEMOVE)
document.onmousemove = getMouseXY;
var offsetX = 0;
var offsetY = 0;
var offsetW = 0;
var offsetH = 0;
var curX = 0;
var curY = 0;
var curDiv;
function getMouseXY(e) {
	if (IE) { // grab the mouse pos if browser is IE
		curX = event.clientX + document.body.scrollLeft;
		curY = event.clientY + document.body.scrollTop;
	} else {  // grab the mouse pos if browser is Not IE
		curX = e.pageX - document.body.scrollLeft;
		curY = e.pageY - document.body.scrollTop;
	}
	if (curX < 0) {curX = 0;}
	if (curY < 0) {curY = 0;}
	if (offsetX && curX > 10) {curDiv.style.left = (curX - offsetX)+"px";}
	if (offsetY && (curY - offsetY) > 0) {curDiv.style.top = (curY - offsetY)+"px";}
	if (offsetW && (curX - offsetW) > 360) {curDiv.style.width = (curX - offsetW)+"px";}
	if (offsetH && (curY - offsetH) > 200) {curDiv.style.height = (curY - offsetH)+"px";}
	return true;
}
function px2num(px) {
	return parseInt(px.substring(0, px.length - 2), 10);
}
function setDiv(DivID) {
	if (curDiv = document.getElementById(DivID)) {
		if (IE)
			curDiv.style.position = "absolute";
		curDiv.style.left = "'.$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][0].'";
		curDiv.style.top = "'.$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][1].'";
		curDiv.style.height = "'.$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][2].'";
		curDiv.style.width = "'.$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][3].'";
	}
}
function grabDiv() {
	corner = document.getElementById("windowTitle");
	if (corner) {
		corner.style.width="100%";
		corner.style.height="100%";
	}
	offsetX=curX-px2num(curDiv.style.left); 
	offsetY=curY-px2num(curDiv.style.top);
}
function releaseDiv() {
	corner = document.getElementById("windowTitle");
	if (corner) {
		corner.style.width="90%";
		corner.style.height="20px";
	}
	document.getElementById("GOTMLS_statusFrame").src = "'.GOTMLS_script_URI.'&GOTMLS_x="+curDiv.style.left+"&GOTMLS_y="+curDiv.style.top;
	offsetX=0; 
	offsetY=0;
}
function grabCorner() {
	corner = document.getElementById("cornerGrab");
	if (corner) {
		corner.style.width="100%";
		corner.style.height="100%";
	}
	offsetW=curX-px2num(curDiv.style.width); 
	offsetH=curY-px2num(curDiv.style.height);
}
function releaseCorner() {
	corner = document.getElementById("cornerGrab");
	if (corner) {
		corner.style.width="20px";
		corner.style.height="20px";
	}
	document.getElementById("GOTMLS_statusFrame").src = "'.GOTMLS_script_URI.'&GOTMLS_w="+curDiv.style.width+"&GOTMLS_h="+curDiv.style.height;
	offsetW=0; 
	offsetH=0;
}
setDiv("div_file");
</script>
<div id="main-page-title"><h1 style="vertical-align: middle;">Anti-Malware from&nbsp;GOTMLS.NET</h1></div>
<div id="admin-page-container">
<div id="GOTMLS-right-sidebar" style="width: 300px;" class="metabox-holder">
	'.GOTMLS_box(__("Updates & Registration",'gotmls'), '<ul style=""><li>WordPress: <span class="GOTMLS_date">'.$wp_version.'</span></li>
<li>Plugin: <span class="GOTMLS_date">'.GOTMLS_Version.'</span></li>
<li>Definitions: <span class="GOTMLS_date">'.$GLOBALS["GOTMLS"]["tmp"]["Definition"]["Latest"].'</span></li>
<li>Key: <span style="float: right;">'.GOTMLS_installation_key.'</span></li></ul>
	<form id="updateform" method="post" name="updateform" action="'.GOTMLS_script_URI.'">
		<img style="display: none; float: right; margin-right: 14px;" src="'.GOTMLS_images_path.'checked.gif" height=16 width=16 alt="definitions file updated" id="autoUpdateDownload" onclick="showhide(\'autoUpdateForm\', true);">
		'.str_replace('findUpdates', 'Definition_Updates', $Update_Div).'
		<div id="autoUpdateForm" style="display: none;">
		<input type="submit" style="width: 100%;" name="auto_update" value="'.__("Download new definitions!",'gotmls').'"> 
		</div>
	</form>
		<div id="registerKeyForm" style="display: none;">'.__("<p>If you already registered your Key then you can get instant access to definition updates.</p>",'gotmls').'<input type="button" style="width: 100%;" value="'.__("Check for Definition Updates Now!",'gotmls').'" onclick="check_for_updates(\'Definition_Updates\');" />
'.__("<p>If you have not already registered your Key then register now and get instant access to definition updates.</p><p>* All fields are required and I will NOT share your registration information with anyone.</p>",'gotmls').'
<form id="registerform" onsubmit="return sinupFormValidate(this);" action="'.$GOTMLS_update_home.'wp-login.php?action=register" method="post" name="registerform" target="GOTMLS_iFrame"><input type="hidden" name="redirect_to" id="register_redirect_to" value="/donate/"><input type="hidden" name="user_login" id="register_user_login" value="">
<div>'.__("Your Full Name:",'gotmls').'</div>
<div style="float: left; width: 50%;"><input style="width: 100%;" id="first_name" type="text" name="first_name" value="'.$current_user->user_firstname.'" /></div>
<div style="float: left; width: 50%;"><input style="width: 100%;" id="last_name" type="text" name="last_name" value="'.$current_user->user_lastname.'" /></div>
<div style="clear: left; width: 100%;">
<div>'.__("A password will be e-mailed to this address:",'gotmls').'</div>
<input style="width: 100%;" id="user_email" type="text" name="user_email" value="'.$current_user->user_email.'" /></div>
<div>
<div>'.__("Your WordPress Site URL:",'gotmls').'</div>
<input style="width: 100%;" id="user_url" type="text" name="user_url" value="'.GOTMLS_siteurl.'" readonly /></div>
<div>
<div>'.__("Plugin Installation Key:",'gotmls').'</div>
<input style="width: 100%;" id="installation_key" type="text" name="installation_key" value="'.GOTMLS_installation_key.'" readonly /><input id="old_key" type="hidden" name="old_key" value="'.md5($GOTMLS_url_parts[2]).'" /></div>
<input style="width: 100%;" id="wp-submit" type="submit" name="wp-submit" value="Register Now!" /></form></div>'.$Update_Link, "stuffbox").'
	<script type="text/javascript">
		function check_for_updates(update_type) {
			showhide(update_type, true);
			stopCheckingDefinitions = checkupdateserver("'.$GOTMLS_update_home.$GLOBALS["GOTMLS"]["tmp"]["Definition"]["Updates"].'&js='.$ver_info.'", update_type, "'.str_replace("://", "://www.", $GOTMLS_update_home).$GLOBALS["GOTMLS"]["tmp"]["Definition"]["Updates"].'&js='.$ver_info.'");
		}
		function updates_complete(chk) {
			if (auto_img = document.getElementById("autoUpdateDownload")) {
				auto_img.style.display="block";
				check_for_donation(chk);
			}
		}
		function check_for_registration() {
			if ('.preg_replace('/[^0-9]/', "", GOTMLS_sexagesimal($GLOBALS["GOTMLS"]["tmp"]["Definition"]["Latest"])).'0 > '.preg_replace('/[^0-9]/', "", GOTMLS_sexagesimal($GLOBALS["GOTMLS"]["tmp"]["Definition"]["Default"])).'0)
				return true;
			else
				return false;
		}
		function check_for_donation(chk) {
			if (document.getElementById("autoUpdateDownload").src.replace(/^.+\?/,"")=="0") {
				alert(chk+"\\n\\n'.__("Please make a donation for the use of this wonderful feature!",'gotmls').'");
				if (check_for_registration() && chk.substr(0, 8) == "Changed " && chk.substr(8, 1) != "0")
					window.open("'.$GOTMLS_update_home.GOTMLS_installation_key.'/donate/?donation-source="+chk, "_blank");
			} else
				alert(chk);
		}
		function sinupFormValidate(form) {
			var error = "";
			if(form["first_name"].value == "")	
				error += "'.__("First Name is a required field!",'gotmls').'\n";
			if(form["last_name"].value == "")		
				error += "'.__("Last Name is a required field!",'gotmls').'\n";
			if(form["user_email"].value == "")
				error += "'.__("Email Address is a required field!",'gotmls').'\n";
			else {
				if (uem = document.getElementById("register_user_login"))
					uem.value = form["user_email"].value;
				if (uem = document.getElementById("register_redirect_to"))
					uem.value = "/donate/?email="+form["user_email"].value.replace("@", "%40");
			}
			if(form["user_url"].value == "")
				error += "'.__("Your WordPress Site URL is a required field!",'gotmls').'\n";
			if(form["installation_key"].value == "")
				error += "'.__("Plugin Installation Key is a required field!",'gotmls').'\n";
			if(error != "") {
				alert(error);
				return false;
			} else {
				document.getElementById("Definition_Updates").innerHTML = \'<img src="'.GOTMLS_images_path.'wait.gif">'.__("Submitting Registration ...",'gotmls').'\';
				setTimeout(\'stopCheckingDefinitions = checkupdateserver("'.$GOTMLS_update_home.$GLOBALS["GOTMLS"]["tmp"]["Definition"]["Updates"].'&js='.$ver_info.'", "Definition_Updates");\', 6000);
				showhide("registerKeyForm");
				return true;
			}
		}
		var divNAtext = false;
		function loadGOTMLS() {
			clearTimeout(divNAtext);
			setDivNAtext();
			'.$GOTMLS_onLoad.'
		}
		if (check_for_registration())
			check_for_updates("Definition_Updates");
		else
			showhide("registerKeyForm", true);
		if (divNAtext)
			loadGOTMLS();
		else
			divNAtext=true;
	</script>
	'.GOTMLS_box(__("Resources & Links",'gotmls'), '
			<div id="pastDonations"></div>
			<form name="ppdform" id="ppdform" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="eli@gotmls.net">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="no_note" value="1">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="tax" value="0">
			<input type="hidden" name="lc" value="US">
			<input type="hidden" name="bn" value="PP-DonationsBF">
			<input type="radio" name="amount" value="14.89">$14+
			<input type="radio" name="amount" value="29.14" checked>$29+
			<input type="radio" name="amount" value="49.75">$49+
			<input type="radio" name="amount" value="76.00">$76
			<input type="radio" name="amount" value="152.00">$152
			<input type="hidden" name="item_name" value="Donation to Eli\'s Anti-Malware Plugin">
			<input type="hidden" name="item_number" value="GOTMLS-key-'.GOTMLS_installation_key.'">
			<input type="hidden" name="custom" value="key-'.GOTMLS_installation_key.'">
			<input type="hidden" name="notify_url" value="'.$GOTMLS_update_home.GOTMLS_installation_key.'/ipn">
			<input type="hidden" name="page_style" value="GOTMLS">
			<input type="hidden" name="return" value="'.$GOTMLS_update_home.GOTMLS_installation_key.'/donate/?donation-source=paid">
			<input type="hidden" name="cancel_return" value="'.$GOTMLS_update_home.GOTMLS_installation_key.'/donate/?donation-source=cancel">
			<input type="image" id="pp_button" src="'.GOTMLS_images_path.'btn_donateCC_WIDE.gif" border="0" name="submitc" alt="'.__("Make a Donation with PayPal",'gotmls').'">
			<div>
				<ul class="GOTMLS-sidebar-links">
					<li style="float: right;"><b>on <a target="_blank" href="https://profiles.wordpress.org/scheeeli#content-plugins">WordPress.org</a></b><ul class="GOTMLS-sidebar-links">
						<li><a target="_blank" href="https://wordpress.org/plugins/'.GOTMLS_plugin_dir.'/faq/">Plugin FAQs</a></li>
						<li><a target="_blank" href="https://wordpress.org/support/plugin/'.GOTMLS_plugin_dir.'">Forum Posts</a></li>
						<li><a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/'.GOTMLS_plugin_dir.'">Plugin Reviews</a></li>
					</ul></li>
					<li><img src="'.$GOTMLS_update_home.'/favicon.ico" border="0" alt="Plugin site:"><b><a target="_blank" href="'.$GOTMLS_update_home.'">GOTMLS.NET</a></b></li>
					<li><img src="'.$GOTMLS_plugin_home.'/favicon.ico" border="0" alt="Developer site:"><b><a target="_blank" href="'.$GOTMLS_plugin_home.'/category/my-plugins/anti-malware/">Eli\'s Blog</a></b></li>
					<li><img src="https://ssl.gstatic.com/ui/v1/icons/mail/favicon.ico" border="0" alt="mail:"><b><a target="_blank" href="mailto:eli@gotmls.net">Email Eli</a></b></li>
					<li><iframe allowtransparency="true" frameborder="0" scrolling="no" src="https://platform.twitter.com/widgets/follow_button.html?screen_name=GOTMLS&amp;show_count=false" style="width:125px; height:20px;"></iframe></li>
				</ul>
			</div>
			</form>
			<a target="_blank" href="http://safebrowsing.clients.google.com/safebrowsing/diagnostic?site='.urlencode(GOTMLS_siteurl).'">Google Safe Browsing Diagnostic</a>', "stuffbox").'
	'.GOTMLS_box(__("Last Scan Status",'gotmls'), GOTMLS_scan_log(), "stuffbox").'
	'.$optional_box.'
</div>';
	if (isset($GLOBALS["GOTMLS"]["tmp"]["stuffbox"]) && is_array($GLOBALS["GOTMLS"]["tmp"]["stuffbox"])) {
		echo '
<script type="text/javascript">
function stuffbox_showhide(id) {
	divx = document.getElementById(id);
	if (divx) {
		if (divx.style.display == "none" || arguments[1]) {';
		$else = '
			if (divx = document.getElementById("GOTMLS-right-sidebar"))
				divx.style.width = "30px";
			if (divx = document.getElementById("GOTMLS-main-section"))
				divx.style.marginRight = "30px";';
		foreach ($GLOBALS["GOTMLS"]["tmp"]["stuffbox"] as $md5 => $bTitle) {
			echo "\nif (divx = document.getElementById('inside_$md5'))\n\tdivx.style.display = 'block';\nif (divx = document.getElementById('title_$md5'))\n\tdivx.innerHTML = '".GOTMLS_strip4java($bTitle)."';";
			$else .= "\nif (divx = document.getElementById('inside_$md5'))\n\tdivx.style.display = 'none';\nif (divx = document.getElementById('title_$md5'))\n\tdivx.innerHTML = '".substr($bTitle, 0, 1)."';";
		}
		echo '
			if (divx = document.getElementById("GOTMLS-right-sidebar"))
				divx.style.width = "300px";
			if (divx = document.getElementById("GOTMLS-main-section"))
				divx.style.marginRight = "300px";
			return true;
		} else {'.$else.'
			return false;
		}
	}
}
if (getWindowWidth(780) == 780) 
	setTimeout("stuffbox_showhide(\'inside_'.$md5.'\')", 200);
</script>';
	}
	echo '
	<div id="GOTMLS-main-section" style="margin-right: 300px;">
		<div class="metabox-holder GOTMLS" style="width: 100%;" id="GOTMLS-metabox-container">';
}

function GOTMLS_box($bTitle, $bContents, $bType = "postbox") {
	$md5 = md5($bTitle);
	if (isset($GLOBALS["GOTMLS"]["tmp"]["$bType"]) && is_array($GLOBALS["GOTMLS"]["tmp"]["$bType"]))
		$GLOBALS["GOTMLS"]["tmp"]["$bType"]["$md5"] = "$bTitle";
	else
		$GLOBALS["GOTMLS"]["tmp"]["$bType"] = array("$md5"=>"$bTitle");
	return '
	<div id="box_'.$md5.'" class="'.$bType.'"><h3 title="Click to toggle" onclick="if (typeof '.$bType.'_showhide == \'function\'){'.$bType.'_showhide(\'inside_'.$md5.'\');}else{showhide(\'inside_'.$md5.'\');}" style="cursor: pointer;" class="hndle"><span id="title_'.$md5.'">'.$bTitle.'</span></h3>
		<div id="inside_'.$md5.'" class="inside">
'.$bContents.'
		</div>
	</div>';
}

function GOTMLS_get_scanlog() {
	global $wpdb;
	$LastScan = '
	<form method="POST" target="GOTMLS_iFrame" name="GOTMLS_Form_clean"><input type="hidden" id="GOTMLS_fixing" name="GOTMLS_fixing" value="1">';
	if (isset($_GET["GOTMLS_cl"])) {
		$SQL = $wpdb->prepare("DELETE FROM `$wpdb->options` WHERE option_name LIKE %s AND substring_index(option_name, '/', -1) < %s", 'GOTMLS_scan_log/%', $_GET["GOTMLS_cl"]);
		if ($cleared = $wpdb->query($SQL))
			$LastScan .= sprintf(__("Cleared %s records from this log.",'gotmls'), $cleared);
//		else $LastScan .= $wpdb->last_error."<li>$SQL</li>";
	}
	$SQL = "SELECT substring_index(option_name, '/', -1) AS `mt`, option_name, option_value FROM `$wpdb->options` WHERE option_name LIKE 'GOTMLS_scan_log/%' ORDER BY mt DESC";
	if ($rs = $wpdb->get_results($SQL, ARRAY_A)) {
		$units = array("seconds"=>60,"minutes"=>60,"hours"=>24,"days"=>365,"years"=>10);
		$LastScan .= '<ul class="GOTMLS-scanlog GOTMLS-sidebar-links">';
		foreach ($rs as $row) {
			$LastScan .= "\n<li>";
			$GOTMLS_scan_log = (isset($row["option_name"])?get_option($row["option_name"], array()):array());
			if (isset($GOTMLS_scan_log["scan"]["type"]) && strlen($GOTMLS_scan_log["scan"]["type"]))
				$LastScan .= $GOTMLS_scan_log["scan"]["type"];
			else
				$LastScan .= "Unknown scan type";
			if (isset($GOTMLS_scan_log["scan"]["dir"]) && is_dir($GOTMLS_scan_log["scan"]["dir"]))
				$LastScan .= " of ".basename($GOTMLS_scan_log["scan"]["dir"]);
			if (isset($GOTMLS_scan_log["scan"]["start"]) && is_numeric($GOTMLS_scan_log["scan"]["start"])) {
				$time = (time() - $GOTMLS_scan_log["scan"]["start"]);
				$ukeys = array_keys($units);
				for ($unit = $ukeys[0], $key=0; (isset($units[$ukeys[$key]]) && $key < (count($ukeys) - 1) && $time >= $units[$ukeys[$key]]); $unit = $ukeys[++$key])
					$time = floor($time/$units[$ukeys[$key]]);
				if (1 == $time)
					$unit = substr($unit, 0, -1);
				$LastScan .= " started $time $unit ago";
				if (isset($GOTMLS_scan_log["scan"]["finish"]) && is_numeric($GOTMLS_scan_log["scan"]["finish"]) && ($GOTMLS_scan_log["scan"]["finish"] >= $GOTMLS_scan_log["scan"]["start"])) {
					$time = ($GOTMLS_scan_log["scan"]["finish"] - $GOTMLS_scan_log["scan"]["start"]);
					for ($unit = $ukeys[0], $key=0; (isset($units[$ukeys[$key]]) && $key < (count($ukeys) - 1) && $time >= $units[$ukeys[$key]]); $unit = $ukeys[++$key])
						$time = floor($time/$units[$ukeys[$key]]);
					if (1 == $time)
						$unit = substr($unit, 0, -1);
					$LastScan .= " and ran for $time $unit";
				} else
					$LastScan .= " and has not finish";
			} else
				$LastScan .= " failed to started";
			$LastScan .= '<a href="'.GOTMLS_script_URI.'&GOTMLS_cl='.$row["mt"].'">[clear log below this entry]</a></li>';
		}
		$LastScan .= '</ul>';
	} else
		$LastScan = '<h3>'.__("No Scans have been logged",'gotmls').'</h3>';
	return "$LastScan\n</form>\n";
}

function GOTMLS_get_whitelists() {
	$Q_Page = '
	<form method="POST" target="GOTMLS_iFrame" name="GOTMLS_Form_clean"><input type="hidden" id="GOTMLS_fixing" name="GOTMLS_fixing" value="1">';
	if (isset($GLOBALS["GOTMLS"]["tmp"]["definitions_array"]["whitelist"]) && is_array($GLOBALS["GOTMLS"]["tmp"]["definitions_array"]["whitelist"])) {
		$Q_Page .= '<ul name="found_Quarantine" id="found_Quarantine" class="GOTMLS_plugin known" style="background-color: #ccc; padding: 0;"><h3>'.__("Globally White-listed files",'gotmls').'<span class="GOTMLS_date">'.__("# of patterns",'gotmls').'</span><span class="GOTMLS_date">'.__("Date Updated",'gotmls').'</span></h3>';
		foreach ($GLOBALS["GOTMLS"]["tmp"]["definitions_array"]["whitelist"] as $file => $non_threats) {
			if (isset($non_threats[0])) {
				$updated = GOTMLS_sexagesimal($non_threats[0]);
				unset($non_threats[0]);
			} else
				$updated = "Unknown";
			$Q_Page .= '<li style="margin: 4px 12px;"><span class="GOTMLS_date">'.count($non_threats).'</span><span class="GOTMLS_date">'.$updated."</span>$file</li>\n";
			//if (is_array($non_threats) && count($non_threats))				$Q_Page .= print_r($non_threats, 1);
		}
		$Q_Page .= "</ul>";
	}
	if (isset($GLOBALS["GOTMLS"]["tmp"]["definitions_array"]["wp_core"]) && is_array($GLOBALS["GOTMLS"]["tmp"]["definitions_array"]["wp_core"])) {
		$Q_Page .= '<ul name="found_Quarantine" id="found_Quarantine" class="GOTMLS_plugin known" style="background-color: #ccc; padding: 0;"><h3>'.__("WP Core files",'gotmls').'<span class="GOTMLS_date">'.__("# of patterns",'gotmls').'</span><span class="GOTMLS_date">'.__("Date Updated",'gotmls').'</span></h3>';
		foreach ($GLOBALS["GOTMLS"]["tmp"]["definitions_array"]["wp_core"] as $file => $non_threats) {
			if (isset($non_threats[0])) {
				$updated = GOTMLS_sexagesimal($non_threats[0]);
				unset($non_threats[0]);
			} else
				$updated = "Unknown";
			$Q_Page .= "\n<li><span class=\"GOTMLS_date\">".count($non_threats)."</span><span class=\"GOTMLS_date\">$updated</span>$file</li>";
			if (is_array($non_threats) && count($non_threats))				$Q_Page .= print_r($non_threats, 1);
		}
		$Q_Page .= "</ul>";
	}
	return "$Q_Page\n</form>\n";
}

function GOTMLS_get_quarantine() {
	$entries = GOTMLS_getfiles($GLOBALS["GOTMLS"]["tmp"]["quarantine_dir"]);
	$Q_Page = '
	<form method="POST" target="GOTMLS_iFrame" name="GOTMLS_Form_clean"><input type="hidden" id="GOTMLS_fixing" name="GOTMLS_fixing" value="1">';
	if (is_array($entries) && ($key = array_search(".htaccess", $entries)))
		unset($entries[$key]);
	if (is_array($entries) && ($key = array_search("index.php", $entries)))
		unset($entries[$key]);
	if (is_array($entries) && count($entries)) {
		$Q_Page .= '<p id="fix_button" style="display: none; float: right;"><input id="repair_button" type="submit" value="'.__("Restore SELECTED files from Quarantine",'gotmls').'" class="button-primary" onclick="if (confirm(\''.__("Are you sure you want to overwrite the previously cleaned files with the selected files in the Quarantine?",'gotmls').'\')) { setvalAllFiles(1); loadIframe(\'File Restoration Results\'); } else return false;" /><br /><input id="delete_button" type="submit" class="button-primary" value="'.__("Delete SELECTED files from Quarantine",'gotmls').'" style="background-color: #C33; color: #FFF; background-image: linear-gradient(to bottom, #C22, #933); border-color: #933 #933 #900; box-shadow: 0 1px 0 rgba(230, 120, 120, 0.5) inset; text-decoration: none; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.1); margin-top: 10px;" onclick="if (confirm(\''.__("Are you sure you want to permanently delete the selected files in the Quarantine?",'gotmls').'\')) { setvalAllFiles(2); loadIframe(\'File Deletion Results\'); } else return false;" /></p><p><b>'.__("The following items have been found to contain malicious code, they have been cleaned, and the original infected file contents have been saved here in the Quarantine. The code is safe here and you do not need to do anything further with these files.",'gotmls').'</b></p><p>'.sprintf(__("FYI - these files are found in: %s",'gotmls'), ' '.$GLOBALS["GOTMLS"]["tmp"]["quarantine_dir"]).'</p>
		<ul name="found_Quarantine" id="found_Quarantine" class="GOTMLS_plugin known" style="background-color: #ccc; padding: 0;"><h3>'.(count($entries)>1?'<input type="checkbox" onchange="checkAllFiles(this.checked); document.getElementById(\'fix_button\').style.display = \'block\';"> '.sprintf(__("Check all %d",'gotmls'),count($entries)):"").__(" Items in Quarantine",'gotmls').'<span class="GOTMLS_date">Date Quarantined</span><span class="GOTMLS_date">Date Infected</span></h3>';
		sort($entries);
		$root_path = implode(GOTMLS_slash(), array_slice(GOTMLS_explode_dir(__file__), 0, (2 + intval($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_level"])) * -1));
		foreach ($entries as $entry) {
			$file = GOTMLS_trailingslashit($GLOBALS["GOTMLS"]["tmp"]["quarantine_dir"]).$entry;
			$filetime = date("Y-m-d H:i", filemtime($file));
			$Q_Page .= '
			<li style="margin: 4px 12px;"><span class="GOTMLS_date">'.$filetime.'</span>';
			$infectime = 'Unknown';
			if (is_file($file) && GOTMLS_get_ext($entry) == "gotmls") {
				$file_date = explode(".", $entry);
				if (count($file_date) > 2 && strlen($file_date[0]) == 5 && ($filetime != GOTMLS_sexagesimal($file_date[0])))
					$infectime = GOTMLS_sexagesimal($file_date[0]);
				elseif (count($file_date) > 3 && strlen($file_date[1]) == 5 && ($filetime != GOTMLS_sexagesimal($file_date[1])))
					$infectime = GOTMLS_sexagesimal($file_date[1]);
				elseif (@rename($file, GOTMLS_trailingslashit($GLOBALS["GOTMLS"]["tmp"]["quarantine_dir"]).GOTMLS_sexagesimal($filetime).".$entry"))
					$file = GOTMLS_trailingslashit($GLOBALS["GOTMLS"]["tmp"]["quarantine_dir"]).GOTMLS_sexagesimal($filetime).".$entry";
				$Q_Page .= '<span class="GOTMLS_date">'.$infectime.'</span><input type="checkbox" name="GOTMLS_fix[]" value="'.GOTMLS_encode($file).'" id="check_'.GOTMLS_encode($file).'" onchange="document.getElementById(\'fix_button\').style.display = \'block\';" /><img src="'.GOTMLS_images_path.'blocked.gif" height=16 width=16 alt="Q">'.preg_replace('/9000px;\&quot;>(.+?)<\/div>/', '9000px;&quot;>\1'.GOTMLS_strip4java(GOTMLS_decode($file_date[count($file_date)-2])).' (Quarantined)</div>', GOTMLS_error_link(__("View Quarantined File",'gotmls'), $file)).str_replace($root_path, "...", GOTMLS_decode($file_date[count($file_date)-2]));
			} else
				$Q_Page .= '<img src="'.GOTMLS_images_path.'threat.gif" height=16 width=16 alt="?">'.GOTMLS_error_link(__("Foreign File in Quarantine",'gotmls'), $file).$entry;
			$Q_Page .= "</a></li>\n";
		}
		$Q_Page .= "\n</ul>";
	} else
		$Q_Page .= '<h3>'.__("No Items in Quarantine",'gotmls').'</h3>';
	return "$Q_Page\n</form>\n";
}

function GOTMLS_View_Quarantine() {
	GOTMLS_display_header();
	echo GOTMLS_box($Q_Page = __("White-lists",'gotmls'), GOTMLS_get_whitelists());
	if (!isset($_GET['Whitelists']))
		echo "\n<script>\nshowhide('inside_".md5($Q_Page)."');\n</script>\n";
	echo GOTMLS_box($Q_Page = __("Quarantine",'gotmls'), GOTMLS_get_quarantine());
	if (isset($_GET['Scanlog']))
		echo "\n<script>\nshowhide('inside_".md5($Q_Page)."');\n</script>\n";
	echo GOTMLS_box(__("Scan Logs",'gotmls'), GOTMLS_get_scanlog());
	echo "\n</div></div></div>";
}

function GOTMLS_settings() {
	global $current_user, $wp_version, $GOTMLS_definitions_array, $GOTMLS_threat_levels, $GOTMLS_scanfiles, $GOTMLS_loop_execution_time, $GOTMLS_skip_dirs, $GOTMLS_dirs_at_depth, $GOTMLS_dir_at_depth;
	$GOTMLS_scan_groups = array();
	$dirs = GOTMLS_explode_dir(__file__);
	for ($SL=0;$SL<intval($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_level"]);$SL++)
		$GOTMLS_scan_groups[] = '<b>'.implode(GOTMLS_slash(), array_slice($dirs, -1 * (3 + $SL), 1)).'</b>';
	if (isset($_POST["check"]))
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check"] = $_POST["check"];
	if (isset($_POST["exclude_ext"])) {	
		if (strlen(trim(str_replace(",","",$_POST["exclude_ext"]).' ')) > 0)
			$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_ext"] = preg_split('/[\s]*([,]+[\s]*)+/', trim(str_replace('.', ',', $_POST["exclude_ext"])), -1, PREG_SPLIT_NO_EMPTY);
		else
			$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_ext"] = array();
	}
	if (isset($_GET["eli"]) && $_GET["eli"] == 'quarantine')
		$GLOBALS["GOTMLS"]["tmp"]["skip_ext"] = $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_ext"];
	else
		$GLOBALS["GOTMLS"]["tmp"]["skip_ext"] = array_merge($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_ext"], array("gotmls"));
	if (isset($_POST["exclude_dir"])) {
		if (strlen(trim(str_replace(",","",$_POST["exclude_dir"]).' ')) > 0)
			$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_dir"] = preg_split('/[\s]*([,]+[\s]*)+/', trim($_POST["exclude_dir"]), -1, PREG_SPLIT_NO_EMPTY);
		else
			$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_dir"] = array();
		for ($d=0; $d<count($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_dir"]); $d++)
			if (dirname($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_dir"][$d]) != ".")
				$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_dir"][$d] = str_replace("\\", "", str_replace("/", "", str_replace(dirname($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_dir"][$d]), "", $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_dir"][$d])));
	}
	$GOTMLS_skip_dirs = array_merge($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_dir"], $GOTMLS_skip_dirs);
	if (isset($_POST["scan_what"]) && is_numeric($_POST["scan_what"]) && $_POST["scan_what"] != $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_what"])
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_what"] = $_POST["scan_what"];
	if (isset($_POST["check_custom"]) && $_POST["check_custom"] != $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check_custom"])
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check_custom"] = stripslashes($_POST["check_custom"]);
	if (isset($_POST["scan_depth"]) && is_numeric($_POST["scan_depth"]) && $_POST["scan_depth"] != $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_depth"])
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_depth"] = $_POST["scan_depth"];
	if (isset($_POST['check_htaccess']) && is_numeric($_POST['check_htaccess']) && $_POST['check_htaccess'] != $GLOBALS["GOTMLS"]["tmp"]["settings_array"]['check_htaccess'])
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]['check_htaccess'] = $_POST['check_htaccess'];
	if (isset($_POST['check_timthumb']) && is_numeric($_POST['check_timthumb']) && $_POST['check_timthumb'] != $GLOBALS["GOTMLS"]["tmp"]["settings_array"]['check_timthumb'])
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]['check_timthumb'] = $_POST['check_timthumb'];
	if (isset($_POST['check_wp_login']) && is_numeric($_POST['check_wp_login']) && $_POST['check_wp_login'] != $GLOBALS["GOTMLS"]["tmp"]["settings_array"]['check_wp_login'])
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]['check_wp_login'] = $_POST['check_wp_login'];
	if (isset($_POST['check_known']) && is_numeric($_POST['check_known']) && $_POST['check_known'] != $GLOBALS["GOTMLS"]["tmp"]["settings_array"]['check_known'])
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]['check_known'] = $_POST['check_known'];
	if (isset($_POST['check_potential']) && is_numeric($_POST['check_potential']) && $_POST['check_potential'] != $GLOBALS["GOTMLS"]["tmp"]["settings_array"]['check_potential'])
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]['check_potential'] = $_POST['check_potential'];
	if (isset($_POST['skip_quarantine']) && $_POST['skip_quarantine'])
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]['skip_quarantine'] = $_POST['skip_quarantine'];
	elseif (isset($_POST["exclude_ext"]))
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]['skip_quarantine'] = 0;
	GOTMLS_update_scan_log(array("settings" => $GLOBALS["GOTMLS"]["tmp"]["settings_array"]));
	$scan_opts = '';
	$scan_optjs = "\n<script type=\"text/javascript\">\nfunction showOnly(what) {\n";
	foreach ($GOTMLS_scan_groups as $mg => $GOTMLS_scan_group) {
		$scan_optjs .= "document.getElementById('only$mg').style.display = 'none';\n";
		$scan_opts .= '
		<div style="position: relative; float: right; padding: 2px 0px 4px 30px;" id="scan_group_div_'.$mg.'"><input type="radio" name="scan_what" id="not-only'.$mg.'" value="'.$mg.'"'.($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_what"]==$mg?' checked':'').' /><a style="text-decoration: none;" href="#scan_what" onclick="showOnly(\''.$mg.'\');document.getElementById(\'not-only'.$mg.'\').checked=true;">'.$GOTMLS_scan_group.'</a><br />
			<div class="rounded-corners" style="position: absolute; display: none; background-color: #CCF; padding: 10px; z-index: 10;" id="only'.$mg.'"><div style="position: relative; padding: 0 40px 0 0;"><a class="rounded-corners" style="position: absolute; right: 0; margin: 0; padding: 0 4px; text-decoration: none; color: #C00; background-color: #FCC; border: solid #F00 1px;" href="#scan_what" onclick="showhide(\'only'.$mg.'\');">X</a><b>'.str_replace(" ", "&nbsp;", __("Only Scan These Folders:",'gotmls')).'</b></div>';
		$dir = implode(GOTMLS_slash(), array_slice($dirs, 0, -1 * (2 + $mg)));
		$files = GOTMLS_getfiles($dir);
		if (is_array($files))
			foreach ($files as $file)
				if (is_dir(GOTMLS_trailingslashit($dir).$file))
					$scan_opts .= '
					<br /><input type="checkbox" name="scan_only[]" value="'.$file.'" />'.$file;
		$scan_opts .= '
			</div>
		</div>';
	}
	$scan_optjs .= "document.getElementById('only'+what).style.display = 'block';\n}\n</script>";
	$scan_opts = '
	<form method="POST" name="GOTMLS_Form" action="'.str_replace('&mt=', '&last_mt=', str_replace('&scan_type=', '&last_type=', GOTMLS_script_URI)).'"><input type="hidden" name="scan_type" id="scan_type" value="Complete Scan" />
	<div style="float: left;"><b>'.__("What to scan:",'gotmls').'</b></div>
	<div style="float: left;">'.$scan_opts.$scan_optjs.'</div>
	<div style="float: left;" id="scanwhatfolder"></div><br style="clear: left;" />
	<p><b>'.__("Scan Depth:",'gotmls').'</b> ('.__("how far do you want to drill down from your starting directory?",'gotmls').')</p>
	<div style="padding: 0 30px;"><input type="text" value="'.$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_depth"].'" name="scan_depth"> ('.__("-1 is infinite depth",'gotmls').')</div><p><b>'.__("What to look for:",'gotmls').'</b></p>
	<div style="padding: 0 30px;">';
	foreach ($GOTMLS_threat_levels as $threat_level_name=>$threat_level) {
		$scan_opts .= '
		<div style="padding: 0; position: relative;" id="check_'.$threat_level.'_div">';
		if (isset($GOTMLS_definitions_array[$threat_level]))
			$scan_opts .= '
			<input type="checkbox" name="check[]" id="check_'.$threat_level.'_Yes" value="'.$threat_level.'"'.(in_array($threat_level,$GLOBALS["GOTMLS"]["log"]["settings"]["check"])?' checked':'').' /> <a style="text-decoration: none;" href="#check_'.$threat_level.'_div_0" onclick="document.getElementById(\'check_'.$threat_level.'_Yes\').checked=true;showhide(\'dont_check_'.$threat_level.'\');">';
		else
			$scan_opts .= '
			<a title="'.__("Download Definition Updates to Use this feature",'gotmls').'"><img src="'.GOTMLS_images_path.'blocked.gif" height=16 width=16 alt="X">';
		$scan_opts .= (isset($_GET["SESSION"]) && isset($_SESSION["GOTMLS_debug"][$threat_level])?print_r($_SESSION["GOTMLS_debug"][$threat_level],1):"")."<b>$threat_level_name</b></a>";
		if (!isset($GOTMLS_definitions_array[$threat_level]))
			$scan_opts .= '<br />
			<div style="padding: 14px;" id="check_'.$threat_level.'_div_NA">'.__("Registration of your Installation Key is required for this feature",'gotmls').'</div>';
		elseif (isset($_GET["SESSION"])) {
			$scan_opts .= '
			<div style="padding: 0 20px; position: relative; top: -18px; display: none;" id="dont_check_'.$threat_level.'"><a class="rounded-corners" style="position: absolute; left: 0; margin: 0; padding: 0 4px; text-decoration: none; color: #C00; background-color: #FCC; border: solid #F00 1px;" href="#check_'.$threat_level.'_div_0" onclick="showhide(\'dont_check_'.$threat_level.'\');">X</a>';
			foreach ($GOTMLS_definitions_array[$threat_level] as $threat_name => $threat_regex)
				$scan_opts .= '<br />
				<input type="checkbox" name="dont_check[]" value="'.htmlspecialchars($threat_name).'"'.(in_array($threat_name, $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["dont_check"])?' checked /><script>showhide("dont_check_'.$threat_level.'", true);</script>':' />').(isset($_SESSION["GOTMLS_debug"][$threat_name])?print_r($_SESSION["GOTMLS_debug"][$threat_name],1):"").$threat_name;
			$scan_opts .= '
			</div>';
		}
		$scan_opts .= '
		</div>';
	}
	if (isset($_GET["SESSION"]) && isset($_SESSION["GOTMLS_debug"]['total'])) {$scan_opts .= print_r($_SESSION["GOTMLS_debug"]['total'],1); unset($_SESSION["GOTMLS_debug"]);}
	if (isset($_GET["eli"])) {//still testing this option
		$scan_opts .= '
		<div style="padding: 10px;"><b>'.__("Custom RegExp:",'gotmls').'</b> ('.__("For very advanced users only. Do not use this without talking to Eli first. If used incorrectly you could easily break your site.",'gotmls').')<br /><input type="text" name="check_custom" style="width: 100%;" value="'.htmlspecialchars($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check_custom"]).'" /></div>';
	}
	$scan_opts .= '
	</div>
	<p>'.__("<b>Skip files with the following extentions:</b> (a comma separated list of file extentions to be excluded from the scan)",'gotmls').'</p>
	<div style="padding: 0 30px;"><input type="text" name="exclude_ext" value="'.implode(",", $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_ext"]).'" style="width: 100%;" /></div>
	<p>'.__("<b>Skip directories with the following names:</b> (a comma separated list of folders to be excluded from the scan)",'gotmls').'</p>
	<div style="padding: 0 30px;"><input type="text" name="exclude_dir" value="'.implode(",", $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_dir"]).'" style="width: 100%;" /></div>
	<p style="float: right;"><input type="submit" id="complete_scan" value="'.__("Run Complete Scan",'gotmls').'" class="button-primary" /></p>
	<p><b>'.GOTMLS_Skip_Quarantine_LANGUAGE.'</b> <input type="checkbox" name="skip_quarantine" value="1"'.((isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["skip_quarantine"]) && $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["skip_quarantine"])?" checked":"").'></p></form>';
	@ob_start();
	$OB_default_handlers = array("default output handler", "zlib output compression");
	$OB_handlers = @ob_list_handlers();
	if (is_array($OB_handlers) && count($OB_handlers))
		foreach ($OB_handlers as $OB_last_handler)
			if (!in_array($OB_last_handler, $OB_default_handlers))
				echo '<div class="error">'.sprintf(__("Another Plugin or Theme is using '%s' to handle output buffers. <br />This prevents actively outputing the buffer on-the-fly and will severely degrade the performance of this (and many other) Plugins. <br />Consider disabling caching and compression plugins (at least during the scanning process).",'gotmls'), $OB_last_handler).'</div>';
	GOTMLS_display_header();
	$scan_groups = array_merge(array(__("Scanned Files",'gotmls')=>"scanned",__("Selected Folders",'gotmls')=>"dirs",__("Scanned Folders",'gotmls')=>"dir",__("Skipped Folders",'gotmls')=>"skipdirs",__("Skipped Files",'gotmls')=>"skipped",__("Read/Write Errors",'gotmls')=>"errors",__("Quarantined Files",'gotmls')=>"bad"), $GOTMLS_threat_levels);
	echo '<script type="text/javascript">
var percent = 0;
function changeFavicon(percent) {
	var oldLink = document.getElementById("wait_gif");
	if (oldLink) {
		if (percent >= 100) {
			document.getElementsByTagName("head")[0].removeChild(oldLink);
			var link = document.createElement("link");
			link.id = "wait_gif";
			link.type = "image/gif";
			link.rel = "shortcut icon";
			var threats = '.implode(" + ", array_merge($GOTMLS_threat_levels, array(__("Potential Threats",'gotmls')=>"errors",__("WP-Login Updates",'gotmls')=>"errors"))).';
			if (threats > 0) {
				if ((errors * 2) == threats)
					linkhref = "blocked";
				else
					linkhref = "threat";
			} else
				linkhref = "checked";
			link.href = "'.GOTMLS_images_path.'"+linkhref+".gif";
			document.getElementsByTagName("head")[0].appendChild(link);
		}
	} else {
		var icons = document.getElementsByTagName("link");
		var link = document.createElement("link");
		link.id = "wait_gif";
		link.type = "image/gif";
		link.rel = "shortcut icon";
		link.href = "'.GOTMLS_images_path.'wait.gif";
	//	document.head.appendChild(link);
		document.getElementsByTagName("head")[0].appendChild(link);
	}
}
function update_status(title, time) {
	sdir = (dir+direrrors);
	if (arguments[2] >= 0 && arguments[2] <= 100)
		percent = arguments[2];
	else
		percent = Math.floor((sdir*100)/dirs);
	scan_state = "6F6";
	if (percent == 100) {
		showhide("pause_button", true);
		showhide("pause_button");
		title = "<b>'.__("Scan Complete!",'gotmls').'</b>";
	} else
		scan_state = "99F";
	changeFavicon(percent);
	if (sdir) {
		if (arguments[2] >= 0 && arguments[2] <= 100)
			timeRemaining = Math.ceil(((time-startTime)*(100/percent))-(time-startTime));
		else
			timeRemaining = Math.ceil(((time-startTime)*(dirs/sdir))-(time-startTime));
		if (timeRemaining > 59)
			timeRemaining = Math.ceil(timeRemaining/60)+" Minute";
		else
			timeRemaining += " Second";
		if (timeRemaining.substr(0, 2) != "1 ")
			timeRemaining += "s";
	} else
		timeRemaining = "Calculating Time";
	timeElapsed = Math.ceil(time);
	if (timeElapsed > 59)
		timeElapsed = Math.floor(timeElapsed/60)+" Minute";
	else
		timeElapsed += " Second";
	if (timeElapsed.substr(0, 2) != "1 ")
		timeElapsed += "s";
	divHTML = \'<div align="center" style="vertical-align: middle; background-color: #ccc; z-index: 3; height: 18px; width: 100%; border: solid #000 1px; position: relative; padding: 10px 0;"><div style="height: 18px; padding: 10px 0; position: absolute; top: 0px; left: 0px; background-color: #\'+scan_state+\'; width: \'+percent+\'%"></div><div style="height: 32px; position: absolute; top: 3px; left: 10px; z-index: 5; line-height: 16px;" align="left">\'+sdir+" Folder"+(sdir==1?"":"s")+" Checked<br />"+timeElapsed+\' Elapsed</div><div style="height: 38px; position: absolute; top: 0px; left: 0px; width: 100%; z-index: 5; line-height: 38px; font-size: 30px; text-align: center;">\'+percent+\'%</div><div style="height: 32px; position: absolute; top: 3px; right: 10px; z-index: 5; line-height: 16px;" align="right">\'+(dirs-sdir)+" Folder"+((dirs-sdir)==1?"":"s")+" Remaining<br />"+timeRemaining+" Remaining</div></div>";
	document.getElementById("status_bar").innerHTML = divHTML;
	document.getElementById("status_text").innerHTML = title;
	dis="none";
	divHTML = \'<ul style="float: right; margin: 0 20px; text-align: right;">\';'."\n/*<!--*"."/";
	$MAX = 0;
	$vars = "var i, intrvl, direrrors=0";
	$fix_button_js = "";
	$found = "";
	$li_js = "return false;";
	foreach ($scan_groups as $scan_name => $scan_group) {
		$vars .= ", $scan_group=0";
		if ($MAX++ == 6) {
			echo "/*-->*"."/\n\tif ($scan_group > 0)\n\t\tscan_state = ' potential'; \n\telse\n\t\tscan_state = '';\n\tdivHTML += '</ul><ul style=\"text-align: left;\"><li class=\"GOTMLS_li\"><a href=\"admin.php?page=GOTMLS-View-Quarantine\" class=\"GOTMLS_plugin".((isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["skip_quarantine"]) && $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["skip_quarantine"])?" potential\" title=\"".GOTMLS_Skip_Quarantine_LANGUAGE:"'+scan_state+'\" title=\"".GOTMLS_View_Quarantine_LANGUAGE)."\">'+$scan_group+'&nbsp;'+($scan_group==1?('$scan_name').slice(0,-1):'$scan_name')+'</a></li>';\n/*<!--*"."/";
			$found = "Found ";
			$fix_button_js = "\n\t\tdis='block';";
		} else {
			if ($found && !in_array($scan_group, $GLOBALS["GOTMLS"]["log"]["settings"]["check"]))
				$potential_threat = ' potential" title="'.__("You are not currently scanning for this type of threat!",'gotmls');
			else
				$potential_threat = "";
			echo "/*-->*"."/\n\tif ($scan_group > 0) {\n\t\tscan_state = ' href=\"#found_$scan_group\" onclick=\"$li_js showhide(\\'found_$scan_group\\', true);\" class=\"GOTMLS_plugin $scan_group\"';$fix_button_js".($MAX>6?"\n\tshowhide('found_$scan_group', true);":"")."\n\t} else\n\t\tscan_state = ' class=\"GOTMLS_plugin$potential_threat\"';\n\tdivHTML += '<li class=\"GOTMLS_li\"><a'+scan_state+'>$found'+$scan_group+'&nbsp;'+($scan_group==1?('$scan_name').slice(0,-1):'$scan_name')+'</a></li>';\n/*<!--*"."/";
		}
		$li_js = "";
		if ($MAX > 11)
			$fix_button_js = "";
	}
	echo "/*-->*".'/
	document.getElementById("status_counts").innerHTML = divHTML+"</ul>";
	document.getElementById("fix_button").style.display = dis;
}
'.$vars.';
function showOnly(what) {
	document.getElementById("only_what").innerHTML = document.getElementById("only"+what).innerHTML;
}
var startTime = 0;
</script>'.GOTMLS_box(GOTMLS_Scan_Settings_LANGUAGE, $scan_opts);
	if (isset($_REQUEST["scan_what"]) && is_numeric($_REQUEST["scan_what"]) && ($_REQUEST["scan_what"] > -1)) {
		if (!isset($_REQUEST["scan_type"]))
			$_REQUEST["scan_type"] = "Complete Scan";
		update_option('GOTMLS_settings_array', $GLOBALS["GOTMLS"]["tmp"]["settings_array"]);
		foreach ($_POST as $name => $value) {
			if (substr($name, 0, 10) != 'GOTMLS_fix') {
				if (is_array($value)) {
					foreach ($value as $val)
						echo '<input type="hidden" name="'.$name.'[]" value="'.htmlspecialchars($val).'">';
				} else
					echo '<input type="hidden" name="'.$name.'" value="'.htmlspecialchars($value).'">';
			}
		}
		echo '
	<form method="POST" target="GOTMLS_iFrame" name="GOTMLS_Form_clean"><input type="hidden" id="GOTMLS_fixing" name="GOTMLS_fixing" value="1">
	<script type="text/javascript">
		showhide("inside_'.md5(GOTMLS_Scan_Settings_LANGUAGE).'");
	</script>'.GOTMLS_box($_REQUEST["scan_type"].' Status', '<div id="status_text"><img src="'.GOTMLS_images_path.'wait.gif" height=16 width=16 alt="..."> '.GOTMLS_Loading_LANGUAGE.'</div><div id="status_bar"></div><p id="pause_button" style="display: none; position: absolute; left: 0; text-align: center; margin-left: -30px; padding-left: 50%;"><input type="button" value="Pause" class="button-primary" onclick="pauseresume(this);" id="resume_button" /></p><div id="status_counts"></div><p id="fix_button" style="display: none; text-align: center;"><input id="repair_button" type="submit" value="'.GOTMLS_Automatically_Fix_LANGUAGE.'" class="button-primary" onclick="loadIframe(\'Examine Results\');" /></p>');
		$scan_groups_UL = "";
		foreach ($scan_groups as $scan_name => $scan_group)
			$scan_groups_UL .= "\n<ul name=\"found_$scan_group\" id=\"found_$scan_group\" class=\"GOTMLS_plugin $scan_group\" style=\"background-color: #ccc; display: none; padding: 0;\"><a class=\"rounded-corners\" name=\"link_$scan_group\" style=\"float: right; padding: 0 4px; margin: 5px 5px 0 30px; line-height: 16px; text-decoration: none; color: #C00; background-color: #FCC; border: solid #F00 1px;\" href=\"#found_top\" onclick=\"showhide('found_$scan_group');\">X</a><h3>$scan_name</h3>\n".($scan_group=='potential'?'<p> &nbsp; * '.__("NOTE: These are probably not malicious scripts (but it's a good place to start looking <u>IF</u> your site is infected and no Known Threats were found).",'gotmls').'</p>':($scan_group=='wp_login'?'<p> &nbsp; * '.__("NOTE: Your WordPress Login page has the old version of my brute-force protection installed. Upgrade this patch to improve the protection on the WordPress Login page and preserve the integrity of your WordPress core files. For more information on brute force attack prevention and the WordPress wp-login-php file ",'gotmls').' <a target="_blank" href="http://gotmls.net/tag/wp-login-php/">'.__("read my blog",'gotmls').'</a>.</p>':'<br />')).'</ul>';
		if (!($dir = implode(GOTMLS_slash(), array_slice($dirs, 0, -1 * (2 + $_REQUEST["scan_what"]))))) $dir = "/";
		GOTMLS_update_scan_log(array("scan" => array("dir" => $dir, "start" => time(), "type" => $_REQUEST["scan_type"])));
		echo GOTMLS_box('<div style="float: right;">&nbsp;('.$GLOBALS["GOTMLS"]["log"]["scan"]["dir"].')&nbsp;</div>'.__("Scan Details:",'gotmls'), $scan_groups_UL);
		$no_flush_LANGUAGE = __("Not flushing OB Handlers: %s",'gotmls');
		if (isset($_REQUEST["no_ob_end_flush"]))
			echo '<div class="error">'.sprintf($no_flush_LANGUAGE, print_r(ob_list_handlers(), 1))."</div>\n";
		elseif (is_array($OB_handlers) && count($OB_handlers)) {
//			$GOTMLS_OB_handlers = get_option("GOTMLS_OB_handlers", array());
			foreach (array_reverse($OB_handlers) as $OB_handler) {
				if (isset($GOTMLS_OB_handlers[$OB_handler]) && $GOTMLS_OB_handlers[$OB_handler] == "no_end_flush")
					echo '<div class="error">'.sprintf($no_flush_LANGUAGE, $OB_handler)."</div>\n";
				elseif (in_array($OB_handler, $OB_default_handlers)) {
//					$GOTMLS_OB_handlers[$OB_handler] = "no_end_flush";
//					update_option("GOTMLS_OB_handlers", $GOTMLS_OB_handlers);
					@ob_end_flush();
//					$GOTMLS_OB_handlers[$OB_handler] = "ob_end_flush";
//					update_option("GOTMLS_OB_handlers", $GOTMLS_OB_handlers);
				}
			}
		}
		@ob_start();
		if ($_REQUEST["scan_type"] == "Quick Scan")
			$li_js = "\nfunction testComplete() {\n\tif (percent != 100)\n\t\talert('".__("The Quick Scan was unable to finish because of a shortage of memory or a problem accessing a file. Please try using the Complete Scan, it is slower but it will handle these errors better and continue scanning the rest of the files.",'gotmls')."');\n}\nwindow.onload=testComplete;\n</script>\n<script type=\"text/javascript\">";
		echo "\n<script type=\"text/javascript\">$li_js\n/*<!--*"."/";
		if (is_dir($dir)) {
			$GOTMLS_dirs_at_depth[0] = 1;
			$GOTMLS_dir_at_depth[0] = 0;
			if (!(isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]['skip_quarantine']) && $GLOBALS["GOTMLS"]["tmp"]["settings_array"]['skip_quarantine'])) {
				$GOTMLS_dirs_at_depth[0]++;
				GOTMLS_readdir($GLOBALS["GOTMLS"]["tmp"]["quarantine_dir"]);
			}
			if (isset($_POST['scan_only']) && is_array($_POST['scan_only'])) {
				$GOTMLS_dirs_at_depth[0] += (count($_POST['scan_only']) - 1);
				foreach ($_POST['scan_only'] as $only_dir)
					if (is_dir(GOTMLS_trailingslashit($dir).$only_dir))
						GOTMLS_readdir(GOTMLS_trailingslashit($dir).$only_dir);
			} else
				GOTMLS_readdir($dir);
		} else
			echo GOTMLS_return_threat("errors", "blocked", $dir, GOTMLS_error_link("Not a valid directory!"));
		if ($_REQUEST["scan_type"] == "Quick Scan")
			echo GOTMLS_update_status(__("Completed!",'gotmls'), 100);
		else {
			echo GOTMLS_update_status(__("Starting Scan ...",'gotmls'))."/*-->*"."/";
			echo "\nvar scriptSRC = '".GOTMLS_script_URI."&no_error_reporting&GOTMLS_scan=';\nvar scanfilesArKeys = new Array('".implode("','", array_keys($GOTMLS_scanfiles))."');\nvar scanfilesArNames = new Array('Scanning ".implode("','Scanning ", $GOTMLS_scanfiles)."');".'
var scanfilesI = 0;
var stopScanning;
var gotStuckOn = "";
function scanNextDir(gotStuck) {
clearTimeout(stopScanning);
if (gotStuck > -1) {
	if (scanfilesArNames[gotStuck].substr(0, 3) != "Re-") {
		if (scanfilesArNames[gotStuck].substr(0, 9) == "Checking ") {
			scanfilesArNames.push(scanfilesArNames[gotStuck]);
			scanfilesArKeys.push(scanfilesArKeys[gotStuck]+"&GOTMLS_skip_file[]="+encodeURIComponent(scanfilesArNames[gotStuck].substr(9)));
		} else {
			scanfilesArNames.push("Re-"+scanfilesArNames[gotStuck]);
			scanfilesArKeys.push(scanfilesArKeys[gotStuck]+"&GOTMLS_only_file=");
		}
	} else {
		scanfilesArNames.push("Got Stuck "+scanfilesArNames[gotStuck]);
		scanfilesArKeys.push(scanfilesArKeys[gotStuck]+"&GOTMLS_skip_dir="+scanfilesArKeys[gotStuck]);
	}
}
if (document.getElementById("resume_button").value != "Pause") {
	stopScanning=setTimeout("scanNextDir(-1)", 1000);
	startTime++;
}
else if (scanfilesI < scanfilesArKeys.length) {
	document.getElementById("status_text").innerHTML = scanfilesArNames[scanfilesI];
	var newscript = document.createElement("script");
	newscript.setAttribute("src", scriptSRC+scanfilesArKeys[scanfilesI]);
	divx = document.getElementById("found_scanned");
	if (divx)
		divx.appendChild(newscript);
	stopScanning=setTimeout("scanNextDir("+(scanfilesI++)+")",'.$GOTMLS_loop_execution_time.'000);
}
}
startTime = ('.ceil(time()-$GLOBALS["GOTMLS"]["log"]["scan"]["start"]).'+3);
stopScanning=setTimeout("scanNextDir(-1)",3000);
function pauseresume(butt) {
if (butt.value == "Resume")
	butt.value = "Pause";
else
	butt.value = "Resume";
}
showhide("pause_button", true);'."\n/*<!--*"."/";
		}
		if (@ob_get_level()) {
			GOTMLS_flush('script');
			@ob_end_flush();
		}
		echo "/*-->*"."/\n</script>";
	} else {
		$patch_attr = array(
			array(
				"icon" => "blocked",
				"language" => __("Your WordPress Login page is susceptible to a brute-force attack (just like any other login page). These types of attacks are becoming more prevalent these days and can sometimes cause your server to become slow or unresponsive, even if the attacks do not succeed in gaining access to your site. Applying this patch will block access to the WordPress Login page whenever this type of attack is detected."),
				"status" => 'Not Installed',
				"action" => 'Install Patch'
			),
			array(
				"language" => __("Your WordPress site has the current version of my brute-force Login protection installed."),
				"action" => 'Uninstall Patch',
				"status" => 'Enabled',
				"icon" => "checked"
			),
			array(
				"language" => __("Your WordPress Login page has the old version of my brute-force protection installed. Upgrade this patch to improve the protection on the WordPress Login page and preserve the integrity of your WordPress core files."),
				"action" => 'Upgrade Patch',
				"status" => 'Out of Date',
				"icon" => "threat"
			)
		);
		$patch_status = 0;
		$patch_found = -1;
		$patch_action = "";
		$find = "#if\s*\(([^\&]+\&\&)?\s*file_exists\((.+?)(safe-load|wp-login)\.php'\)\)\s*require(_once)?\((.+?)(safe-load|wp-login)\.php'\);#";
		$head = str_replace(array('#', '\\(', '\\)', '(_once)?', ')\\.', '\\s*', '(.+?)(', '|', '([^\\&]+\\&\\&)?'), array(' ', '(', ')', '_once', '.', ' ', '\''.dirname(__FILE__).'/', '/', '!in_array($_SERVER["REMOTE_ADDR"], array("'.$_SERVER["REMOTE_ADDR"].'")) &&'), $find);
		if (file_exists(dirname(__FILE__).'/../../../wp-config.php') && ($config = @file_get_contents(dirname(__FILE__).'/../../../wp-config.php')) && strlen($config) && ($patch_found = preg_match($find, $config))) {
			if (strpos($config, substr($head, strpos($head, "file_exists")))) {
				if (isset($_POST["GOTMLS_patching"]) && GOTMLS_file_put_contents(dirname(__FILE__).'/../../../wp-config.php', preg_replace('#<\?[ph\s]+(//.*\s*)*\?>#i', "", preg_replace($find, "", $config))))
					$patch_action .= '<div class="error">'.__("Removed Brute-Force Protection",'gotmls').'</div>';
				else
					$patch_status = 1;
			} else {
				if (isset($_POST["GOTMLS_patching"]) && GOTMLS_file_put_contents(dirname(__FILE__).'/../../../wp-config.php', preg_replace($find, "$head", $config))) {
					$patch_action .= '<div class="updated">'.__("Upgraded Brute-Force Protection",'gotmls').'</div>';
					$patch_status = 1;
				} else
					$patch_status = 2;
			}
		} elseif (isset($_POST["GOTMLS_patching"]) && strlen($config) && ($patch_found == 0) && GOTMLS_file_put_contents(dirname(__FILE__).'/../../../wp-config.php', "<?php$head// Load Brute-Force Protection by GOTMLS.NET before the WordPress bootstrap. ?>$config")) {
			$patch_action .= '<div class="updated">'.__("Installed Brute-Force Protection",'gotmls').'</div>';
			$patch_status = 1;
		}
		if (file_exists(dirname(__FILE__).'/../../../wp-login.php') && ($login = @file_get_contents(dirname(__FILE__).'/../../../wp-login.php')) && strlen($login) && (preg_match($find, $login))) {
			if (isset($_POST["GOTMLS_patching"]) && ($source = wp_remote_get("http://core.svn.wordpress.org/tags/".$wp_version.'/wp-login.php')) && is_array($source) && isset($source["body"]) && (strlen($source["body"]) > 500) && GOTMLS_file_put_contents(dirname(__FILE__).'/../../../wp-login.php', $source["body"]))
				$patch_action .= '<div class="updated">'.__("Removed Old Brute-Force Login Patch",'gotmls').'</div>';
			else
				$patch_status = 2;
		}
		$js = GOTMLS_encode("\nif(stopSettingSession)\n\tclearTimeout(stopSettingSession);\nif(stopCheckingSession)\n\tclearTimeout(stopCheckingSession);\nshowhide('GOTMLS_patch_searching', true);\nshowhide('GOTMLS_patch_searching');\nshowhide('GOTMLS_patch_button', true);\n");
		$sec_opts = '
		<p><img src="'.GOTMLS_images_path.'checked.gif"><b>Revolution Slider Exploit Protection (Automatically Enabled)</b></p><div style="padding: 0 30px;">'.__("This protection is automatically activated with this plugin because of the widespread attack on WordPress that are affecting so many site right now. It is still recommended that you make sure to upgrade and older versions of the Revolution Slider plugin, especially those included in some themes that will not update automatically. Even if you do not have Revolution Slider on your site it still can't hurt to have this protection installed.",'gotmls').'</div><hr />
		'.$patch_action.'
		<form method="POST" name="GOTMLS_Form_patch"><p style="float: right;"><input type="submit" value="'.$patch_attr[$patch_status]["action"].'" style="'.($patch_status?'">':' display: none;" id="GOTMLS_patch_button"><div id="GOTMLS_patch_searching" style="float: right;">'.__("Checking for session compatibility ...",'gotmls').' <img src="'.GOTMLS_images_path.'wait.gif" height=16 width=16 alt="Wait..." /></div>').'<input type="hidden" name="GOTMLS_patching" value="1"></p><p><img src="'.GOTMLS_images_path.$patch_attr[$patch_status]["icon"].'.gif"><b>Brute-force Protection '.$patch_attr[$patch_status]["status"].'</b></p><div style="padding: 0 30px;"> &nbsp; * '.$patch_attr[$patch_status]["language"].__(" For more information on Brute-Force attack prevention and the WordPress wp-login-php file ",'gotmls').' <a target="_blank" href="http://gotmls.net/tag/wp-login-php/">'.__("read my blog",'gotmls').'</a>.</div></form>
		<script type="text/javascript">
		stopSettingSession = checkupdateserver("'.GOTMLS_images_path.'session.js?test='.$js.'", "GOTMLS_patch_searching");
		stopCheckingSession = checkupdateserver("'.GOTMLS_images_path.'session.js?test='.$js.'", "GOTMLS_patch_searching");
		</script>';
		$admin_notice = "";
		if ($current_user->user_login == "admin") {
			$admin_notice .= '<hr />
			<form method="POST" name="GOTMLS_Form_admin"><p><img src="'.GOTMLS_images_path.'threat.gif"><b>Admin Notice</b></p><div style="padding: 0 30px;">Your username is "admin", this is the most commonly guessed username by hackers and brute-force scripts. It is highly recommended that you change your username immediately.</div></form>';
		}
		echo GOTMLS_box("Firewall Options", $sec_opts.$admin_notice);
	}
	echo "\n</div></div></div>";
}

function GOTMLS_set_plugin_action_links($links_array, $plugin_file) {
	if ($plugin_file == substr(__file__, (-1 * strlen($plugin_file))) && strlen($plugin_file) > 10)
		$links_array = array_merge(array('<a href="admin.php?page=GOTMLS-settings&scan_type=Quick+Scan">'.GOTMLS_Run_Quick_Scan_LANGUAGE.'</a>', '<a href="admin.php?page=GOTMLS-settings">'.GOTMLS_Scan_Settings_LANGUAGE.'</a>'), $links_array);
	return $links_array;
}

function GOTMLS_set_plugin_row_meta($links_array, $plugin_file) {
	if ($plugin_file == substr(__file__, (-1 * strlen($plugin_file))) && strlen($plugin_file) > 10)
		$links_array = array_merge($links_array, array('<a target="_blank" href="http://gotmls.net/faqs/">FAQ</a>','<a target="_blank" href="http://gotmls.net/support/">Support</a>','<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZHD8QHZ2E7PE">Donate</a>'));
	return $links_array;
}

function GOTMLS_init() {
	global $GOTMLS_update_home, $GOTMLS_onLoad, $GOTMLS_threat_levels, $wpdb, $GOTMLS_threats_found, $GOTMLS_definitions_array, $GOTMLS_file_contents;
	if (!isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_what"]))
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_what"] = 2;
	if (!isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_depth"]))
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_depth"] = -1;
	if (isset($_REQUEST["scan_type"]) && $_REQUEST["scan_type"] == "Quick Scan") {
		if (!isset($_REQUEST["scan_what"]))	$_REQUEST["scan_what"] = 2;
		if (!isset($_REQUEST["scan_depth"]))
			$_REQUEST["scan_depth"] = 2;
		if (!(isset($_POST["scan_only"]) && is_array($_POST["scan_only"])))
			$_POST["scan_only"] = array("","wp-content/plugins","wp-content/themes");
	}//$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check_custom"] = stripslashes($_POST["check_custom"]);
	if (!isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check_custom"]))
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check_custom"] = "";
	if (isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_level"]) && is_numeric($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_level"]))
		$scan_level = intval($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_level"]);
	else
		$scan_level = count(explode('/', trailingslashit(get_option("siteurl")))) - 1;
	if (!(isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["dont_check"]) && is_array($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["dont_check"])))
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["dont_check"] = array();
	if (isset($_REQUEST["dont_check"]) && is_array($_REQUEST["dont_check"]) && count($_REQUEST["dont_check"]))
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["dont_check"] = $_REQUEST["dont_check"];
	if ($array = get_option('GOTMLS_definitions_array')) {
		if (is_array($array))
			$GOTMLS_definitions_array = $array;
	} else {
		$wpdb->query("DELETE FROM $wpdb->options WHERE `option_name` LIKE 'GOTMLS_known_%' OR `option_name` LIKE 'GOTMLS_definitions_array_%'");
		array_walk($GLOBALS["GOTMLS"]["tmp"]["settings_array"], "GOTMLS_reset_settings");
	}
	$GOTMLS_definitions_versions = array();
	foreach ($GOTMLS_definitions_array as $threat_level=>$definition_names)
		foreach ($definition_names as $definition_name=>$definition_version)
			if (is_array($definition_version))
				if (!isset($GOTMLS_definitions_versions[$threat_level]) || $definition_version[0] > $GOTMLS_definitions_versions[$threat_level])
					$GOTMLS_definitions_versions[$threat_level] = $definition_version[0];
	if (isset($_POST["UPDATE_definitions_array"])) {
		$GOTnew_definitions = maybe_unserialize(GOTMLS_decode($_POST["UPDATE_definitions_array"]));
		$GOTMLS_onLoad .= "updates_complete('Downloaded Definitions');";
	} elseif (isset($GOTMLS_definitions_array["wp_login"]["brute force possible on wp-login.php"]) && is_array($GOTMLS_definitions_array["wp_login"]["brute force possible on wp-login.php"]) && count($GOTMLS_definitions_array["wp_login"]["brute force possible on wp-login.php"]) == 2 && $GOTMLS_definitions_array["wp_login"]["brute force possible on wp-login.php"][0] == "D4OAB")
		$GOTnew_definitions["wp_login"]["brute force possible on wp-login.php"] = array("D4OAC",'/if \(file_exists\(.+?(\/plugins\/gotmls\/safe-load\.php\')[\)\s]+require\(.+?\1\);/i');
	//elseif (file_exists(GOTMLS_plugin_path.'definitions_update.txt'))	$GOTnew_definitions = maybe_unserialize(GOTMLS_decode(file_get_contents(GOTMLS_plugin_path.'definitions_update.txt')));
	if (isset($GOTnew_definitions) && is_array($GOTnew_definitions)) {
		$GOTMLS_definitions_array = GOTMLS_array_replace_recursive($GOTMLS_definitions_array, $GOTnew_definitions);	
		if (file_exists(GOTMLS_plugin_path.'definitions_update.txt'))
			@unlink(GOTMLS_plugin_path.'definitions_update.txt');
		if (isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check"]))
			unset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check"]);
		update_option('GOTMLS_definitions_array', $GOTMLS_definitions_array);
		foreach ($GOTMLS_definitions_array as $threat_level=>$definition_names)
			foreach ($definition_names as $definition_name=>$definition_version)
				if (is_array($definition_version))
					if (!isset($GOTMLS_definitions_versions[$threat_level]) || $definition_version[0] > $GOTMLS_definitions_versions[$threat_level])
						$GOTMLS_definitions_versions[$threat_level] = $definition_version[0];
	}
	asort($GOTMLS_definitions_versions);
	$GLOBALS["GOTMLS"]["tmp"]["Definition"]["Updates"] = '?div=Definition_Updates';
	foreach ($GOTMLS_definitions_versions as $definition_name=>$GLOBALS["GOTMLS"]["tmp"]["Definition"]["Latest"])
		$GLOBALS["GOTMLS"]["tmp"]["Definition"]["Updates"] .= "&ver[$definition_name]=".$GLOBALS["GOTMLS"]["tmp"]["Definition"]["Latest"];
	if (isset($_REQUEST["check"]) && is_array($_REQUEST["check"]))
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check"] = $_REQUEST["check"];
/*	$threat_names = array_keys($GOTMLS_definitions_array["known"]);
	foreach ($threat_names as $threat_name) {
		if (isset($GOTMLS_definitions_array["known"][$threat_name]) && is_array($GOTMLS_definitions_array["known"][$threat_name]) && count($GOTMLS_definitions_array["known"][$threat_name]) > 1) {
			if ($GOTMLS_definitions_array["known"][$threat_name][0] > $GOTMLS_definitions_version)
				$GOTMLS_definitions_version = $GOTMLS_definitions_array["known"][$threat_name][0];
			if (!(count($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["dont_check"]) && in_array($threat_name, $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["dont_check"]))) {
				$GOTMLS_threat_levels[$threat_name] = count($GOTMLS_definitions_array["known"][$threat_name]);
				if (!isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check"]) && $GOTMLS_threat_levels[$threat_name] > 2)
					$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check"] = "known";
			}
		}
	}*/
	if (!isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check"]))
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["check"] = $GOTMLS_threat_levels;
	if (isset($_POST["GOTMLS_fix"]) && !is_array($_POST["GOTMLS_fix"]))
		$_POST["GOTMLS_fix"] = array($_POST["GOTMLS_fix"]);
	GOTMLS_update_scan_log(array("settings" => $GLOBALS["GOTMLS"]["tmp"]["settings_array"]));
	if (isset($_POST['GOTMLS_whitelist']) && isset($_POST['GOTMLS_chksum'])) {
		$file = GOTMLS_decode($_POST['GOTMLS_whitelist']);
		$chksum = explode("O", $_POST['GOTMLS_chksum']."O");
		if (strlen($chksum[0]) == 32 && strlen($chksum[1]) == 32 && is_file($file) && md5(@file_get_contents($file)) == $chksum[0]) {
			$filesize = @filesize($file);
			if (true) {
				if (!isset($GOTMLS_definitions_array["whitelist"][$file][0]))
					$GOTMLS_definitions_array["whitelist"][$file][0] = "A0002";
				$GOTMLS_definitions_array["whitelist"][$file][$chksum[0].'O'.$filesize] = "A0002";
			} else
				unset($GOTMLS_definitions_array["whitelist"][$file]);
			update_option("GOTMLS_definitions_array", $GOTMLS_definitions_array);
			die("<html><body>Added $file to Whitelist!<br /><iframe style='width: 90%; height: 350px;' src='$GOTMLS_update_home?whitelist=".$_POST['GOTMLS_whitelist']."&hash=$chksum[0]&size=$filesize&key=$chksum[1]'></iframe></body></html>");
		} else echo "<li>Invalid Data!</li>";
	} elseif (isset($_GET["GOTMLS_scan"])) {
		$file = GOTMLS_decode($_GET["GOTMLS_scan"]);
		if (is_dir($file)) {
			@error_reporting(0);
			@header("Content-type: text/javascript");
			if (isset($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_ext"]) && is_array($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_ext"]))
				$GLOBALS["GOTMLS"]["tmp"]["skip_ext"] = $GLOBALS["GOTMLS"]["tmp"]["settings_array"]["exclude_ext"];
			@ob_start();
			echo GOTMLS_scandir($file);
			if (@ob_get_level()) {
				GOTMLS_flush();
				@ob_end_flush();
			}
			die('//END OF JavaScript');
		} else {
			if (!file_exists($file))
				die(sprintf(__("The file %s does not exist.",'gotmls'), $file)."<br />\n".(file_exists(GOTMLS_quarantine($file))?sprintf(__("You could <a %s>try viewing the quarantined backup file</a>.",'gotmls'), 'target="GOTMLS_iFrame" href="'.GOTMLS_script_URI.'&GOTMLS_scan='.GOTMLS_encode(GOTMLS_quarantine($file)).'"'):__("The file must have already been delete.",'gotmls'))."<script type=\"text/javascript\">\nwindow.parent.showhide('GOTMLS_iFrame', true);\n</script>");
			else {
				$clean_file = $file;
				if (GOTMLS_get_ext($file) == 'gotmls' && dirname($file) == dirname(GOTMLS_quarantine($file))) {
					$clean_file = 'Quarantined: '.GOTMLS_decode(array_pop(explode(".", '.'.substr($file, strlen(dirname($file))+1, -7))));
					$_GET["eli"] = "quarantine";
				}
				GOTMLS_scanfile($file);
				$fa = "";
				$function = 'GOTMLS_decode';
				$decode_list = array("Base64" => '/base64_decode\([\'"]([0-9\+\/\=a-z]+)[\'"]\)/', "Hex" => '/(\\\\x[0-9a-f]{2})/');
				if (isset($_GET[$function]) && is_array($_GET[$function])) {
					foreach ($_GET[$function] as $decode) {
						if (isset($decode_list[$decode])) {
							$GOTMLS_file_contents = preg_replace($decode_list[$decode].substr($GLOBALS["GOTMLS"]["tmp"]["default_ext"], 0, 2), $function.$decode.'("\1")',  $GOTMLS_file_contents);
							$fa .= " $decode decoded";
						} else
							$fa .= " NO-$decode";
					}
				} elseif (isset($GOTMLS_threats_found) && is_array($GOTMLS_threats_found) && count($GOTMLS_threats_found)) {
					$f = 1;
					foreach ($GOTMLS_threats_found as $threats_found=>$threats_name) {
						$fpos = 0;
						$flen = 0;
						$potential_threat = str_replace("\r", "", $threats_found);
						while (($fpos = strpos(str_replace("\r", "", $GOTMLS_file_contents), ($potential_threat), $flen + $fpos)) !== false) {
							$flen = strlen($potential_threat);
							$fa .= ' <a title="'.htmlspecialchars($threats_name).'" href="javascript:select_text_range(\'ta_file\', '.($fpos).', '.($fpos + $flen).');">['.$f++.']</a>';
						}
						if (0 == $flen)
							$fa = 'ERROR['.($f++).']: Threat_size{'.strlen($potential_threat).'} } Content_size{'.strlen(str_replace("\r", "", $GOTMLS_file_contents)).'}';
					}
				} else
					$fa = " No Threats Found";
				foreach ($decode_list as $decode => $regex)
					if (preg_match($regex.substr($GLOBALS["GOTMLS"]["tmp"]["default_ext"], 0, 1),  $GOTMLS_file_contents))
						$fa .= ' <a href="'.GOTMLS_script_URI.'&'.$function.'[]='.$decode.'">decode['.$decode.']</a>';
				die("\n".'<script type="text/javascript">
function select_text_range(ta_id, start, end) {
	ta_element = document.getElementById(ta_id);
	ta_element.focus();
	if(ta_element.setSelectionRange)
	   ta_element.setSelectionRange(start, end);
	else {
	   var r = ta_element.createTextRange();
	   r.collapse(true);
	   r.moveEnd(\'character\', end);
	   r.moveStart(\'character\', start);
	   r.select();   
	}
}
window.parent.showhide("GOTMLS_iFrame", true);
</script><table style="top: 0px; left: 0px; width: 100%; height: 100%; position: absolute;"><tr><td style="width: 100%"><form style="margin: 0;" method="post"'.(is_file($clean_file)?' onsubmit="return confirm(\''.__("Are you sure this file is not infected and you want to ignore it in future scans?",'gotmls').'\');"><input type="hidden" name="GOTMLS_whitelist" value="'.GOTMLS_encode($clean_file).'"><input type="hidden" name="GOTMLS_chksum" value="'.md5($GOTMLS_file_contents).'O'.GOTMLS_installation_key.'"><input type="submit" value="Whitelist this file" style="float: right;">':(is_file(GOTMLS_quarantine($clean_file))?' >':'>')).'</form><div id="fileperms" class="shadowed-box rounded-corners" style="display: none; position: absolute; left: 8px; top: 29px; background-color: #ccc; border: medium solid #C00; box-shadow: -3px 3px 3px #666; border-radius: 10px; padding: 10px;"><b>File Details</b><br />encoding:'.mb_detect_encoding($GOTMLS_file_contents).'<br />permissions:'.GOTMLS_fileperms($file).'<br />modified:'.date(" Y-m-d H:i:s ", filemtime($file)).'<br />changed:'.date(" Y-m-d H:i:s ", filectime($file)).'</div><div style="overflow: auto;"><span onmouseover="document.getElementById(\'fileperms\').style.display=\'block\';" onmouseout="document.getElementById(\'fileperms\').style.display=\'none\';">'.__("Potential threats in file:",'gotmls').'</span> ('.$fa.' )</div></td></tr><tr><td style="height: 100%"><textarea id="ta_file" style="width: 100%; height: 100%">'.htmlentities(str_replace("\r", "", $GOTMLS_file_contents)).'</textarea></td></tr></table>');
			}
		}
	} elseif (isset($_POST['GOTMLS_fix']) && is_array($_POST['GOTMLS_fix'])) {
		$callAlert = "clearTimeout(callAlert);\ncallAlert=setTimeout('alert_repaired(1)', 30000);";
		$li_js = "\n<script type=\"text/javascript\">\nvar callAlert;\nfunction alert_repaired(failed) {\nclearTimeout(callAlert);\nif (failed)\nfilesFailed='the rest, try again to change more.';\nwindow.parent.check_for_donation('Changed '+filesFixed+' files, failed to change '+filesFailed);\n}\n$callAlert\nwindow.parent.showhide('GOTMLS_iFrame', true);\nfilesFixed=0;\nfilesFailed=0;\nfunction fixedFile(file) {\n filesFixed++;\nwindow.parent.document.getElementById('list_'+file).className='GOTMLS_plugin';\nwindow.parent.document.getElementById('check_'+file).checked=false;\n }\n function failedFile(file) {\n filesFailed++;\nwindow.parent.document.getElementById('check_'+file).checked=false; \n}\n</script>\n<script type=\"text/javascript\">\n/*<!--*"."/";
		foreach ($_POST["GOTMLS_fix"] as $path) {
			if (file_exists(GOTMLS_decode($path))) {
				echo '<li>fixing '.GOTMLS_decode($path).' ...';
				$li_js .= GOTMLS_scanfile(GOTMLS_decode($path));
				echo "</li>\n$li_js/*-->*"."/\n$callAlert\n</script>\n";
				$li_js = "<script type=\"text/javascript\">\n/*<!--*"."/";
			}
		}
		die('<div id="check_site_warning" style="background-color: #F00;">'.sprintf(__("Because some threats were automatically fixed we need to check to make sure the removal did not break your site. If this stays Red and the frame below does not load please <a %s>revert the changes</a> made during the automated fix process.",'gotmls'), 'target="test_frame" href="admin.php?page=GOTMLS-View-Quarantine"').' <span style="color: #F00;">'.__("Never mind, it worked!",'gotmls').'</span></div><br /><iframe id="test_frame" name="test_frame" src="'.GOTMLS_script_URI.'&check_site=1" style="width: 100%; height: 200px"></iframe>'.$li_js."/*-->*"."/\nalert_repaired(0);\n</script>\n");
	} elseif (isset($_POST["GOTMLS_fixing"]))
		die("<script type=\"text/javascript\">\nwindow.parent.showhide('GOTMLS_iFrame', true);\nalert('".__("Nothing Selected to be Changed!",'gotmls')."');\n</script>".__("Done!",'gotmls'));
	if (isset($_POST["scan_level"]) && is_numeric($_POST["scan_level"]))
		$scan_level = intval($_POST["scan_level"]);
	if (isset($scan_level) && is_numeric($scan_level))
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_level"] = intval($scan_level);
	else
		$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["scan_level"] = count(explode('/', trailingslashit(get_option("siteurl")))) - 1;
	if (isset($_GET["GOTMLS_x"]) || isset($_GET["GOTMLS_y"]) || isset($_GET["GOTMLS_h"]) || isset($_GET["GOTMLS_w"])) {
		if (isset($_GET["GOTMLS_x"]))
			$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][0] = $_GET["GOTMLS_x"];
		if (isset($_GET["GOTMLS_y"]))
			$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][1] = $_GET["GOTMLS_y"];
		if (isset($_GET["GOTMLS_h"]))
			$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][2] = $_GET["GOTMLS_h"];
		if (isset($_GET["GOTMLS_w"]))
			$GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"][3] = $_GET["GOTMLS_w"];
		$_GET["GOTMLS_msg"] = "New window position saved. ";//.print_r($GLOBALS["GOTMLS"]["tmp"]["settings_array"]["msg_position"], true);
	}
	update_option('GOTMLS_settings_array', $GLOBALS["GOTMLS"]["tmp"]["settings_array"]);
	if (isset($_GET["GOTMLS_msg"]))
		die('<body style="margin: 0; padding: 0;">'.$_GET["GOTMLS_msg"].'</body>');
}

if (function_exists("is_admin") && is_admin() && ((isset($_POST['GOTMLS_whitelist']) && isset($_POST['GOTMLS_chksum'])) || (isset($_GET["GOTMLS_scan"]) && is_dir(GOTMLS_decode($_GET["GOTMLS_scan"]))))) {
	@set_time_limit($GOTMLS_loop_execution_time-5);
	GOTMLS_loaded();
	GOTMLS_init();
	die("\n//PHP to Javascript Error!\n");
} else {
	add_filter("plugin_row_meta", "GOTMLS_set_plugin_row_meta", 1, 2);
	add_filter("plugin_action_links", "GOTMLS_set_plugin_action_links", 1, 2);
	add_action("plugins_loaded", "GOTMLS_loaded");
	add_action("admin_notices", "GOTMLS_admin_notices");
	add_action("admin_menu", "GOTMLS_menu");
	add_action("network_admin_menu", "GOTMLS_menu");
	$init = add_action("admin_init", "GOTMLS_init");
}