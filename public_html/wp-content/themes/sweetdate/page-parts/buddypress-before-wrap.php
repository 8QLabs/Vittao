<?php
/**
 * Before content wrap
 * Used in all templates
 */
?>


<!-- MAIN SECTION
================================================ -->
<section>
    <div id="main">
        
        <?php
        /**
         * Before main part - action
         */
        do_action('kleo_before_main');
        ?>
        
        <div class="row">
            
            <?php /* Before content - action */ ?>
            <?php do_action('kleo_buddypress_before_content'); ?>
            
            <!--begin content-->
            <div class="<?php if (sq_option('buddypress_sidebar','right') == 'no') echo 'twelve'; else echo 'eight'; ?> columns">