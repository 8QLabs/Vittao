<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Sweetdate
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Sweetdate 1.0
 */
?>
<!-- SIDEBAR SECTION
================================================ -->
<aside class="four columns">

    <div class="widgets-container sidebar_location">
        <?php generated_dynamic_sidebar();?>
    </div>
    
</aside> <!--end four columns-->
<!--END SIDEBAR SECTION-->