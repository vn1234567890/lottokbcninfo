<?php
/*
Plugin Name: Google authorship for multiple authors
Plugin URI: https://www.keywordstrategy.org/extras/authorship-plugin/
Description: Adds writer's icon in the Google search results
Version: 1.5.0
Author: Keyword Strategy
Author URI: http://www.keywordstrategy.org/
License: GPL2
*/

/*  Copyright 2011  Keyword Strategy  (email : info@keywordstrategy.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


add_action('single_template', 'google_authorship_single');
function google_authorship_single()
{
	global $google_authorship_single;
	$google_authorship_single = true;
}


function google_authorship_get_code()
{
	global $post;
	if (! $post || ! $post->post_author) return false;
	$width = google_authorship_get_width($post->post_author);
	$profile_url = get_user_meta($post->post_author, 'google_authorsihp_url', true);
	$code = '
<script type="text/javascript">
window.___gcfg = {lang: \'en\'};
(function() 
{var po = document.createElement("script");
po.type = "text/javascript"; po.async = true;po.src = "https://apis.google.com/js/plusone.js";
var s = document.getElementsByTagName("script")[0];
s.parentNode.insertBefore(po, s);
})();</script>
	<g:plus href="'.htmlspecialchars($profile_url).'" rel="author" width="'.$width.'" height="69"></g:plus>
';
	$code = apply_filters('google_authorship_code', $code, $profile_url, $width);
	return $code;
}

add_action('the_content', 'google_authorship_content', 5);
function google_authorship_content($content)
{
	global $google_authorship_single, $post;
	if ($google_authorship_single)
	{
		$profile_url = get_user_meta($post->post_author, 'google_authorsihp_url', true);
		if ($profile_url)
		{
			$location = google_authorship_get_location($post->post_author);
			if ($location == 'top' || $location == 'bottom')
			{
				$badge_code = google_authorship_get_code();
				if ($location == 'top')
				{
					$content = $badge_code . $content;
				}
				else
				{
					$content = $content . $badge_code;
				}
			}
			else if ($location == 'hidden')
			{
				$content .= '
					<div style="display:none;"><a href="'. htmlspecialchars($profile_url.'?rel=author') .'">My Google+ profile</a></div>
';
			}
		}
	}
	return $content;
}


function google_authorship_get_location($user_id)
{
	$value = get_user_meta($user_id, 'google_authorship_location', true);
	if (! $value) $value = 'bottom';
	return $value;
}
function google_authorship_get_width($user_id)
{
	$value = intval(get_user_meta($user_id, 'google_authorship_width', true));
	if (! $value) $value = 400;
	else if ($value < 100) $value = 100;
	return $value;
}

add_action('show_user_profile', 'google_authorship_user_profile');
add_action('edit_user_profile', 'google_authorship_user_profile');
function google_authorship_user_profile($user)
{
	$authorship_profile_url = get_user_meta($user->ID, 'google_authorsihp_url', true);
	$authorship_width = google_authorship_get_width($user->ID);
	$authorship_location = google_authorship_get_location($user->ID);
	$locations = array(
		'top' => 'Top of the page',
		'bottom' => 'Bottom of the page',
		'hidden' => 'Hidden',
		'disabled' => 'Disabled',
	);
	?>
	<a href="#" name="google_authorship_area"></a>
	<h3>Google Authorship area</h3>
	<table class="form-table">
		<tr>
			<th><label for="google_authorship_url">Google+ profile URL</label></th>
			<td>
				<input value="<?php echo htmlspecialchars($authorship_profile_url); ?>" class="regular-text" type="text" name="google_authorship_url" id="google_authorship_url" />
				<br />
				<span class="description">Link to your Google Plus profile, for example: https://plus.google.com/104560124403688998123/</span>
				<br />
				You can find more information about authorship plugin <a href="https://www.keywordstrategy.org/extras/authorship-plugin/" target="_blank">here</a>.
			</td>
		</tr>
		<tr>
			<th><label for="google_authorship_location">Location</label></th>
			<td>
				<select id="google_authorship_location" name="google_authorship_location">
					<?php foreach ($locations AS $value => $name): ?>
					<option <?php if ($value == $authorship_location) {echo 'selected="selected"';} ?> value="<?php echo $value; ?>"><?php echo $name; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="google_authorship_width">Width</label></th>
			<td>
			<input value="<?php echo htmlspecialchars($authorship_width) ?>" type="text" name="google_authorship_width" id="google_authorship_width" />
			</td>
		</tr>
	</table>
	<?php
}

add_action('personal_options_update', 'google_authorship_profile_update');
add_action('edit_user_profile_update', 'google_authorship_profile_update');
function google_authorship_profile_update($user_id)
{
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	update_user_meta( $user_id, 'google_authorsihp_url', ($_POST['google_authorship_url']));
	update_user_meta( $user_id, 'google_authorship_location', ($_POST['google_authorship_location']));
	update_user_meta( $user_id, 'google_authorship_width', ($_POST['google_authorship_width']));
}

add_filter('plugin_action_links', 'google_authorship_plugin_action_links', 10, 2);
function google_authorship_plugin_action_links($links, $file)
{
	if ($file == plugin_basename(dirname(__FILE__).'/google-authorship.php'))
	{
		$settings_location =  get_admin_url(null, 'profile.php#google_authorship_area');
		array_unshift($links, '<a href="'.$settings_location.'">'.__('Settings').'</a>');
	}

	return $links;
}
