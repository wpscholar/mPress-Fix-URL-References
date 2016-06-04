<?php

/**
 * Plugin Name: mPress Fix URL References
 * Plugin URI: http://wpscholar.com/wordpress-plugins/mpress-fix-url-references/
 * Description: Easily fix URL references in your WordPress database.
 * Author: Micah Wood
 * Author URI: http://wpscholar.com
 * Version: 1.0
 * License: GPL3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Copyright 2012-2016 by Micah Wood - All rights reserved.
 */

define( 'MPRESS_FIX_URL_REFERENCES_VERSION', '1.0' );

if ( ! class_exists( 'mPress_Fix_URL_References' ) ) {

	class mPress_Fix_URL_References {

		function __construct() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}

		/**
		 * Add a menu page
		 */
		function admin_menu() {
			$title = __( 'Fix URL References', 'mpress-fix-url-references' );
			$slug = 'mpress-fix-url-references';
			add_submenu_page( 'tools.php', $title, $title, 'manage_options', $slug, array( $this, 'page_content' ) );
		}

		/**
		 * Menu page content - Allows users to enter a URL to be replaced in the database
		 */
		function page_content() { ?>
			<div class="wrap">
				<h2><?php _e( 'mPress Fix URL References', 'mpress-fix-url-references' ); ?></h2>
				<div class="tool-box"><?php
					if ( ! empty( $_POST['replace_url'] ) && isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'fix_url_references' ) ) {
						$rows = self::update_database_url_references( preg_replace( '#/$#', '', trim( $_POST['replace_url'] ) ) );
						echo '<p style="color:green">' . sprintf( __( 'Database update is complete. %s instances replaced.', 'mpress-fix-url-references' ), $rows ) . '</p>';
						echo '<p><a href="' . esc_attr( admin_url( 'tools.php?page=mpress-fix-url-references' ) ) . '" class="button-primary">' . __( 'Fix More URLs', 'mpress-fix-url-references' ) . '</a></p>';
					} else {
						if ( ! defined( 'WP_HOME' ) || ! defined( 'WP_SITEURL' ) ) {
							echo '<p>' . __( 'You must set the WP_HOME and WP_SITEURL constants in your wp-config.php file to use this plugin.', 'mpress-fix-url-references' ) . '</p>';
						} else {
							if ( isset( $_POST['replace_url'] ) ) {
								echo '<p style="color:red;">' . __( 'Please enter a URL!', 'mpress-fix-url-references' ) . '</p>';
							}
							echo '<p>' . __( 'URL references in the database that match your input will be replaced with: ', 'mpress-fix-url-references' ) . '<code>' . home_url() . '</code></p>';
							echo '<form method="post"><p>';
							echo '<label for="replace_url">' . __( 'URL reference to be replaced:', 'mpress-fix-url-references' ) . '</label> ';
							echo '<input type="url" id="replace_url" name="replace_url" size="60" placeholder="' . esc_attr( home_url() ) . '" /></p>';
							wp_nonce_field( 'fix_url_references', 'nonce' );
							echo '<p style="color:red;">' . __( '<strong>ALERT</strong>: Before running, please double check your entry and make sure you have backed up the database!', 'mpress-fix-url-references' ) . '</p>';
							echo '<input type="submit" class="button-primary" value="' . esc_attr( __( 'Fix References', 'mpress-fix-url-references' ) ) . '" />';
							echo '</form>';
						}
					} ?>
				</div><!-- .tool-box -->
			</div><!-- #wrap --><?php
		}

		/**
		 * Replaces instances of a URL in the database with WP_HOME. Also updates the 'siteurl' and 'home'
		 * WordPress options.
		 *
		 * @param string $old_url
		 *
		 * @return int
		 */
		public static function update_database_url_references( $old_url ) {
			$rows = 0;
			if ( defined( 'WP_SITEURL' ) ) {
				update_option( 'siteurl', WP_SITEURL );
			}
			if ( defined( 'WP_HOME' ) ) {
				update_option( 'home', WP_HOME );
				// TODO: Update code to properly handle serialization for fields that may contain serialized data!
				$rows = self::run_replacement_query( 'commentmeta', 'meta_value', $old_url, WP_HOME ) + $rows;
				$rows = self::run_replacement_query( 'comments', 'comment_content', $old_url, WP_HOME ) + $rows;
				$rows = self::run_replacement_query( 'links', 'link_url', $old_url, WP_HOME ) + $rows;
				$rows = self::run_replacement_query( 'links', 'link_rss', $old_url, WP_HOME ) + $rows;
				$rows = self::run_replacement_query( 'options', 'option_value', $old_url, WP_HOME ) + $rows;
				$rows = self::run_replacement_query( 'posts', 'post_content', $old_url, WP_HOME ) + $rows;
				$rows = self::run_replacement_query( 'posts', 'guid', $old_url, WP_HOME ) + $rows;
				$rows = self::run_replacement_query( 'postmeta', 'meta_value', $old_url, WP_HOME ) + $rows;
				$rows = self::run_replacement_query( 'usermeta', 'meta_value', $old_url, WP_HOME ) + $rows;
			}

			return $rows;
		}

		/**
		 * Replace all instances of a string in a column of a specific WordPress table.
		 *
		 * @param string $table
		 * @param string $field
		 * @param string $old
		 * @param string $new
		 *
		 * @return false|int
		 */
		public static function run_replacement_query( $table, $field, $old, $new ) {
			/**
			 * @var wpdb $wpdb
			 */
			global $wpdb;
			$table = $wpdb->_escape( $table );
			$field = $wpdb->_escape( $field );
			$sql = $wpdb->prepare( "UPDATE {$wpdb->$table} SET {$field} = REPLACE( {$field}, %s, %s )", $old, $new );

			return $wpdb->query( $sql );
		}

	}

	new mPress_Fix_URL_References();

}