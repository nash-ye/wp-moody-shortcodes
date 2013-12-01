<?php
/**
 * Plugin Name: Moody Shortcodes
 * Plugin URI: https://github.com/nash-ye/WP-Moody-Shortcodes
 * Description: A simple API to do the shortcodes on certain conditions.
 * Author: Nashwan Doaqan
 * Author URI: http://nashwan-d.com
 * Version: 0.1
 *
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Copyright (c) 2013 - 2014 Nashwan Doaqan.  All rights reserved.
 */

/**
 * The moody shortcodes manager.
 *
 * @since 0.1
 */
class Moody_Shortcodes_Manager {

	/**
	 * The moody shortcodes list.
	 *
	 * @var array
	 * @since 0.1
	 */
	protected static $shortcodes = array();


	/** Magic Methods *********************************************************/

	/**
	 * A dummy constructor.
	 *
	 * @since 0.1
	 */
	private function __construct() {}


	/*** Static Methods *******************************************************/

	/**
	 * A magic method to call the moody shortcodes holders.
	 *
	 * @since 0.1
	 */
	public static function __callStatic( $name, $arguments ) {

		$shortcode = self::get_list( array(
			'holder' => array( __CLASS__, $name ),
		), 'OR' );

		if ( ! empty( $shortcode ) ) {

			$shortcode = reset( $shortcode );

			if ( (bool) call_user_func( $shortcode->condition ) ) {
				$name = $shortcode->callback;
			} else {
				$name = false;
			} // end if

		} // end if

		if ( ! empty( $name ) ) {
			return call_user_func_array( $name, $arguments );
		} // end if

	} // end __callStatic()


	/*** Static Methods *******************************************************/

	/**
	 * Get a shortcode tag callback.
	 *
	 * @return callable|bool
	 * @since 0.1
	 */
	public static function get_shortocde_callback( $tag ) {

		if ( isset( self::$shortcodes[ $tag ] ) ) {
			return self::$shortcodes[ $tag ]->callback;
		}

		return false;

	} // end get_shortocde_callback()

	/**
	 * Get a shortcode tag condition callback.
	 *
	 * @return callable|bool
	 * @since 0.1
	 */
	public static function get_shortcode_condition( $tag ) {

		if ( isset( self::$shortcodes[ $tag ] ) ) {
			return self::$shortcodes[ $tag ]->condition;
		}

		return false;

	} // end get_shortcode_condition()

	/**
	 * Get a shortcode tag holder callback.
	 *
	 * @return callable|bool
	 * @since 0.1
	 */
	public static function get_shortcode_holder( $tag ) {

		if ( isset( self::$shortcodes[ $tag ] ) ) {
			return self::$shortcodes[ $tag ]->holder;
		}

		return false;

	} // end get_shortcode_holder()

	/**
	 * Get the moody shortcodes list.
	 *
	 * @return array
	 * @since 0.1
	 */
	public static function get_list( $args = array(), $operator = 'AND' ) {
		return wp_list_filter( self::$shortcodes, $args, $operator );
	} // end get_list()

	/**
	 * Register a moody shortcode.
	 *
	 * @return bool
	 * @since 0.1
	 */
	public static function register( $tag, $condition, $callback = false ) {

		global $shortcode_tags;

		if ( empty( $callback ) ) {

			if ( isset( $shortcode_tags[ $tag ] ) ) {
				$callback = $shortcode_tags[ $tag ];
			}

		} else {

			if ( ! is_callable( $callback ) ) {
				return false;
			}

		}

		if ( ! is_callable( $condition ) ) {
			return false;
		}

		self::$shortcodes[ $tag ] = (object) array(
			'holder' => array( __CLASS__, md5( $tag ) ),
			'condition' => $condition,
			'callback' => $callback,
		);

		$shortcode_tags[ $tag ] = self::$shortcodes[ $tag ]->holder;

		return true;

	} // end register()

	/**
	 * Deregister a moody theme.
	 *
	 * @return void
	 * @since 0.1
	 */
	public static function deregister( $tag ) {
		unset( self::$shortcodes[ $tag ] );
	} // end deregister()

} // end class Moody_Shortcodes_Manager