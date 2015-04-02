<?php
/*
Plugin Name: Pinboard Curator
Description: Create WP-post based on Pinboard tag
Version: 0.3
Author: Ryan Tvenge (Forked from Jonas Nordstrom)
Author URI: http://ryantvenge.com
*/
/**
 * Copyright (c) 2012 Jonas Nordstrom. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 */
if (!class_exists("PinboardCurator")) {
	class PinboardCurator {

		// Max number of items
		protected $max_items;
		protected $pinboard_user;
		protected $pinboard_tag;
		protected $item_elements;
		protected $title_elements;

		// Constructor
		public function PinboardCurator() {
			$this->max_items = get_option('pinboard-curator-maxitems', '10');
			$this->pinboard_user = get_option('pinboard-curator-pinboard-user', '10');
			$this->pinboard_tag = get_option('pinboard-curator-pinboard-tag', '10');
			$this->item_elements = array (
									'%TITLE%'               =>      'feed item title',
									'%LINK%'                =>      'link for the feed item',
									'%DATE%'                =>      'item publish date',
									'%NOTE%'                =>      'feed note',
									);
			$this->title_elements = array (
									'%DATE%'                =>      'post publish date'
									);
		}

		// initialization, setup localization
		public function init_pinboard_curator() {
			// Set up localization
			$plugin_dir = basename(dirname(__FILE__));
			load_plugin_textdomain( 'pinboardcurator', 'wp-content/plugins/'. $plugin_dir.'/languages', $plugin_dir.'/languages' );
		}

		// Admin page for plugin
		function pinboard_curator_admin_page() {
			// Handle updates
			if( isset( $_POST['action'] ) && $_POST[ 'action' ] == 'save' ) {
				check_admin_referer('pinboard-curator-save-action', 'pinboard-curator-save');
				update_option('pinboard-curator-maxitems',       $_POST[ 'pinboard-curator-maxitems' ]);
				update_option('pinboard-curator-pinboard-user', $_POST[ 'pinboard-curator-pinboard-user' ]);
				update_option('pinboard-curator-pinboard-tag',  $_POST[ 'pinboard-curator-pinboard-tag' ]);
				update_option('pinboard-curator-author',         $_POST[ 'pinboard-curator-author' ]);
				update_option('pinboard-curator-category',       $_POST[ 'pinboard-curator-category' ]);
				update_option('pinboard-curator-tags',           $_POST[ 'pinboard-curator-tags' ]);
				update_option('pinboard-curator-post-title',     $_POST[ 'pinboard-curator-post-title' ]);
				update_option('pinboard-curator-header',         $_POST[ 'pinboard-curator-header' ]);
				update_option('pinboard-curator-footer',         $_POST[ 'pinboard-curator-footer' ]);
				update_option('pinboard-curator-item',           $_POST[ 'pinboard-curator-item' ]);
				?>
				<div class="updated"><p><strong><?php _e('Settings saved.', 'pinboardcurator' ); ?></strong></p></div>
				<?php

			}
			if( isset( $_POST['action'] ) && $_POST[ 'action' ] == 'run' ) {
				check_admin_referer('pinboard-curator-run-action', 'pinboard-curator-run');

				$items_posted = 0;

				$maxitems =      get_option('pinboard-curator-maxitems');
				$pinboard_user = get_option('pinboard-curator-pinboard-user');
				$pinboard_tag =  get_option('pinboard-curator-pinboard-tag');
				$author =         get_option('pinboard-curator-author');
				$category =       get_option('pinboard-curator-category');
				$tags =           get_option('pinboard-curator-tags');
				$post_title =     get_option('pinboard-curator-post-title');
				$header =         get_option('pinboard-curator-header');
				$footer =         get_option('pinboard-curator-footer');
				$item_template =  get_option('pinboard-curator-item');

				$pinboard_tag_call =  empty($pinboard_tag) ? "" : "/t:{$pinboard_tag}";

				$rss_link = "http://feeds.pinboard.in/rss/u:{$pinboard_user}" . $pinboard_tag_call . "/?count={$maxitems}";

				// $rss_link = "http://feeds.delicious.com/v2/rss/{$pinboard_user}/{$pinboard_tag}?count={$maxitems}";

				//in case there are no tags, delcious api freaks out with a / then ? /rtvenge/?count=20
				$rss_link = preg_replace('/\/\?/', '?', $rss_link);

				include_once(ABSPATH . WPINC . '/feed.php');

				//default cache time is 12 hours. Decrease that.
				add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 60;' ) );

				$rss = fetch_feed($rss_link);
				if ( !is_wp_error( $rss ) ) :
					$maxitems = $rss->get_item_quantity($max_items);

					// Build an array of all the items, starting with element 0 (first element).
					$rss_items = $rss->get_items(0, $maxitems);
				endif;

				foreach ( $rss_items as $item ) {
					$rss_date = strtotime($item->get_local_date());
					$new_item['entry_time'] = $rss_date;
					$new_item["title"] = $item->get_title();
					$new_item["link"] = $item->get_link();
					$new_item["description"] = $item->get_description();

					$new_items[] = $new_item;
				}
				$prev_max_date = get_option('pinboard-curator-prev-max-date');
				if (count($new_items) > 0) {

					$max_date = $prev_max_date;
					foreach ($new_items as $item) {

						$item_date = date(get_option("date_format"), $item["entry_time"]);

						if ($item["entry_time"] > $prev_max_date) {

							if( $item["entry_time"] > $max_date ) {
								$max_date = $item["entry_time"];
							}

							$import = html_entity_decode($item_template);
							$import = str_replace ( array_keys ( $this->item_elements ), array (
								$item["title"],
								$item["link"],
								$item_date,
								$item["description"],
								), $import );
							$post_content.= $import;
							$items_posted++;
						}
					}

					if ( $items_posted > 0 ) {
						$post_title = str_replace( array_keys ( $this->title_elements ), date(get_option("date_format")), $post_title);
						$my_post = array(
							'post_title' => $post_title,
							'post_content' => $header . $post_content . $footer,
							'post_status' => 'draft',
							'post_category' => array($category),
							'tags_input' => $tags,
							'post_author' => $author
							);

						$new_post_id = wp_insert_post( $my_post );
						update_option('pinboard-curator-prev-max-date', $max_date);
					}
				}

				if ( !empty( $new_post_id ) ) {
					$message = $items_posted . " link(s) added to new post. <a href='" . get_edit_post_link($new_post_id) . "'>Edit</a>";
				} else {
					$message = sprintf(__("No new links found since %s. Nothing posted.", "pinboardcurator"), date(get_option("date_format"), $prev_max_date));
				}
				?>
				<div class="updated"><p><strong><?php echo  $message; ?></strong></p></div>
				<?php

			}

			// The form, with all names and a checkbox in front
			echo '<div class="wrap">';
			echo "<h2>" . __("Pinboard Curator", "pinboardcurator") . "</h2>";
			?>
			<form name="pinboard-curator-admin-form" method="post" action="">
				<input type="hidden" name="action" value="save" />
				<?php wp_nonce_field('pinboard-curator-save-action', 'pinboard-curator-save'); ?>
				<table class="pinboard-curator-form-table">
					<tr>
						<td><?php _e("Max items", "pinboardcurator"); ?></td>
						<td><input type="text" id="pinboard-curator-maxitems" name="pinboard-curator-maxitems" value="<?php echo esc_html(stripslashes(get_option( 'pinboard-curator-maxitems', '10' ))); ?>" /></td>
					</tr>
					<tr>
						<td><?php _e("Pinboard User", "pinboardcurator"); ?></td>
						<td><input type="text" id="pinboard-curator-pinboard-user" name="pinboard-curator-pinboard-user" value="<?php echo esc_html(stripslashes(get_option( 'pinboard-curator-pinboard-user', 'USERNAME' ))); ?>" /></td>
					</tr>
					<tr>
						<td><?php _e("Pinboard Tag", "pinboardcurator"); ?></td>
						<td><input type="text" id="pinboard-curator-pinboard-tag" name="pinboard-curator-pinboard-tag" value="<?php echo esc_html(stripslashes(get_option( 'pinboard-curator-pinboard-tag', 'TAG or TAG+TAG' ))); ?>" /></td>
					</tr>
					<tr>
						<td><?php _e("Post title", "pinboardcurator"); ?></td>
						<td><input type="text" id="pinboard-curator-post-title" name="pinboard-curator-post-title" value="<?php echo esc_html( stripslashes(get_option( 'pinboard-curator-post-title', 'My links %DATE%' ))); ?>" /></td>
					</tr>
					<tr>
						<td></td>
						<td>You can use these tags:<br/>
						<?php foreach ($this->title_elements as $tag => $desc) { echo "{$tag}: {$desc}<br/>"; } ?></td>
					</tr>
					<tr>
						<td><?php _e("Header", "pinboardcurator"); ?></td>
						<td><input type="text" id="pinboard-curator-header" name="pinboard-curator-header" value="<?php echo esc_html(stripslashes(get_option( 'pinboard-curator-header', "<ol class=\"link-list\">" ))); ?>" /></td>
					</tr>
					<tr>
						<td><?php _e("Footer", "pinboardcurator"); ?></td>
						<td><input type="text" id="pinboard-curator-footer" name="pinboard-curator-footer" value="<?php echo esc_html(stripslashes(get_option( 'pinboard-curator-footer', "</ol>" ))); ?>" /></td>
					</tr>
					<tr>
						<td><?php _e("Item", "pinboardcurator"); ?></td>
						<td><textarea cols="60" rows="3" id="pinboard-curator-item" name="pinboard-curator-item"><?php echo esc_html(stripslashes(get_option( 'pinboard-curator-item', '<li><a href="%LINK%" title="%TITLE%">%TITLE%</a><br>%NOTE%</li>' ))); ?></textarea></td>
					</tr>
					<tr>
						<td></td>
						<td>You can use these tags:<br/>
						<?php foreach ($this->item_elements as $tag => $desc) { echo "{$tag}: {$desc}<br/>"; } ?></td>
					</tr>
					<tr>
						<td><?php _e("Author", "pinboardcurator"); ?></td>
						<td>
							<select name="pinboard-curator-author" id="pinboard-curator-author">
								<?php
								$all_users = get_users();
								foreach ($all_users as $u) {
									$selected = "";
									if ($u->ID == get_option( 'pinboard-curator-author' )) $selected = ' selected="selected"';
									echo '<option value="'.$u->ID.'"'.$selected.'>'.$u->display_name.'</option>';
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php _e("Category", "pinboardcurator"); ?></td>
						<td>
							<?php
							$dropdown_options = array(
								'show_option_all' => '',
								'hide_empty' => 0,
								'hierarchical' => 1,
								'show_count' => 0,
								'depth' => 0,
								'orderby' => 'ID',
								'selected' => get_option( 'pinboard-curator-category' ),
								'name' => 'pinboard-curator-category');
							wp_dropdown_categories($dropdown_options);
							?>
						</td>
					</tr>
					<tr>
						<td><?php _e("Tags", "pinboardcurator"); ?></td>
						<td><input type="text" id="pinboard-curator-tags" name="pinboard-curator-tags" value="<?php echo stripslashes(get_option( 'pinboard-curator-tags' )); ?>" /></td>
					</tr>
					<tr>
						<td colspan="2">
							<p class="submit">
								<input type="submit" name="Submit" value="<?php _e('Update options', 'pinboardcurator' ) ?>" />
							</p>
						</td>
					</tr>
				</table>
			</form>
			<form name="pinboard-curator-run-form" method="post" action="">
				<input type="hidden" name="action" value="run" />
				<?php wp_nonce_field('pinboard-curator-run-action', 'pinboard-curator-run'); ?>
				<table class="pinboard-curator-form-table">
					<tr>
						<td colspan="2">
							<p class="submit">
								<input type="submit" name="Submit" value="<?php _e('Run now', 'pinboardcurator' ) ?>" />
							</p>
						</td>
					</tr>

				</table>
			</form>

			</div>
			<?php
		}

		public function init_pinboard_curator_admin() {
			add_options_page(__('Pinboard Curator Settings', "pinboardcurator"), __('Pinboard Curator', "pinboardcurator"), 'manage_options', basename(__FILE__), array(&$this, 'pinboard_curator_admin_page') );
		}

	}
}

// Init class
if (class_exists("PinboardCurator")) {
	$pinboardcurator = new PinboardCurator();
}

// Hooks, Actions and Filters, oh my!
add_action( 'init', array(&$pinboardcurator, 'init_pinboard_curator'));
add_action( 'admin_menu', array(&$pinboardcurator, 'init_pinboard_curator_admin' ));

add_filter( 'cron_schedules', 'wi_add_weekly_schedule' );
function wi_add_weekly_schedule( $schedules ) {
  $schedules['weekly'] = array(
    'interval' => 7 * 24 * 60 * 60, //7 days * 24 hours * 60 minutes * 60 seconds
    'display' => __( 'Once Weekly', 'my-plugin-domain' )
  );
  /*
  You could add another schedule by creating an additional array element
  $schedules['biweekly'] = array(
    'interval' => 7 * 24 * 60 * 60 * 2
    'display' => __( 'Every Other Week', 'my-plugin-domain' )
  );
  */

  return $schedules;
}

// function _log() {
//   if( WP_DEBUG === true ){
// 	$args = func_get_args();
// 	error_log(print_r($args, true));
//   }
// }

