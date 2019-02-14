<?php
/**
* Plugin Name: LifterLMS Customizations
* Plugin URI: https://lifterlms.com/
* Description: Add custom functions to LifterLMS or LifterLMS LaunchPad and preserve them when updating!
* Version: 1.0.0
* Author: codeBOX
* Author URI: http://gocodebox.com
* Text Domain: lifterlms-customizations
* Domain Path: /languages
* License:     GPLv2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Requires at least: 4.0
* Tested up to: 4.6
*
* @package 		LifterLMS
* @category 	Core
* @author 		codeBOX
*/

if ( ! defined( 'ABSPATH' ) ) { exit; } // restrict direct access

/***********************************************************************
 *
 * Add custom functions below this comment
 *
 ***********************************************************************/

/**
* Create user coupon
* @param    int     $student_id  WP User ID
* @param    int     $course_id   WP Post ID of the Course
* @return   void
*/
function create_user_coupon( $student_id, $course_id ) {
 if ($student_id != null) {
		$current_user = wp_get_current_user();
		$user_email = $current_user->user_email;
		$coupon_code = $user_email;
		$amount = '50';
		$discount_type = 'fixed_product'; // Type: fixed_cart, percent, fixed_product, percent_product
		$expiry_date = date( 'Y-m-d', strtotime( '+7 days', current_time( 'timestamp' ) ) );
						
		$coupon = array(
			'post_title' => $coupon_code,
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => 1,
			'post_type'		=> 'shop_coupon'
		);
							
		$new_coupon_id = wp_insert_post( $coupon );
							
		// Add meta
		update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
		update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
		update_post_meta( $new_coupon_id, 'individual_use', 'no' );
		update_post_meta( $new_coupon_id, 'product_ids', '1845' );
		update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
		update_post_meta( $new_coupon_id, 'usage_limit', '' );
		update_post_meta( $new_coupon_id, 'expiry_date', $expiry_date );
		update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
		update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
		update_post_meta( $new_coupon_id, 'customer_email', $user_email );
	}
}
//  Add user to a group upon course enrollment
add_action( 'llms_user_enrolled_in_course', 'create_user_coupon', 10, 2 );

/**
 * Add user to a group
 * @param    int     $student_id  WP User ID
 * @param    int     $course_id   WP Post ID of the Course
 * @return   bool		 true if successful, false otherwise
 */
/*function add_new_user_to_group( $student_id, $course_id ) {
	if ($student_id != null) {
		if ( $group = Groups_Group::read_by_name( 'NewSimplSharpStarterStudent' ) && $course_id = 1165) {
			$result = Groups_User_Group::create( array( "user_id"=>$student_id, "group_id"=>$group->group_id ) );
			$date = current_time( 'mysql' );
			$expiry_date = strtotime("+1 day", strtotime($date));
			update_user_meta( $student_id, 'new_simpl_sharp_starter_student_expire_date', $expiry_date );
		}
	}
}*/
//  Add user to a group upon course enrollment
//add_action( 'llms_user_enrolled_in_course', 'add_new_user_to_group', 10, 2 );


/**
 * Remove user from a group
 * @param    int     $student_id  WP User ID
 * @return   bool		 true if successful, false otherwise
 */
/*function check_user_group_expiration() {
	$user = wp_get_current_user()
	if ($user != null) {
		$date = current_time( 'mysql' );
		$expiry_date = get_user_meta( $student_id, 'new_simpl_sharp_starter_student_expire_date' );
		if ( $group = Groups_Group::read_by_name( 'NewSimplSharpStarterStudent' ) && ($expiry_date < $date)) {
			$result = Groups_User_Group::delete( array( "user_id"=>$user, "group_id"=>$group->group_id ) );
		}
	}
}*/
//  Remove user from a group upon expiration delay
//add_action( 'wp_login', 'check_user_group_expiration', 10, 2 );


/***********************************************************************
 *
 * Add custom functions above this comment
 *
 ***********************************************************************/

/**
 * Add this plugin's "templates" directory to the list of available override directories
 *
 * If you plan on including template overrides in this plugin, please uncomment the line immediately
 * below this function. It is commented out by default to prevent unnecessary lookups
 * for people who don't intend to include any template overrides in this plugin
 *
 * @param  array $dirs    Array of paths to directories to load LifterLMS templates from
 * @return array
 */
function llms_customizations_overrides_directory( $dirs ) {
	array_unshift( $dirs, plugin_dir_path( __FILE__ ) . '/templates' );
	return $dirs;
}
// add_filter( 'lifterlms_theme_override_directories', 'llms_customizations_overrides_directory', 10, 1 );
