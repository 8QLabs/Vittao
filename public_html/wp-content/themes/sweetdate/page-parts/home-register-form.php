<div class="twelve columns">
  <div class="row">
      <div class="five columns form-wrapper">
              
        <div class="form-header">
          	<h4 class="white-text"><?php _e("Create an Account", 'kleo_framework');?></h4>
            <p class=""><?php _e("Registering for this site is easy, just fill in the fields below and we will get a new account set up for you in no time.",'kleo_framework');?></p>
          </div>
          <!--Search form-->
          <form action="<?php if (function_exists('bp_is_active')) bp_signup_page(); else echo get_bloginfo('url')."/wp-login.php?action=register"; ?>" method="post" class="custom form-search">
          
               <div class="row">
              <div class="five mobile-four columns">
                <label class="right inline"><?php _e("Username",'kleo_framework');?>:</label>
              </div>
              <div class="seven mobile-four columns">
                <input name="signup_username" required="required" type="text" placeholder="<?php _e("Required",'kleo_framework');?>">
              </div>
            </div><!--end row-->
            
            <div class="row">
              <div class="five mobile-four columns">
                <label class="right inline"><?php _e("Email Address",'kleo_framework');?>:</label>
              </div>
              <div class="seven mobile-four columns">
                <input name="signup_email" type="text" required="required" placeholder="<?php _e("Required",'kleo_framework');?>">
              </div>
            </div><!--end row-->
 
            
            <div class="row">
              <div class="five mobile-one columns">
                <label class="right inline"><?php _e("Password",'kleo_framework');?>:</label>
              </div>
              <div class="three mobile-one columns">
                <input type="password" name="signup_password" required="required" placeholder="<?php _e("Required",'kleo_framework');?>">
              </div>
              <div class="one mobile-one columns text-center">
                <label class="inline"></label>
              </div>
              <div class="three mobile-one columns">
                <input type="password" name="signup_password_confirm" required="required" placeholder="<?php _e("Confirm",'kleo_framework');?>">
              </div>
            </div><!--end row-->  
            
            <div class="row">
              <div class="seven offset-by-five columns"><button class="button radius"><i class="icon-user"></i> &nbsp;<?php _e("Sign Up",'kleo_framework');?></button>
              <?php do_action('fb_popup_register_button_front'); ?>
              </div>
            </div>
            <span class="notch"></span>
          </form>
          <!--end search form-->
          
          <?php if (function_exists('bp_is_active') && sq_option('home_search_members', 1) == 1): ?>
          <!--Form footer-->
          <div class="form-footer">
            <p>
              <?php do_action('kleo_bps_before_carousel');?>
              <span class="right hide-for-small">
                <a href="#" id="profile-thumbs-prev"><i class="icon-circle-arrow-left icon-large"></i></a>&nbsp;
                <a href="#" id="profile-thumbs-next"><i class="icon-circle-arrow-right icon-large"></i></a>
              </span>
            </p>
            <div class="clearfix"></div>

            <div class="carousel-profiles responsive">
              <ul id="profile-thumbs">

                <?php if ( bp_has_members( bp_ajax_querystring( 'members' ). '&type='.apply_filters('kleo_bps_carousel_members_type','newest').'&per_page='.sq_option('buddypress_perpage') ) ) : ?>
                        <?php while ( bp_members() ) : bp_the_member(); ?>

                            <li><a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar('type=full&width=94&height=94&class='); ?></a></li>
                        <?php endwhile; ?>
                <?php endif; ?>

              </ul>
            </div><!--end carousel-profiles-->
          </div><!--end form-footer-->

            <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery('#profile-thumbs').carouFredSel({
                    responsive: true,
                    width: '100%',
                    mousewheel: true,
                    swipe: {
                        onMouse: true,
                        onTouch: true
                    },
                    scroll: {
                        items: 1,
                        duration: 500,
                        fx: "directscroll",
                        //timeoutDuration: 500,
                        //pauseOnHover: 'immediate',
                    },
                    auto: {
                        pauseOnHover: 'resume',
                        progress: '#timer1'
                    },
                    prev	: {	
                        button	: "#profile-thumbs-prev",
                        key		: "left"
                    },
                    next	: { 
                        button	: "#profile-thumbs-next",
                        key		: "right"
                    },
                    pagination	: "#profile-thumbs-pag",
                    items: {
                        width: 120,
                        height: '100%',	//	optionally resize item-height
                        visible: {
                            min: 3,
                            max: 8
                        }
                    }
                });        
            });
            </script>

          
          <?php else: ?>
          <?php $main_color_rgb = hexToRGB(sq_option('button_bg_color_hover')); ?>
          <div class="form-footer" style="border-left:none;border-right: none;padding:0;background: <?php echo sq_option('button_bg_color'); ?>; <?php echo 'border-bottom: 10px solid rgba('.$main_color_rgb['r'].', '.$main_color_rgb['g'].', '.$main_color_rgb['b'].', 0.3)'; ?>"></div>
          
          <?php endif; ?>
  
        </div><!--end form-wrapper-->
        
 </div><!--end row-->
</div><!--end twelve-->