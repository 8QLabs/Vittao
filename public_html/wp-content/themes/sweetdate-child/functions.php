<?php
/**
 * @package WordPress
 * @subpackage Sweetdate
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Sweetdate 1.0
 */


/**
 * Sweetdate Child Theme Functions
 * Add extra code or replace existing functions
*/
global $bp;


//Detect User Permission
function is_allowed_view_users_profile() {
    $loggedin_user_id = bp_loggedin_user_id();
    $displayed_user_id = bp_displayed_user_id();
    $check_status = "";
    $profile_owner = false;

    if ($loggedin_user_id == $displayed_user_id) {
        $profile_owner = true;
    } else {
        $check_status = friends_check_friendship_status($loggedin_user_id, $displayed_user_id);
    }

    //User Permission Settings
    //"is_friend", "not_friends", "pending"
    if ($check_status == "is_friend" || $profile_owner ) {
        $allow_permission = true;
    } else {
        $allow_permission = false;
    }

    return $allow_permission;
}

function detect_current_user_tag() {
    return xprofile_get_field_data( 11, bp_loggedin_user_id() );
}

function detect_user_tag($bp_get_member_user_id) {
    return xprofile_get_field_data( 11, $bp_get_member_user_id );
}

function detect_user_type($bp_get_member_user_id) {
    return xprofile_get_field_data( 325, $bp_get_member_user_id );
}

function detect_buat_user_type() {
    if ( is_user_logged_in() ) {

        $user_type = xprofile_get_field_data(325, bp_loggedin_user_id());

        return $user_type;

    } else {

        return "Guest User";
    }
}

function is_current_user_coach() {

    $user_type = detect_buat_user_type();

    if ( $user_type == "Coach" ){
        return true;
    }
    else {
        return false;
    }
}

function is_current_user_student() {

    $user_type = detect_buat_user_type();

    if ( $user_type == "User" ){
        return true;
    }
    else {
        return false;
    }
}

function is_current_user_admin() {
    if ( is_user_logged_in() && current_user_can('administrator') ) {
        return true;
    }
    else {
        return false;
    }
}

function is_current_user_friend() {
    $check_status = friends_check_friendship_status( bp_loggedin_user_id(), bp_displayed_user_id() );

    //"is_friend", "not_friends", "pending"
    if ($check_status == "is_friend") {
       return true;
    } else {
       return false;
    }
}

function detect_user_status( $bp_get_member_user_id ) {
    //"is_friend", "not_friends", "pending"
    return friends_check_friendship_status( bp_loggedin_user_id(), $bp_get_member_user_id );
}


function is_profile_owner() {
    if ( bp_loggedin_user_id() == bp_displayed_user_id() ) {
        return true;
    } else {
        return false;
    }
}

function is_profile_coach() {
    if ( xprofile_get_field_data(325, bp_displayed_user_id()) == "Coach") {
        return true;
    } else {
        return false;
    }
}

function is_profile_student() {
    if ( xprofile_get_field_data(325, bp_displayed_user_id()) == "User") {
        return true;
    } else {
        return false;
    }
}

//function widget_filter() {
//    echo '---Profile::: ';
//
//    if ( is_profile_coach() ) {
//        echo '---Profile Coach: ';
//
//        if  ( is_profile_owner() ) {
//            //echo 'access as owner';
//            unregister_widget( "BP_Core_Members_Widget" );
//
//        } elseif  ( is_current_user_admin() ) {
//            //echo 'access as admin';
//
//        } else {
//            //echo 'access as guest';
//            unregister_widget( "BP_Core_Members_Widget" );
//            unregister_widget( "Vidtok_widget" );
//        }
//    }
//
//    if ( is_profile_student() ) {
//        //echo '!Profile Student: ';
//
//        if  ( is_profile_owner() || is_current_user_admin() ) {
//            //echo 'access as admin or owner';
//
//        } elseif ( is_current_user_coach() and !is_current_user_friend() ) {
//            //echo 'access as coach';
//            unregister_widget( "BP_Core_Members_Widget" );
//            unregister_widget( "Vidtok_widget" );
//
//        } elseif ( is_current_user_coach() and is_current_user_friend() ) {
//            //echo 'access as coach and friend';
//            unregister_widget( "BP_Core_Members_Widget" );
//            unregister_widget( "Vidtok_widget" );
//
//        } else {
//            //echo 'access as guest';
//            unregister_widget( "BP_Core_Members_Widget" );
//            unregister_widget( "Vidtok_widget" );
//        }
//    }
//}

