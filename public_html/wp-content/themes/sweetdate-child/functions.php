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

// Remove forums menu item
function my_setup_nav() {
      global $bp;
 
      unset($bp->bp_nav['forums']);
      // unset($bp->bp_nav['friends']);      
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
 
function kleo_my_actions() 
{
   /* disable matching on member profile */
    remove_action('kleo_bp_before_profile_name', 'kleo_bp_compatibility_match');      
 
    /* Replace the heart over images */
    add_filter('kleo_img_rounded_icon', 'my_custom_icon');
 
    /* Replace the heart from register modal */
    add_filter('kleo_register_button_icon', 'my_custom_icon_register');

    global $bp_tabs;
    $bp_tabs = array();

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
 

add_filter(‘kleo_bp_profile_default_top_tab’,'my_default_tab’);
function my_default_tab() {
return ‘info’;
}



?>
