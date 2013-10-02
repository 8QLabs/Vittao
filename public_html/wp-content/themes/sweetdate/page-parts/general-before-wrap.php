<?php
/**
 * Before content wrap
 * Used in all templates
 */
?>


<!-- MAIN SECTION
================================================ -->
<section class="<?php echo apply_filters('kleo_main_section_class', '');?>">
    <div id="main">
        
        <?php
        /**
         * Before main part - action
         */
        do_action('kleo_before_main');
        ?>
        
        <div class="row">
            
            <?php /* Before content - action */ ?>
            <?php do_action('kleo_before_content'); ?>
            
            <!--begin content-->
            <?php 
            if (sq_option('global_sidebar') == 'no') 
                $content_class = 'twelve'; 
            else 
                $content_class = 'eight';
            ?>
            <div class="<?php echo apply_filters('kleo_content_class',$content_class); ?> columns">