<?php
 
if ( !defined( 'BP_AVATAR_THUMB_WIDTH' ) )
define( 'BP_AVATAR_THUMB_WIDTH', 500 ); //change this with your desired thumb width
 
if ( !defined( 'BP_AVATAR_THUMB_HEIGHT' ) )
define( 'BP_AVATAR_THUMB_HEIGHT', 500 ); //change this with your desired thumb height
 
if ( !defined( 'BP_AVATAR_FULL_WIDTH' ) )
define( 'BP_AVATAR_FULL_WIDTH', 500 ); //change this with your desired full size,weel I changed it to 260 <img src="http://buddydev.com/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> 
 
if ( !defined( 'BP_AVATAR_FULL_HEIGHT' ) )
define( 'BP_AVATAR_FULL_HEIGHT', 500 ); //change this to default height for full avatar
 

function kleo_change_profile_tab() {
global $bp;
 
$bp->bp_nav['profile']['position'] = 10;
$bp->bp_nav['activity']['position'] = 30;
$bp->bp_nav['messages']['position'] = 50;
$bp->bp_nav['settings']['position'] = 70;
$bp->bp_nav['activity']['name'] = 'My activity';
$bp->bp_nav['profile']['name'] = 'My profile';
$bp->bp_nav['forum']['name'] = '';
$bp->bp_nav['friends']['name'] = 'Coach';

}
add_action( 'bp_setup_nav', 'kleo_change_profile_tab', 999 );
 
define( 'BP_DEFAULT_COMPONENT', 'profile' );
 


?>