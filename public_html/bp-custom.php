<?php
 
if ( !defined( 'BP_AVATAR_THUMB_WIDTH' ) )
define( 'BP_AVATAR_THUMB_WIDTH', 120 ); //change this with your desired thumb width
 
if ( !defined( 'BP_AVATAR_THUMB_HEIGHT' ) )
define( 'BP_AVATAR_THUMB_HEIGHT', 120 ); //change this with your desired thumb height
 
if ( !defined( 'BP_AVATAR_FULL_WIDTH' ) )
define( 'BP_AVATAR_FULL_WIDTH', 580 ); //change this with your desired full size,weel I changed it to 260 <img src="http://buddydev.com/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> 
 
if ( !defined( 'BP_AVATAR_FULL_HEIGHT' ) )
define( 'BP_AVATAR_FULL_HEIGHT', 580 ); //change this to default height for full avatar
 

function kleo_change_profile_tab() {
global $bp;
 
$bp->bp_nav['profile']['position'] = 10;
$bp->bp_nav['activity']['position'] = 20;
$bp->bp_nav['friends']['position'] = 30;
$bp->bp_nav['groups']['position'] = 40;
$bp->bp_nav['blogs']['position'] = 50;
$bp->bp_nav['messages']['position'] = 60;
$bp->bp_nav['settings']['position'] = 70;
$bp->bp_nav['activity']['name'] = 'Wall';
$bp->bp_nav['profile']['name'] = 'My profile';

}
add_action( 'bp_setup_nav', 'kleo_change_profile_tab', 999 );
 
define( 'BP_DEFAULT_COMPONENT', 'profile' );
 


?>