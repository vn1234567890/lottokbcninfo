<?php function pbseo_meta_panel() { global $post; echo "<div id=\"pbseo_meta_wrapper\">"; wp_nonce_field(plugin_basename( __FILE__),pb1lf); $pb1O5h= isset ($_COOKIE["pbseo_last_tab_id"]) ? $_COOKIE["pbseo_last_tab_id"]: "pbseo_meta_tab_optimizer"; ?>
	<ul class="pbseo_tabs">
		<li><a id="pbseo_meta_tab_optimizer" href="#" <?php echo ("pbseo_meta_tab_optimizer" == $pb1O5h) ? "class=\"pbseo_defaulttab\" ": ""; ?>rel="pbseo_optimizer"><?php echo pb1l27; ?></a></li>
		<li><a id="pbseo_meta_tab_links" href="#" <?php echo ("pbseo_meta_tab_links" == $pb1O5h) ? "class=\"pbseo_defaulttab\" ": ""; ?>rel="pbseo_links"><?php echo pb1O25; ?></a></li>
		<li><a id="pbseo_meta_tab_content" href="#" <?php echo ("pbseo_meta_tab_content" == $pb1O5h) ? "class=\"pbseo_defaulttab\" ": ""; ?>rel="pbseo_content"><?php echo pb1l26; ?></a></li>
	</ul>

	<?php pb1l5i($post->ID); pb1O5i($post->ID); pb1l5j($post->ID); echo "</div>"; $pb1O5j=pb1O3t(pb1O1i,"meta"); $pb1O5j=trim_wrapper($pb1O5j); if (!empty($pb1O5j)) {; ?>
		<div id="pbseo_meta_notice_wrapper">
			<div class="pbseo_meta_notice">
				<?php echo $pb1O5j; ?>
			</div>
		</div>
	<?php } } function pb1l5i($pb1l5k) {; ?>
	<div class="pbseo_tab_content" id="pbseo_optimizer">

		<?php $pb1O5k="optimizer"; $pb1l5l=array(array("id" => "analyze","label" => __("Analyze",PluginTextDomain_DEFINE),),array("id" => "report","label" => __("Report",PluginTextDomain_DEFINE)),array("id" => "keywords","label" => __("Keywords",PluginTextDomain_DEFINE)),); $pb1O5l="pbseo_sub_tabs_".$pb1O5k; $pb1l5m= isset ($_COOKIE[$pb1O5l]) ? $_COOKIE[$pb1O5l]: "pbseo_meta_sub_tab_".$pb1O5k."_".$pb1l5l[0]["id"]; ?>
		<div id="pbseo_sub_tabs_<?php echo $pb1O5k; ?>" class="pbseo_sub_tabs">
			<?php foreach ($pb1l5l as $pb1O2q => $pb1l2r) { $pb1O5m="pbseo_meta_sub_tab_".$pb1O5k."_".$pb1l2r["id"]; ?>
				<a id="pbseo_meta_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l2r["id"]; ?>" href="#" <?php echo ($pb1O5m == $pb1l5m) ? "class=\"pbseo_defaultsubtab\" ": ""; ?>rel="<?php echo "pbseo_sub_tab_".$pb1O5k."_".$pb1l2r["id"]; ?>"><?php echo $pb1l2r["label"]; ?></a>
			<?php } ?>
		</div>

		<?php $pb1l5n="analyze"; ?>
		<div class="pbseo_sub_tab_container_<?php echo $pb1O5k; ?>" id="pbseo_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>">

			<?php if (FALSE_BOOL_DEFINE !== pb1O2a) {; ?>
				<p><?php echo __("Primary Keyword",PluginTextDomain_DEFINE); ?>:<br />
					<?php $pb1O5n="optimizer_keyword"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=pb1O2p(trim_wrapper(get_post_meta($pb1l5k,$pb1l5o,TRUE_BOOL_DEFINE))); ?>
					<input type="text" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" value="<?php echo esc_attr($pb1l2r); ?>" />
					<?php $pb1O5n="optimizer_analyze"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=__("Analyze",PluginTextDomain_DEFINE); ?>
					<input type="submit" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" class="button-secondary" value="<?php echo esc_attr($pb1l2r); ?>" />
				</p>
				<?php $pb1l5p=get_post_meta($pb1l5k,_pbseo_meta_DEFINE."optimizer_cache",TRUE_BOOL_DEFINE); if (!empty($pb1l5p)) { $pb1l5p=wp_kses_post($pb1l5p); } ?>
				<div id="pbseo_meta_optimizer_output"><?php echo $pb1l5p; ?></div>
				<div id="pbseo_output_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>"></div>
			<?php } else { pb1O3w(); } ?>
		</div>

		<?php $pb1l5n="report"; ?>
		<div class="pbseo_sub_tab_container_<?php echo $pb1O5k; ?>" id="pbseo_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>">
			<?php if (FALSE_BOOL_DEFINE !== pb1O2a) {; ?>
				<div id="pbseo_output_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>"></div>
			<?php } else { pb1O3w(); } ?>
		</div>

		<?php $pb1l5n="keywords"; ?>
		<div class="pbseo_sub_tab_container_<?php echo $pb1O5k; ?>" id="pbseo_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>">

			<?php if (pb1O3u(pb1O1)) { if (TRUE_BOOL_DEFINE == get_option(pbseo_opt_DEFINE."incoming_search_active")) { pb1O5p($pb1l5k); } ?>

				<div id="pbseo_output_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>"></div>

			<?php } else { echo pb1O3t(pb1l1h,"meta_optimizer_keywords"); } ?>

		</div>

	</div>
<?php } function pb1O5i($pb1l5k) {; ?>
	<div class="pbseo_tab_content" id="pbseo_links">

		<?php $pb1O5k="links"; $pb1l5l=array(array("id" => "internal","label" => __("SEO Targets",PluginTextDomain_DEFINE),),array("id" => "external","label" => __("Authority",PluginTextDomain_DEFINE)),); $pb1O5l="pbseo_sub_tabs_".$pb1O5k; $pb1l5m= isset ($_COOKIE[$pb1O5l]) ? $_COOKIE[$pb1O5l]: "pbseo_meta_sub_tab_".$pb1O5k."_".$pb1l5l[0]["id"]; ?>
		<div id="pbseo_sub_tabs_<?php echo $pb1O5k; ?>" class="pbseo_sub_tabs">
			<?php foreach ($pb1l5l as $pb1O2q => $pb1l2r) { $pb1O5m="pbseo_meta_sub_tab_".$pb1O5k."_".$pb1l2r["id"]; ?>
				<a id="pbseo_meta_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l2r["id"]; ?>" href="#" <?php echo ($pb1O5m == $pb1l5m) ? "class=\"pbseo_defaultsubtab\" ": ""; ?>rel="<?php echo "pbseo_sub_tab_".$pb1O5k."_".$pb1l2r["id"]; ?>"><?php echo $pb1l2r["label"]; ?></a>
			<?php } ?>
		</div>

		<?php $pb1l5n="internal"; ?>
		<div class="pbseo_sub_tab_container_<?php echo $pb1O5k; ?>" id="pbseo_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>">

			<?php if (pb1O3u(pb1O1)) {; ?>
				<p>
					<?php $pb1O5n="links_seo_target"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=(1 == get_post_meta($pb1l5k,$pb1l5o,TRUE_BOOL_DEFINE)) ? "checked=\"checked\"": ""; ?>
					<input type="checkbox" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" value="1" <?php echo $pb1l2r; ?> />
					<?php echo __("Assign as SEO Target",PluginTextDomain_DEFINE); ?>
				</p>
				<?php pb1l5q(TRUE_BOOL_DEFINE); ?>
				<div id="pbseo_output_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>"></div>
			<?php } else if (!pb1O3u(pb1O1)) { pb1O3w(); } else { echo "<p>".__("Please go to plugin settings and enter unlock code provided in training video",PluginTextDomain_DEFINE).".</p>"; } ?>

		</div>

		<?php $pb1l5n="external"; ?>
		<div class="pbseo_sub_tab_container_<?php echo $pb1O5k; ?>" id="pbseo_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>">

			<?php if (pb1O3u(pb1O1)) {; ?>
				<p><?php echo __("Search Keyword",PluginTextDomain_DEFINE); ?>:<br />
					<?php $pb1O5n="links_external_keyword"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=trim_wrapper(pb1O2p(get_post_meta($pb1l5k,$pb1l5o,TRUE_BOOL_DEFINE))); ?>
					<input type="text" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" value="<?php echo esc_attr($pb1l2r); ?>" />
					<?php $pb1O5n="links_external_search"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=__("Search",PluginTextDomain_DEFINE); ?>
					<input type="submit" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" class="button-secondary" value="<?php echo esc_attr($pb1l2r); ?>" />
				</p>

				<div id="pbseo_output_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>"></div>

			<?php } else { echo pb1O3t(pb1l1h,"meta_links_external"); } ?>

		</div>

	</div>
<?php } function pb1l5j($pb1l5k) {; ?>
	<div class="pbseo_tab_content" id="pbseo_content">

		<?php $pb1O5k="content"; $pb1l5l=array(array("id" => "images","label" => __("Images",PluginTextDomain_DEFINE),),array("id" => "video","label" => __("Video",PluginTextDomain_DEFINE)),array("id" => "blogs","label" => __("Blogs",PluginTextDomain_DEFINE)),array("id" => "news","label" => __("News",PluginTextDomain_DEFINE)),); $pb1O5l="pbseo_sub_tabs_".$pb1O5k; $pb1l5m= isset ($_COOKIE[$pb1O5l]) ? $_COOKIE[$pb1O5l]: "pbseo_meta_sub_tab_".$pb1O5k."_".$pb1l5l[0]["id"]; ?>
		<div id="pbseo_sub_tabs_<?php echo $pb1O5k; ?>" class="pbseo_sub_tabs">
			<?php foreach ($pb1l5l as $pb1O2q => $pb1l2r) { $pb1O5m="pbseo_meta_sub_tab_".$pb1O5k."_".$pb1l2r["id"]; ?>
				<a id="pbseo_meta_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l2r["id"]; ?>" href="#" <?php echo ($pb1O5m == $pb1l5m) ? "class=\"pbseo_defaultsubtab\" ": ""; ?>rel="<?php echo "pbseo_sub_tab_".$pb1O5k."_".$pb1l2r["id"]; ?>"><?php echo $pb1l2r["label"]; ?></a>
			<?php } ?>
		</div>

		<?php $pb1l5n="images"; ?>
		<div class="pbseo_sub_tab_container_<?php echo $pb1O5k; ?>" id="pbseo_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>">

			<?php if (pb1O3u(pb1O1)) {; ?>
				<p><?php echo __("Search Keyword",PluginTextDomain_DEFINE); ?>:<br />
					<?php $pb1O5n="content_images_keyword"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=trim_wrapper(pb1O2p(get_post_meta($pb1l5k,$pb1l5o,TRUE_BOOL_DEFINE))); ?>
					<input type="text" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" value="<?php echo esc_attr($pb1l2r); ?>" />
					<?php $pb1O5n="content_images_search"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=__("Search",PluginTextDomain_DEFINE); ?>
					<input type="submit" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" class="button-secondary" value="<?php echo esc_attr($pb1l2r); ?>" />
				</p>
				<div id="pbseo_output_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>"></div>
			<?php } else { echo pb1O3t(pb1l1h,"meta_content_images"); } ?>

		</div>

		<?php $pb1l5n="video"; ?>
		<div class="pbseo_sub_tab_container_<?php echo $pb1O5k; ?>" id="pbseo_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>">

			<?php if (pb1O3u(pb1O1)) {; ?>
				<p><?php echo __("Search Keyword",PluginTextDomain_DEFINE); ?>:<br />
					<?php $pb1O5n="content_video_keyword"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=trim_wrapper(pb1O2p(get_post_meta($pb1l5k,$pb1l5o,TRUE_BOOL_DEFINE))); ?>
					<input type="text" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" value="<?php echo esc_attr($pb1l2r); ?>" />
					<?php $pb1O5n="content_video_search"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=__("Search",PluginTextDomain_DEFINE); ?>
					<input type="submit" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" class="button-secondary" value="<?php echo esc_attr($pb1l2r); ?>" />
				</p>
				<div id="pbseo_output_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>"></div>
			<?php } else { echo pb1O3t(pb1l1h,"meta_content_video"); } ?>

		</div>

		<?php $pb1l5n="blogs"; ?>
		<div class="pbseo_sub_tab_container_<?php echo $pb1O5k; ?>" id="pbseo_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>">

			<?php if (pb1O3u(pb1O1)) {; ?>
				<p><?php echo __("Search Keyword",PluginTextDomain_DEFINE); ?>:<br />
					<?php $pb1O5n="content_blogs_keyword"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=trim_wrapper(pb1O2p(get_post_meta($pb1l5k,$pb1l5o,TRUE_BOOL_DEFINE))); ?>
					<input type="text" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" value="<?php echo esc_attr($pb1l2r); ?>" />
					<?php $pb1O5n="content_blogs_search"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=__("Search",PluginTextDomain_DEFINE); ?>
					<input type="submit" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" class="button-secondary" value="<?php echo esc_attr($pb1l2r); ?>" />
				</p>
				<div id="pbseo_output_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>"></div>
			<?php } else { echo pb1O3t(pb1l1h,"meta_content_blogs"); } ?>
		</div>

		<?php $pb1l5n="news"; ?>
		<div class="pbseo_sub_tab_container_<?php echo $pb1O5k; ?>" id="pbseo_sub_tab_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>">
			<?php if (pb1O3u(pb1O1)) {; ?>
				<p><?php echo __("Search Keyword",PluginTextDomain_DEFINE); ?>:<br />
					<?php $pb1O5n="content_news_keyword"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=trim_wrapper(pb1O2p(get_post_meta($pb1l5k,$pb1l5o,TRUE_BOOL_DEFINE))); ?>
					<input type="text" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" value="<?php echo esc_attr($pb1l2r); ?>" />
					<?php $pb1O5n="content_news_search"; $pb1l5o=_pbseo_meta_DEFINE.$pb1O5n; $pb1O5o=pb1O1q($pb1l5o,1); $pb1l2r=__("Search",PluginTextDomain_DEFINE); ?>
					<input type="submit" id="<?php echo $pb1O5o; ?>" name="<?php echo $pb1l5o; ?>" class="button-secondary" value="<?php echo esc_attr($pb1l2r); ?>" />
				</p>
				<div id="pbseo_output_<?php echo $pb1O5k; ?>_<?php echo $pb1l5n; ?>"></div>
			<?php } else { echo pb1O3t(pb1l1h,"meta_content_news"); } ?>
		</div>

	</div>
<?php } function pbseo_save_post_meta_panel($pb1l5k) { if (defined( "DOING_AUTOSAVE") && DOING_AUTOSAVE) { return; } if (!pb1O3u(pb1O1)) { return; } if ( isset ($_POST["wp-preview"]) && ("dopreview" == $_POST["wp-preview"])) { return; } if ((empty($pb1l5k)) || (empty($_POST))) { return; } if (wp_is_post_revision($pb1l5k)) { return; } if ( isset ($_POST["post_type"])) { if (!current_user_can("edit_post",$pb1l5k)) { return $pb1l5k; } } else { if (!current_user_can("edit_post",$pb1l5k)) { return $pb1l5k; } } if (!wp_verify_nonce($_POST[pb1lf],plugin_basename( __FILE__))) { return; } global $post; if (empty($post)) { $post=get_post($pb1l5k); } $pb1O5q=_pbseo_meta_DEFINE."optimizer_keyword"; $pb1l5r=_pbseo_meta_DEFINE."optimizer_seo_rating"; if ( isset ($_POST[$pb1O5q])) { $pb1O5r=trim_wrapper($_POST[$pb1O5q]); if (empty($pb1O5r)) { delete_post_meta($pb1l5k,$pb1O5q); delete_post_meta($pb1l5k,$pb1l5r); } else { pb1l5s($pb1l5k,$pb1O5q,$pb1O5r); } } $pb1O5q=_pbseo_meta_DEFINE."links_seo_target"; if ( isset ($_POST[$pb1O5q])) { pb1l5s($pb1l5k,$pb1O5q,1); } else { pb1l5s($pb1l5k,$pb1O5q,0); } $pb1O5s=array("content_images_keyword","content_video_keyword","content_blogs_keyword","content_news_keyword"); foreach ($pb1O5s as $pb1O2q => $pb1O5q) { $pb1O5q=_pbseo_meta_DEFINE.$pb1O5q; if ( isset ($_POST[$pb1O5q])) { $pb1O5r=trim_wrapper($_POST[$pb1O5q]); if (empty($pb1O5r)) { delete_post_meta($pb1l5k,$pb1O5q); } else { pb1l5s($pb1l5k,$pb1O5q,$_POST[$pb1O5q]); } } } $pb1O5q=_pbseo_meta_DEFINE."links_external_keyword"; if ( isset ($_POST[$pb1O5q])) { $pb1O5r=trim_wrapper($_POST[$pb1O5q]); if (empty($pb1O5r)) { delete_post_meta($pb1l5k,$pb1O5q); } else { pb1l5s($pb1l5k,$pb1O5q,$_POST[$pb1O5q]); } } } function pb1l5s($pb1l5k,$pb1O2q,$pb1l5h) { if (empty($pb1l5k)) { return; } $pb1l5t=get_post_meta($pb1l5k,$pb1O2q,TRUE_BOOL_DEFINE); update_post_meta($pb1l5k,$pb1O2q,$pb1l5h,$pb1l5t); } ?>
