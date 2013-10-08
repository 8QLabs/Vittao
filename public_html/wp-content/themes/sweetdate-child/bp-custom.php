<?php

if (!defined('BP_AVATAR_THUMB_WIDTH')) define('BP_AVATAR_THUMB_WIDTH', 500); //change this with your desired thumb width

if (!defined('BP_AVATAR_THUMB_HEIGHT')) define('BP_AVATAR_THUMB_HEIGHT', 500); //change this with your desired thumb height

if (!defined('BP_AVATAR_FULL_WIDTH')) define('BP_AVATAR_FULL_WIDTH', 500); //change this with your desired full size,weel I changed it to 260 <img src="http://buddydev.com/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley">

if (!defined('BP_AVATAR_FULL_HEIGHT')) define('BP_AVATAR_FULL_HEIGHT', 500); //change this to default height for full avatar


function kleo_change_profile_tab()
{
    global $bp;

    $bp->bp_nav['activity']['position'] = 10;
    $bp->bp_nav['messages']['position'] = 30;
    $bp->bp_nav['profile']['position'] = 60;
    $bp->bp_nav['settings']['position'] = 90;
    $bp->bp_nav['activity']['name'] = 'My activity';
    $bp->bp_nav['profile']['name'] = 'My profile';
    $bp->bp_nav['forum']['name'] = '';
    $bp->bp_nav['friends']['name'] = 'My coach';

}

add_action('bp_setup_nav', 'kleo_change_profile_tab', 999);

define('BP_DEFAULT_COMPONENT', 'activity');

function bbg_change_subnav()
{
    global $bp;
    $bp->bp_options_nav['My activity']['Friends']['Coach'] = 'Connections';
}

add_action('bp_setup_nav', 'bbg_change_subnav', 999);

// change "en_US" to your locale
define('BPLANG', 'eng_US');
if (file_exists(WP_LANG_DIR . '/buddypress-' . BPLANG . '.mo')) {
    load_textdomain('buddypress', WP_LANG_DIR . '/buddypress-' . BPLANG . '.mo');
}


function remove_xprofile_links()
{
    remove_filter('bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 2);
}

add_action('bp_init', 'remove_xprofile_links');
?>


