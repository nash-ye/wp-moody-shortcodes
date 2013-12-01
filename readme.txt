=== Moody Shortcodes ===
Contributors: alex-ye
Tags: shortcode, shortcodes, moody shortcodes , conditional tags, api
Requires at least: 2.5
Tested up to: 3.7
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple API to do the shortcodes on certain conditions.

== Description ==

= Important Notes: =
1. This plugin is for developers, not general users.
2. This plugin doesn't have a GUI ( Admin Settings Page ).

= Basic Examples =
You can use this plugin in many ways depending on your needs, this examples only for learning purposes:

`
// Register the "test-1" shortcode, Works only in the administrators posts or outside the loop.
Moody_Shortcodes_Manager::register( 'test-1', function() {

    if ( in_the_loop() ) {

        $post_author = get_post_field( 'post_author', get_post() );

        if ( ! user_can( $post_author, 'administrator' ) ) {
            return false;

        } // end if

    } // dnd if

    return true;

}, 'my_test_shortcode' );
`

`
// Register the "test-2" shortcode, Works only in pages or outside the loop.
Moody_Shortcodes_Manager::register( 'test-2', function() {
    return ( ! in_the_loop() XOR get_post_type() === 'page' );
}, 'my_test_shortcode' );
`

`
// Register the "test-3" shortcode, Works only when bbPress plugin is activated.
Moody_Shortcodes_Manager::register( 'test-3', function() {
    return function_exists( 'is_bbpress' );
}, 'my_test_shortcode' );
`

= Contributing =
If you love this plugin star/fork it on the [GitHub Repository](https://github.com/nash-ye/WP-Moody-Shortcodes).

== Installation ==

1. Upload and install the plugin
2. Use the simple API to powerful your plugin.

== Changelog ==

= 0.1 =
* The Initial version.