function my_setup_nav() {
    global $bp;

    unset($bp->bp_nav['forums']);

    if ( is_profile_coach() ) {
        //echo 'Profile Coach: ';

        if ( is_profile_owner() ) {
            //echo 'access as owner';

        } elseif  ( is_current_user_admin() ) {
            //echo 'access as admin';

        } else {
            //echo 'access as guest';
            unset($bp->bp_nav['friends']);
            unset($bp->bp_nav['activity']);
        }
    }

    if ( is_profile_student() ) {
        //echo 'Profile Student: ';

        if  ( is_profile_owner() || is_current_user_admin() ) {
            //echo 'access as admin or owner';

        } elseif ( is_current_user_coach() and !is_current_user_friend() ) {
            //echo 'access as coach';
            unset($bp->bp_nav['friends']);
            unset($bp->bp_nav['activity']);

        } elseif ( is_current_user_coach() and is_current_user_friend() ) {
            //echo 'access as coach and friend';
            unset($bp->bp_nav['friends']);

        } else {
            //echo 'access as guest';
        }
    }
}

add_action( 'bp_setup_nav', 'my_setup_nav', 1000 );


/* Filter the redirect url for login*/
add_filter("login_redirect","kleo_redirect_to_profile",100,3);

function kleo_redirect_to_profile($redirect_to_calculated,$redirect_url_specified,$user){
/*if no redirect was specified,let us think ,user wants to be in wp-dashboard*/
    if(!is_super_admin($user->ID))
        return bp_core_get_user_domain($user->ID );
    else
        return $redirect_to_calculated; /*if site admin*/
}

add_action('after_setup_theme','kleo_my_actions');


function kleo_my_actions() {



//    add_action('widgets_init', create_function('', 'return unregister_widget( "BP_Core_Members_Widget" );') );
//    add_action('widgets_init', create_function('', 'return unregister_widget( "Vidtok_widget" );') );


   /* disable matching on member profile */
    remove_action('kleo_bp_before_profile_name', 'kleo_bp_compatibility_match');

    /* Replace the heart over images */
    add_filter('kleo_img_rounded_icon', 'my_custom_icon');

    /* Replace the heart from register modal */
    add_filter('kleo_register_button_icon', 'my_custom_icon_register');

    //global $bp_tabs;
    //$bp_tabs = array();

    /*$bp_tabs['Members'] = array(
        'type' => 'regular',
     //   'name' => apply_filters('kleo_extra_tab2',__('My Profile', 'kleo_framework')),
        'group' => 'Members',
        'class' => 'regulartab'
    );
    */

    /*$bp_tabs['about me'] = array(
        'type' => 'cite',
        'name' => apply_filters('kleo_extra_tab1', __('A bit more about myself', 'kleo_framework')),
        'group' => apply_filters('kleo_extra_tab1', 'A bit more about myself'),
        'class' => 'citetab'
    );

    $bp_tabs['looking-for'] = array(
        'type' => 'cite',
        'name' => apply_filters('kleo_extra_tab1', __('Things I want to focus on', 'kleo_framework')),
        'group' => apply_filters('kleo_extra_tab3', 'Things I want to focus on'),
        'class' => 'citetab'
    );
    */

}

/* add_action('after_setup_theme','kleo_my_page_tab');
function kleo_my_page_tab() 
{  
    global $bp_tabs;
    $bp_tabs[] = array(
    'type' => 'page',
    'name' => 'Suggested Coaches',
    'class' => 'pagetab'
    );
} 
*/

 
/* Replace the heart with a camera icon function */
function my_custom_icon () {
    return 'camera';
}
 
/* Replace the heart with a user icon function */
function my_custom_icon_register () {
    return 'user';
}

/* Display Username in Directory */
function my_member_username() {
    global $members_template;

    return $members_template->member->user_login;
}
add_filter('bp_member_name','my_member_username');


add_action('after_setup_theme','kleo_my_actions');


/* enter the full email address you want displayed */
/* from http://miloguide.com/filter-hooks/wp_mail_from/ */

function xyz_filter_wp_mail_from($email){
return "hello@vittao.com";
}
add_filter("wp_mail_from", "xyz_filter_wp_mail_from");

/* enter the full name you want displayed alongside the email address */
/* from http://miloguide.com/filter-hooks/wp_mail_from_name/ */
function xyz_filter_wp_mail_from_name($from_name){
return "Vittao";
}
add_filter("wp_mail_from_name", "xyz_filter_wp_mail_from_name");
 

add_filter("kleo_bp_profile_default_top_tab","my_default_tab");
function my_default_tab() {
return "info";
}







?>
