<?php
/*
 *
 * Require the framework class before doing anything else, so we can use the defined URLs and directories.
 * If you are running on Windows you may have URL problems which can be fixed by defining the framework url first.
 *
 */
if(!class_exists('Kleo_Options')) {
    require_once(dirname(__FILE__) . '/options/defaults.php');
}

$patterns = array(
        'black' => array('title' => 'Black', 'img' => SQUEEN_OPTIONS_URL . 'img/patterns/black_pattern.png'),
        'blue' => array('title' => 'Blue', 'img' => SQUEEN_OPTIONS_URL . 'img/patterns/blue_pattern.png'),
        'gray' => array('title' => 'Gray', 'img' => SQUEEN_OPTIONS_URL . 'img/patterns/gray_pattern.png'),
        'green' => array('title' => 'Green', 'img' => SQUEEN_OPTIONS_URL . 'img/patterns/green_pattern.png'),
        'pink' => array('title' => 'Pink', 'img' => SQUEEN_OPTIONS_URL . 'img/patterns/pink_pattern.png'),
        'p1' => array('title' => 'Pattern 1', 'img' => SQUEEN_OPTIONS_URL . 'img/patterns/pattern1.gif'),
);


/*
 *
 * Most of your editing will be done in this section.
 *
 * Here you can override default values, uncomment args and change their values.
 * No $args are required, but they can be overridden if needed.
 *
 */
function setup_framework_options() {
    $args = array();

    // Setting dev mode to true allows you to view the class settings/info in the panel.
    // Default: true
    $args['dev_mode'] = false;

    $args['dev_mode_icon_class'] = 'icon-large';

    // Theme update information
    if ( false === ( $kleo_update = get_transient( 'sweetdate_update' ) ) ) {
        
        if (@$kleo_update = file_get_contents('http://seventhqueen.com/updates/sweetdate.php'))
        {
            set_transient( 'sweetdate_update', $kleo_update, 60*60*24*7 );
        }
    }

    if ($kleo_update)
    {
        $args['footer_text'] = '<p>'.$kleo_update.'</p>';
    }
    
    // Set footer/credit line.
    $args['footer_credit'] = '';

    // Setup custom links in the footer for share icons
    $args['share_icons']['twitter'] = array(
        'link' => 'http://twitter.com/SeventhQueen',
        'title' => __('Follow me on Twitter', 'kleo_framework'),
        'img' => SQUEEN_OPTIONS_URL . 'img/social/Twitter.png'
    );
    $args['share_icons']['facebook'] = array(
        'link' => 'http://www.facebook.com/seventhqueen.themes',
        'title' => __('Find me on Facebook', 'kleo_framework'),
        'img' => SQUEEN_OPTIONS_URL . 'img/social/Facebook.png'
    );
    $args['share_icons']['dribbble'] = array(
        'link' => 'http://dribbble.com/seventhqueen',
        'title' => __('Find me on Dribbble', 'kleo_framework'),
        'img' => SQUEEN_OPTIONS_URL . 'img/social/Dribbble.png'
    );


    $args['import_icon_class'] = 'icon-large';

    // Set a custom option name. Don't forget to replace spaces with underscores!
    $args['opt_name'] = KLEO_DOMAIN;

    // Set a custom menu icon.
    $args['menu_icon'] = SQUEEN_OPTIONS_URL . '/img/sweetdate_menu_icon.jpg';

    // Set a custom title for the options page.
    // Default: Options
    $args['menu_title'] = __('Sweetdate', 'kleo_framework');

    // Set a custom page title for the options page.
    // Default: Options
    $args['page_title'] = __('Sweetdate', 'kleo_framework');

    // Set a custom page slug for options page (wp-admin/themes.php?page=***).
    // Default: kleo_options
    $args['page_slug'] = 'sweetdate_options';

    // Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
    $args['help_tabs'][] = array(
        'id' => 'squeen-opts-1',
        'title' => __('SeventhQueen support', 'kleo_framework'),
        'content' => __('<p>Please visit our <a href="http://seventhqueen.com/support">forum for theme support</a></p>', 'kleo_framework')
    );
    $sections = array();
    
    $sections[] = array(
		// Font Awesome iconfont to supply default icons.
		// If $args['icon_type'] = 'iconfont', this should be the icon name minus 'icon-'.
		// If $args['icon_type'] = 'image', this should be the path to the icon.
		// Icons can also be overridden on a section-by-section basis by defining 'icon_type' => 'image'
		'icon_type' => 'image',
		'icon' => SQUEEN_OPTIONS_URL . '/img/sweetdate_menu_icon.jpg',
		// Set the class for this icon.
		// This field is ignored unless $args['icon_type'] = 'iconfont'
		'icon_class' => 'icon-large',
                 'title' => __('General settings', 'kleo_framework'),
                'desc' => __('<p class="description">Here you will set your site-wide preferences.</p>', 'kleo_framework'),
		'fields' => array(

            array(
                'id' => 'logo',
                'type' => 'upload',
                'title' => __('Logo', 'kleo_framework'), 
                'sub_desc' => __('Upload your own logo (294x108 recommended size).', 'kleo_framework'),
            ),
            array(
                'id' => 'logo_retina',
                'type' => 'upload',
                'title' => __('Logo Retina', 'kleo_framework'), 
                'sub_desc' => __('Upload retina logo. This is optional and should be double in size than normal logo.', 'kleo_framework'),
            ),
           array(
                'id' => 'small_logo',
                'type' => 'upload',
                'title' => __('Small Logo', 'kleo_framework'), 
                'sub_desc' => __('Upload your small logo for sticky main menu.', 'kleo_framework'),
            ),
            array(
                'id' => 'favicon',
                'type' => 'upload',
                'title' => __('Favicon', 'kleo_framework'), 
                'sub_desc' => __('.ico image that will be used as favicon (32px32px).', 'kleo_framework'),
                'std' => get_bloginfo('template_url').'/assets/images/icons/favicon.ico'
            ),
            array(
                'id' => 'apple57',
                'type' => 'upload',
                'title' => __('Apple Iphone Icon', 'kleo_framework'), 
                'sub_desc' => __('Apple Iphone Icon (57px57px).', 'kleo_framework'),
                'std' => get_bloginfo('template_url').'/assets/images/icons/apple-touch-icon-57x57.png'
            ),
            array(
                'id' => 'apple114',
                'type' => 'upload',
                'title' => __('Apple Iphone Retina Icon', 'kleo_framework'), 
                'sub_desc' => __('Apple Iphone Retina Icon (114px114px).', 'kleo_framework'),
                'std' => get_bloginfo('template_url').'/assets/images/icons/apple-touch-icon-114x114.png'
            ),     
            array(
                'id' => 'apple72',
                'type' => 'upload',
                'title' => __('Apple iPad Icon', 'kleo_framework'), 
                'sub_desc' => __('Apple Iphone Retina Icon (72px72px).', 'kleo_framework'),
                'std' => get_bloginfo('template_url').'/assets/images/icons/apple-touch-icon-72x72.png'
            ),    
            array(
                'id' => 'apple144',
                'type' => 'upload',
                'title' => __('Apple iPad Retina Icon', 'kleo_framework'), 
                'sub_desc' => __('Apple iPad Retina Icon (144px144px).', 'kleo_framework'),
                'std' => get_bloginfo('template_url').'/assets/images/icons/apple-touch-icon-144x144.png'
            ),

            array(
                'id' => 'analytics',
                'type' => 'textarea',
                'title' => __('Analytics code', 'kleo_framework'), 
                'sub_desc' => __('Paste your Google Analytics or other tracking code.<br/> This will be loaded in the footer.', 'kleo_framework'),
                'desc' => ''
            ),                    
                    
		)
    );
    
    $sections[] = array(
        'icon' => 'th-large',
        'icon_class' => 'icon-large',
         'title' => __('Layout settings', 'kleo_framework'),
        'desc' => __('<p class="description">Here you set options for the layout.</p>', 'kleo_framework'),   

        'fields' => array(
            array(
                'id' => 'responsive_design',
                'type' => 'checkbox',
                'title' => __('Responsive Design', 'kleo_framework'), 
                'sub_desc' => __('Enable or disable responsive design', 'kleo_framework'),
                'switch' => true,
                'std' => '1' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'site_style',
                'type' => 'radio_img_hide_bellow',
                'title' => __('Site Layout', 'kleo_framework'), 
                'sub_desc' => __('Select between wide or boxed site layout', 'kleo_framework'),
                'options' => array(
                    'wide-style' => array('title' => 'Wide', 'img' => SQUEEN_OPTIONS_URL . 'img/wide_layout.png','allow' => 'false'),
                    'boxed-style' => array('title' => 'Boxed', 'img' => SQUEEN_OPTIONS_URL . 'img/boxed_layout.png', 'allow' => 'true'),
                ),
                'std' => 'wide-style',
                'next_to_hide' => '1'
            ),
            
           //BOXED BACKGROUND
            array(
                'id' => 'boxed_background',
                'type' => 'bg',
                'title' => __('Boxed background type', 'kleo_framework'), 
                'sub_desc' => __('Select the type of background you want to use for boxed background.', 'kleo_framework'),
                'desc' => '',
                'std' => array(
                    'type' =>'pattern', //image,pattern,color
                    'pattern' => 'p1', 
                    'image' => '',
                    'img_repeat' => 'repeat',
                    'img_vertical' => 'top',
                    'img_horizontal' => 'center',
                    'img_size' => 'auto',
                    'img_attachment' => 'scroll',
                    'color' => '#EEEEEE'
                )
            ),

           array(
                'id' => 'global_sidebar',
                'type' => 'radio_img',
                'title' => __('Default layout', 'kleo_framework'), 
                'sub_desc' => __('Select the layout to use by default. This can be changed individualy on page/post edit', 'kleo_framework'),
                'options' => array(
                    'no' => array('title' => 'No sidebar', 'img' => SQUEEN_OPTIONS_URL . 'img/1col.png'),
                    'left' => array('title' => 'Left Sidebar', 'img' => SQUEEN_OPTIONS_URL . 'img/2cl.png'),
                    'right' => array('title' => 'Right Sidebar', 'img' => SQUEEN_OPTIONS_URL . 'img/2cr.png')
                    
                ), // Must provide key => value(array:title|img) pairs for radio options
                'std' => 'right'
            ),
            array(
                'id' => 'sticky_menu',
                'type' => 'checkbox',
                'title' => __('Sticky Menu', 'kleo_framework'), 
                'sub_desc' => __('Enable or disable the main menu to stay at top of the screen while you scroll down.', 'kleo_framework'),
                'switch' => true,
                'std' => '1' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'ajax_search',
                'type' => 'checkbox',
                'title' => __('Ajax Search in menu', 'kleo_framework'), 
                'sub_desc' => __('Enable or disable the button for search.', 'kleo_framework'),
                'switch' => true,
                'std' => '1' // 1 = checked | 0 = unchecked
            ),
            
            
            
        )
        
    );
    
    
   $sections[] = array(
        'icon' => 'adjust',
        'icon_class' => 'icon-large',
        'title' => __('Styling options', 'kleo_framework'),
        'desc' => __('<p class="description">Customize theme appearance</p>', 'kleo_framework'),
        'fields' => array(

            //SKIN STYLE
            /*array(
                'id' => 'skin_style',
                'type' => 'button_set',
                'title' => __('Skins', 'kleo_framework'), 
                'sub_desc' => __('Select from predefined blue and white skins<br/> The configurable options bellow will change if you select a skin.', 'kleo_framework'),
                'desc' => '',
                'options' => array(
                    'blue' => 'Blue Header',
                    'white' => 'White Header'
                    ), // Must provide key => value pairs for select options
                'std' => 'blue'
            ),*/
            
            //header
            array(
                'id' => 'info_header',
                'type' => 'info',
                'desc' => __('<h4 class="subtitle">Header section</h4>', 'kleo_framework')
            ),
            array(
                'id' => 'header_background', 
                'type' => 'bg',
                'title' => __('Background', 'kleo_framework'), 
                'sub_desc' => __('Select the background you want to use for header.', 'kleo_framework'),
                'desc' => '',
                'std' => array(
                    'type' =>'pattern', //image,pattern,color
                    'pattern' => 'blue', 
                    'image' => '',
                    'img_repeat' => 'repeat',
                    'img_vertical' => 'top',
                    'img_horizontal' => 'center',
                    'img_size' => 'auto',
                    'img_attachment' => 'scroll',
                    'color' => '#0076A3'
                )
            ),
            
            //header colors
            array(
                'id' => 'header_font_color',
                'type' => 'color',
                'title' => __('Header Text color', 'kleo_framework'), 
                'sub_desc' => __('Select text color to use in header. This color also applies to home search form text because it resides in header section', 'kleo_framework'),
                'std' => '#ffffff'
            ),
            array(
                'id' => 'header_primary_color',
                'type' => 'color',
                'title' => __('Top Menu Link Color', 'kleo_framework'), 
                'sub_desc' => __('Select your main color to use for top menu links and other elements.', 'kleo_framework'),
                'std' => '#ffffff'
            ),
            array(
                'id' => 'menu_color_enabled',
                'type' => 'color',
                'title' => __('Top Menu Link Color when visible background', 'kleo_framework'), 
                'sub_desc' => __('Select your link color to use when the background is visible.', 'kleo_framework'),
                'std' => '#ffffff'
            ),
            array(
                'id' => 'menu_primary_color',
                'type' => 'color',
                'title' => __('Top Menu Background Color', 'kleo_framework'), 
                'sub_desc' => __('Select your main color to use for top menu', 'kleo_framework'),
                'std' => '#1FA8D1'
            ),
            array(
                'id' => 'header_secondary_color',
                'type' => 'color',
                'title' => __('Top Menu Link Color on hover', 'kleo_framework'), 
                'sub_desc' => __('Select your color to use for top menu links on hover.', 'kleo_framework'),
                'std' => '#ffffff'
            ),
            array(
                'id' => 'menu_secondary_color',
                'type' => 'color',
                'title' => __('Top Menu Background Color on hover ', 'kleo_framework'), 
                'sub_desc' => __('Select your background color to use for top menu on mouse hover.', 'kleo_framework'),
                'std' => '#37b8dd'
            ),


            
            
            //breadcrumb section
            array(
                'id' => 'info_breadcrumb',
                'type' => 'info',
                'desc' => __('<h4 class="subtitle">Breadcrumb section</h4>', 'kleo_framework')
            ),
            array(
                'id' => 'breadcrumb_status',
                'type' => 'checkbox',
                'title' => __('Enable breadcrumb', 'kleo_framework'), 
                'sub_desc' => __('Enable or disable breadcrumb.', 'kleo_framework'),
                'switch' => true,
                'std' => '1' // 1 = checked | 0 = unchecked
            ),
            
            array(
                'id' => 'breadcrumb_background',
                'type' => 'bg',
                'title' => __('Background', 'kleo_framework'), 
                'sub_desc' => __('Select the background you want to use for breadcrumb.', 'kleo_framework'),
                'desc' => '',
                'std' => array(
                    'type' =>'color', //image,pattern,color
                    'pattern' => 'blue', 
                    'image' => '',
                    'img_repeat' => 'repeat',
                    'img_vertical' => 'top',
                    'img_horizontal' => 'center',
                    'img_size' => 'auto',
                    'img_attachment' => 'scroll',
                    'color' => '#0095C2'
                )
            ),
            //main colors
            array(
                'id' => 'breadcrumb_font_color',
                'type' => 'color',
                'title' => __('Text color', 'kleo_framework'), 
                'sub_desc' => __('Select text color to use in main content area', 'kleo_framework'),
                'std' => '#f0f0f0'
            ),
            array(
                'id' => 'breadcrumb_primary_color',
                'type' => 'color',
                'title' => __('Primary Color', 'kleo_framework'), 
                'sub_desc' => __('Select your main color to use for links and other elements.', 'kleo_framework'),
                'std' => '#ffffff'
            ),    
            array(
                'id' => 'breadcrumb_secondary_color',
                'type' => 'color',
                'title' => __('Highlight Color', 'kleo_framework'), 
                'sub_desc' => __('Select your secondary color to use for hover links and other elements.', 'kleo_framework'),
                'std' => '#7de0fe'
            ),     
            
            //body section
            array(
                'id' => 'info_body',
                'type' => 'info',
                'desc' => __('<h4 class="subtitle">Main section</h4>', 'kleo_framework')
            ),
            array(
                'id' => 'body_background',
                'type' => 'bg',
                'title' => __('Background', 'kleo_framework'), 
                'sub_desc' => __('Select the background you want to use for main area.', 'kleo_framework'),
                'desc' => '',
                'std' => array(
                    'type' =>'color', //image,pattern,color
                    'pattern' => 'gray', 
                    'image' => '',
                    'img_repeat' => 'repeat',
                    'img_vertical' => 'top',
                    'img_horizontal' => 'center',
                    'img_size' => 'auto',
                    'img_attachment' => 'scroll',
                    'color' => '#ffffff'
                )
            ),
             //body colors
            array(
                'id' => 'body_font_color',
                'type' => 'color',
                'title' => __('Text color', 'kleo_framework'), 
                'sub_desc' => __('Select text color to use.', 'kleo_framework'),
                'std' => '#777777'
            ),
            array(
                'id' => 'body_primary_color',
                'type' => 'color',
                'title' => __('Primary Color', 'kleo_framework'), 
                'sub_desc' => __('Select your main color to use for links and other elements.', 'kleo_framework'),
                'std' => '#333333'
            ),    
            array(
                'id' => 'body_secondary_color',
                'type' => 'color',
                'title' => __('Highlight Color', 'kleo_framework'), 
                'sub_desc' => __('Select your secondary color to use for hover links and other elements.', 'kleo_framework'),
                'std' => '#0296C0'
            ),       
             //sidebar colors
            array(
                'id' => 'sidebar_font_color',
                'type' => 'color',
                'title' => __('Sidebar Text color', 'kleo_framework'), 
                'sub_desc' => __('Select text color to use for sidebar.', 'kleo_framework'),
                'std' => '#777777'
            ),
            array(
                'id' => 'sidebar_primary_color',
                'type' => 'color',
                'title' => __('Sidebar Primary Color', 'kleo_framework'), 
                'sub_desc' => __('Select your main color to use for links and other elements in sidebar.', 'kleo_framework'),
                'std' => '#666666'
            ),    
            array(
                'id' => 'sidebar_secondary_color',
                'type' => 'color',
                'title' => __('Sidebar Highlight Color', 'kleo_framework'), 
                'sub_desc' => __('Select your secondary color to use for hover links and other elements in sidebar.', 'kleo_framework'),
                'std' => '#0296C0'
            ),   
            
            
             //footer bg 
            array(
                'id' => 'info_footer',
                'type' => 'info',
                'desc' => __('<h4 class="subtitle">Footer section</h4>', 'kleo_framework')
            ),
            array(
                'id' => 'footer_background',
                'type' => 'bg',
                'title' => __('Background', 'kleo_framework'), 
                'sub_desc' => __('Select the background you want to use for footer.', 'kleo_framework'),
                'desc' => '',
                'std' => array(
                    'type' =>'pattern', //image,pattern,color
                    'pattern' => 'black', 
                    'image' => '',
                    'img_repeat' => 'repeat',
                    'img_vertical' => 'top',
                    'img_horizontal' => 'center',
                    'img_size' => 'auto',
                    'img_attachment' => 'scroll',
                    'color' => '#171717'
                )
            ),
            //footer colors
            array(
                'id' => 'footer_font_color',
                'type' => 'color',
                'title' => __('Footer Text color', 'kleo_framework'), 
                'sub_desc' => __('Select text color to use in footer', 'kleo_framework'),
                'std' => '#777777'
            ),
            array(
                'id' => 'footer_primary_color',
                'type' => 'color',
                'title' => __('Footer Primary Color', 'kleo_framework'), 
                'sub_desc' => __('Select your main color to use for links and other elements.', 'kleo_framework'),
                'std' => '#F00056'
            ),    
            array(
                'id' => 'footer_secondary_color',
                'type' => 'color',
                'title' => __('Footer Highlight Color', 'kleo_framework'), 
                'sub_desc' => __('Select your secondary color to use for hover links and other elements.', 'kleo_framework'),
                'std' => '#0296C0'
            ),       
            
            
            /* BUTTONS */
            array(
                'id' => 'info_buttons',
                'type' => 'info',
                'desc' => __('<h4 class="subtitle">Buttons section</h4>', 'kleo_framework')
            ),
            //PRIMARY BUTTON
            array(
                'id' => 'button_bg_color',
                'type' => 'color',
                'title' => __('Button Background Color', 'kleo_framework'), 
                'sub_desc' => __('Select the background color for your primary button.', 'kleo_framework'),
                'std' => '#0296c0'
            ),
            array(
                'id' => 'button_text_color',
                'type' => 'color',
                'title' => __('Button Text Color', 'kleo_framework'), 
                'sub_desc' => __('Select the text color for your primary button.', 'kleo_framework'),
                'std' => '#ffffff'
            ),
            array(
                'id' => 'button_bg_color_hover',
                'type' => 'color',
                'title' => __('Button Hover Background Color', 'kleo_framework'), 
                'sub_desc' => __('Select the background color for your primary button on hover.', 'kleo_framework'),
                'std' => '#1FA8D1'
            ),
            array(
                'id' => 'button_text_color_hover',
                'type' => 'color',
                'title' => __('Button Hover Text Color', 'kleo_framework'), 
                'sub_desc' => __('Select the text color for your primary button on hover.', 'kleo_framework'),
                'std' => '#ffffff'
            ),
            //SECONDARY BUTTON
            array(
                'id' => 'button_secondary_bg_color',
                'type' => 'color',
                'title' => __('Secondary Button Background Color', 'kleo_framework'), 
                'sub_desc' => __('Select the background color for your secondary button.', 'kleo_framework'),
                'std' => '#E6E6E6'
            ),
            array(
                'id' => 'button_secondary_text_color',
                'type' => 'color',
                'title' => __('Secondary Button Text Color', 'kleo_framework'), 
                'sub_desc' => __('Select the text color for your secondary button.', 'kleo_framework'),
                'std' => '#1D1D1D'
            ),
            array(
                'id' => 'button_secondary_bg_color_hover',
                'type' => 'color',
                'title' => __('Secondary Button Hover Background Color', 'kleo_framework'), 
                'sub_desc' => __('Select the background color for your secondary button on hover.', 'kleo_framework'),
                'std' => '#DDDCDC'
            ),
            array(
                'id' => 'button_secondary_text_color_hover',
                'type' => 'color',
                'title' => __('Secondary Button Hover Text Color', 'kleo_framework'), 
                'sub_desc' => __('Select the text color for your secondary button on hover.', 'kleo_framework'),
                'std' => '#1D1D1D'
            ),
            
            //headings
            array(
                'id' => 'info_heading',
                'type' => 'info',
                'desc' => __('<h4 class="subtitle">Heading section</h4>', 'kleo_framework')
            ),
            array(
                'id' => 'heading',
                'type' => 'typography',
                'title' => __('Headings Font', 'kleo_framework'), 
                'sub_desc' => __('Select font to use', 'kleo_framework'),
                'desc' => '',
                'std' => array(
                    'h1' => array('size' => '46px', 'style' => 'normal', 'color' => '#222222', 'font' => 'Lato:regular'),
                    'h2' => array('size' => '30px', 'style' => 'normal', 'color' => '#222222', 'font' => 'Lato:regular'),
                    'h3' => array('size' => '26px', 'style' => 'normal', 'color' => '#222222', 'font' => 'Lato:regular'),
                    'h4' => array('size' => '20px', 'style' => 'normal', 'color' => '#222222', 'font' => 'Open Sans:regular'),
                    'h5' => array('size' => '17px', 'style' => 'normal', 'color' => '#222222', 'font' => 'Open Sans:regular'),
                    'h6' => array('size' => '14px', 'style' => 'normal', 'color' => '#222222', 'font' => 'Open Sans:regular'),
                    'body' => array('size' => '13px', 'style' => 'normal', 'color' => '#777777', 'font' => 'Open Sans:regular'),
                )
            ),
            array(
                'id' => 'quick_css',
                'type' => 'textarea',
                'title' => __('Quick css', 'kleo_framework'), 
                'sub_desc' => __('Place you custom css here', 'kleo_framework'),
                'desc' => ''
            ),     
          
       
        )
    );
   
    $sections[] = array(
        'icon' => 'home',
        'icon_class' => 'icon-large',
        'title' => __('Homepage', 'kleo_framework'),
        'desc' => __('<p class="description">Homepage settings.</p>', 'kleo_framework'),
        'fields' => array(
            
            array(
                'id' => 'home_search',
                'type' => 'select_hide_below',
                'title' => __('Search Form', 'kleo_framework'), 
                'sub_desc' => __('Choose what to display in the Homepage form:<br> Disabled - Do not show any form<br>Search form - Show a configurable search form<br>Register form - Display a register form<br> Mixed form - If the user is logged in show a search form, else show the register form ', 'kleo_framework'),
                'options' => array (
                    '0' => array('name' => "Disabled", 'allow' => 'false'),
                    '1' => array('name' => "Search form", 'allow' => 'true'),
                    '2' => array('name' => "Register form", 'allow' => 'true'),
                    '3' => array('name' => "Mixed form", 'allow' => 'true'),
                    
                )
 
            ),
            array(
                'id' => 'home_search_members',
                'type' => 'checkbox',
                'title' => __('Latest Members carousel', 'kleo_framework'), 
                'sub_desc' => __('Enable or disable members carousel in search form.', 'kleo_framework'),
                'switch' => true,
                'std' => '1' // 1 = checked | 0 = unchecked
            ),
            
            
            array(
                'id' => 'home_pic_background',
                'type' => 'bg',
                'title' => __('Home Image', 'kleo_framework'), 
                'sub_desc' => __('Select the image that appears beside the search form.', 'kleo_framework'),
                'desc' => '',
                'std' => array(
                    'type' =>'image', //image,pattern,color
                    'pattern' => 'gray', 
                    'image' => get_bloginfo('template_url').'/assets/images/header_image_bg.png',
                    'img_repeat' => 'no-repeat',
                    'img_vertical' => 'bottom',
                    'img_horizontal' => 'center',
                    'img_size' => 'contain',
                    'img_attachment' => 'scroll',
                    'color' => 'transparent'
                )
            )
        )
    );
    
if (function_exists( 'bp_is_active' )):
 
    $sections[] = array(
        'icon' => 'user',
        'icon_class' => 'icon-large',
        'title' => __('Buddypress', 'kleo_framework'),
        'desc' => __('<p class="description">Here you can customize Buddypress settings</p><p><a class="button button-primary" id="bp_import_fields" href="#">Import Buddypress profile fields</a></p>', 'kleo_framework'),
        'fields' => array(
            
            array(
                'id' => 'bp_album',
                'type' => 'checkbox',
                'title' => __('BP-Album', 'kleo_framework'), 
                'sub_desc' => __('Enable or disable Buddypress Album.', 'kleo_framework'),
                'switch' => true,
                'std' => '1' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'buddypress_sidebar',
                'type' => 'radio_img',
                'title' => __('Buddypress Pages Layout', 'kleo_framework'), 
                'sub_desc' => __('Select the layout to use in Buddypress pages.', 'kleo_framework'),
                'options' => array(
                    'no' => array('title' => 'No sidebar', 'img' => SQUEEN_OPTIONS_URL . 'img/1col.png'),
                    'left' => array('title' => 'Left Sidebar', 'img' => SQUEEN_OPTIONS_URL . 'img/2cl.png'),
                    'right' => array('title' => 'Right Sidebar', 'img' => SQUEEN_OPTIONS_URL . 'img/2cr.png')
                ), // Must provide key => value(array:title|img) pairs for radio options
                'std' => 'right'
            ),
            
            array(
                'id' => 'bp_search_form',
                'type' => 'text',
                'title' => __('Search form customization', 'kleo_framework'),
                'sub_desc' => __('Set you own profile fields to search after', 'kleo_framework'),
                'std' => array(
                    'before_form' => 'Serious dating with <strong>Sweet date</strong><br>Your perfect match is just a click away',
                    'agelabel' => 'Age',
                   
                ),
                'callback' => 'bp_customize_form'
            ),
           array(
                'id' => 'bp_sex_field',
                'type' => 'text',
                'title' => __('Sex field', 'kleo_framework'),
                'sub_desc' => __('Select you sex field. This is used for man,woman online statistics', 'kleo_framework'),
                'std' => 'I am a',
                'callback' => 'bp_profile_field'
            ),
           array(
                'id' => 'bp_age_field',
                'type' => 'text',
                'title' => __('Age field', 'kleo_framework'),
                'sub_desc' => __('Select you Age field. This is used to display members age', 'kleo_framework'),
                'std' => 'Birthday',
                'callback' => 'bp_profile_date_field'
            ),
  
            array(
                'id' => 'buddypress_age_start',
                'type' => 'text',
                'title' => __('Members search - Inferior age search limit', 'kleo_framework'),
                'sub_desc' => __('Enter the inferior age limit to search members for.', 'kleo_framework'),
                'validate' => 'numeric',
                'msg' => 'Please enter a numeric value',
                'std' => '18'
            ),   
            array(
                'id' => 'buddypress_age_end',
                'type' => 'text',
                'title' => __('Members search - Superior age search limit', 'kleo_framework'),
                'sub_desc' => __('Enter the superior age limit to search members for', 'kleo_framework'),
                'validate' => 'numeric',
                'msg' => 'Please enter a numeric value',
                'std' => '75'
            ),          
            array(
                'id' => 'buddypress_perpage',
                'type' => 'text',
                'title' => __('Members per page', 'kleo_framework'),
                'sub_desc' => __('Enter the number of profiles per page to show on members listing.', 'kleo_framework'),
                'validate' => 'numeric',
                'msg' => 'Please enter a numeric value',
                'std' => '12'
            ),    
            
            //buddy header bg 
            array(
                'id' => 'bp_header',
                'type' => 'info',
                'desc' => __('<h4 class="subtitle">Profile header background</h4>', 'kleo_framework')
            ),
            
            array(
                'id' => 'bp_header_background',
                'type' => 'bg',
                'title' => __('Background', 'kleo_framework'), 
                'sub_desc' => __('Select the background you want to use for buddypress header.', 'kleo_framework'),
                'desc' => '',
                'std' => array(
                    'type' =>'color', //image,pattern,color
                    'pattern' => 'gray', 
                    'image' => '',
                    'img_repeat' => 'repeat',
                    'img_vertical' => 'top',
                    'img_horizontal' => 'center',
                    'img_size' => 'auto',
                    'img_attachment' => 'scroll',
                    'color' => '#0095c2'
                )
            ),
             //buddy colors
            array(
                'id' => 'bp_header_font_color',
                'type' => 'color',
                'title' => __('Text color', 'kleo_framework'), 
                'sub_desc' => __('Select text color to use.', 'kleo_framework'),
                'std' => '#ffffff'
            ),
            array(
                'id' => 'bp_header_primary_color',
                'type' => 'color',
                'title' => __('Primary Color', 'kleo_framework'), 
                'sub_desc' => __('Select your main color to use for links and other elements.', 'kleo_framework'),
                'std' => '#ffffff'
            ),    
            array(
                'id' => 'bp_header_secondary_color',
                'type' => 'color',
                'title' => __('Highlight Color', 'kleo_framework'), 
                'sub_desc' => __('Select your secondary color to use for hover links and other elements.', 'kleo_framework'),
                'std' => '#09a9d9'
            ),
            
            array(
                'id' => 'bp_items_transparency',
                'type' => 'select',
                'title' => __('Items transparency', 'kleo_framework'), 
                'sub_desc' => __('Select the transparency for profile header elements.', 'kleo_framework'),
                'options' => array('0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1' => '1'),
                'std' => '0.1'
            ),
        )
    );
endif;

   $sections[] = array(
        'icon' => 'envelope',
        'icon_class' => 'icon-large',
        'title' => __('Contact info &amp; Social', 'kleo_framework'),
        'desc' => __('<p class="description">Here you can set your contact info.</p>', 'kleo_framework'),
        'fields' => array(
            
            array(
                'id' => 'social_top',
                'type' => 'checkbox',
                'title' => __('Top Social Bar', 'kleo_framework'), 
                'sub_desc' => __('Enable or disable top toolbar with social and contact info.', 'kleo_framework'),
                'switch' => true,
                'std' => '1' // 1 = checked | 0 = unchecked
            ),
            
            array(
                'id' => 'owner_email',
                'type' => 'text',
                'title' => __('Email', 'kleo_framework'),
                'sub_desc' => __('This will be displayed all over the site.', 'kleo_framework'),
                'validate' => 'email',
                'msg' => 'Please enter a valid email address'
            ),
            array(
                'id' => 'owner_phone',
                'type' => 'text',
                'title' => __('Phone', 'kleo_framework'),
                'sub_desc' => __('This will be displayed all over the site.', 'kleo_framework'),
            ),
                     
            array(
                'id' => 'twitter',
                'type' => 'text',
                'title' => __('Twitter address', 'kleo_framework'),
                'sub_desc' => __('Your Twitter URL address.', 'kleo_framework'),
                'validate' => 'url',
                'msg' => 'Please enter a valid URL'
            ),
            array(
                'id' => 'facebook',
                'type' => 'text',
                'title' => __('Facebook address', 'kleo_framework'),
                'sub_desc' => __('Your Facebook URL address.', 'kleo_framework'),
                'validate' => 'url',
                'msg' => 'Please enter a valid URL'
            ),
            array(
                'id' => 'googleplus',
                'type' => 'text',
                'title' => __('Google+ address', 'kleo_framework'),
                'sub_desc' => __('Your Google+ URL address.', 'kleo_framework'),
                'validate' => 'url',
                'msg' => 'Please enter a valid URL'
            ),
            array(
                'id' => 'pinterest',
                'type' => 'text',
                'title' => __('Pinterest address', 'kleo_framework'),
                'sub_desc' => __('Your Pinterest URL address.', 'kleo_framework'),
                'validate' => 'url',
                'msg' => 'Please enter a valid URL'
            ),
            array(
                'id' => 'linkedin',
                'type' => 'text',
                'title' => __('LinkedIn address', 'kleo_framework'),
                'sub_desc' => __('Your LinkedIn URL address.', 'kleo_framework'),
                'validate' => 'url',
                'msg' => 'Please enter a valid URL'
            ),  
            array(
                'id' => 'gps_lat',
                'type' => 'text',
                'title' => __('GPS Latitude', 'kleo_framework'),
                'sub_desc' => __('GPS Latitude used for Contact page - Google Maps.Ex: 32.990236', 'kleo_framework'),
            ),  
          array(
                'id' => 'gps_lon',
                'type' => 'text',
                'title' => __('GPS Longitude', 'kleo_framework'),
                'sub_desc' => __('GPS Longitude used for Contact page - Google Maps.Ex: -96.679687', 'kleo_framework'),
            )  
            
        )
    );
   
    $sections[] = array(
		// Font Awesome iconfont to supply default icons.
		// If $args['icon_type'] = 'iconfont', this should be the icon name minus 'icon-'.
		// If $args['icon_type'] = 'image', this should be the path to the icon.
		// Icons can also be overridden on a section-by-section basis by defining 'icon_type' => 'image'
        'icon' => 'cogs',
		'icon_type' => 'iconfont',
		'icon_class' => 'icon-large',
                 'title' => __('Miscellaneous', 'kleo_framework'),
                'desc' => __('<p class="description">Facebook, Mailchimp, Themeforest settings</p>', 'kleo_framework'),
		'fields' => array(
                    array(
                        'id' => 'admin_bar',
                        'type' => 'checkbox',
                        'title' => __('Admin toolbar', 'kleo_framework'), 
                        'sub_desc' => __('Enable or disable wordpress default top toolbar', 'kleo_framework'),
                        'switch' => true,
                        'std' => '1' // 1 = checked | 0 = unchecked
                    ),
                    array(
                        'id' => 'squared_images',
                        'type' => 'checkbox',
                        'title' => __('Use squared avatar images', 'kleo_framework'), 
                        'sub_desc' => __('Enable to show square avatars instead of rounded', 'kleo_framework'),
                        'switch' => true,
                        'std' => '0' // 1 = checked | 0 = unchecked
                    ),
                    array(
                        'id' => 'facebook_login',
                        'type' => 'checkbox_hide_below',
                        'title' => __('Facebook integration', 'kleo_framework'), 
                        'sub_desc' => __('Enable or disable Login/Register with Facebook', 'kleo_framework'),
                        'switch' => true,
                        'std' => '0', // 1 = checked | 0 = unchecked
                        'next_to_hide' => 2
                    ),
                    array(
                        'id' => 'fb_app_id',
                        'type' => 'text',
                        'title' => __('Facebook APP ID', 'kleo_framework'), 
                        'sub_desc' => __('In order to integrate with Facebook you need to enter your Facebook APP ID<br/>If you don\'t have one, you can create it from: <a target="_blank" href="https://developers.facebook.com/apps">HERE</a> ', 'kleo_framework'),
                        'std' => ''
                    ),
                    array(
                        'id' => 'facebook_register',
                        'type' => 'checkbox',
                        'title' => __('Enable Registration via Facebook', 'kleo_framework'), 
                        'sub_desc' => __('If you enable this, users will be able to register a new account using Facebook. This skips the registration page including required profile fields', 'kleo_framework'),
                        'switch' => true,
                        'std' => '0' // 1 = checked | 0 = unchecked
                    ),
                    array(
                        'id' => 'mailchimp_api',
                        'type' => 'text',
                        'title' => __('Mailchimp API KEY', 'kleo_framework'), 
                        'sub_desc' => __('To use mailchimp newsletter subscribe widget you have to enter your API KEY', 'kleo_framework'),
                        'std' => ''
                    ),
                    
                    array(
                        'id' => 'terms_page',
                        'type' => 'pages_select',
                        'title' => __('Terms and conditions page', 'kleo_framework'), 
                        'sub_desc' => __('Select the page that is used for terms and conditions.<br/>This will be used in register modal', 'kleo_framework'),
                        'std' => '#',
                        'args' => array()
                    ),
                    array(
                        'id' => 'privacy_page',
                        'type' => 'pages_select',
                        'title' => __('Privacy page', 'kleo_framework'), 
                        'sub_desc' => __('Select the page that is used for privacy info.<br/>This will be used in login modal', 'kleo_framework'),
                        'std' => '#',
                        'args' => array()
                    ),
            
                    array(
                        'id' => 'tf_username',
                        'type' => 'text',
                        'title' => __('Themeforest Username', 'kleo_framework'), 
                        'sub_desc' => __('To automatically get theme updates you need to enter the username and API KEY from your themeforest account', 'kleo_framework'),
                        'std' => ''
                    ),
                    array(
                        'id' => 'tf_apikey',
                        'type' => 'text',
                        'title' => __('Themeforest API KEY', 'kleo_framework'), 
                        'sub_desc' => '',
                        'std' => ''
                    ),
                    array(
                        'id' => 'tdf_consumer_key',
                        'type' => 'text',
                        'title' => __('Twitter Consumer Key', 'kleo_framework'),
                        'sub_desc' => '',
  
                    ),
                    array(
                        'id' => 'tdf_consumer_secret',
                        'type' => 'text',
                        'title' => __('Twitter Consumer Secret', 'kleo_framework'),
                        'sub_desc' => '',

                    ),
                    array(
                        'id' => 'tdf_access_token',
                        'type' => 'text',
                        'title' => __('Twitter Access Token', 'kleo_framework'),
                        'sub_desc' => ''
                    ),            
                    array(
                        'id' => 'tdf_access_token_secret',
                        'type' => 'text',
                        'title' => __('Twitter Token Secret', 'kleo_framework'),
                        'sub_desc' => ''
                    ),
                    array(
                        'id' => 'tdf_user_timeline',
                        'type' => 'text',
                        'title' => __('Twitter username', 'kleo_framework'),
                        'sub_desc' => ''
                    ),           
                    array(
                        'id' => 'tdf_cache_expire',
                        'type' => 'text',
                        'title' => __('Tweets cache time', 'kleo_framework'),
                        'sub_desc' => 'Recommended 1 hour = 3600 seconds',
                        'std' => '3600'
                    ),     
		)
    );

  
    $tabs = array();

    if (function_exists('wp_get_theme')){
        $theme_data = wp_get_theme();
        $description = $theme_data->get('Description');
        $author = $theme_data->get('Author');
        $author_uri = $theme_data->get('AuthorURI');
        $version = $theme_data->get('Version');
        $tags = $theme_data->get('Tags');
    }else{
        $theme_data = get_theme_data(trailingslashit(get_stylesheet_directory()) . 'style.css');
        $description = $theme_data['Description'];
        $author = $theme_data['Author'];
        $author_uri = $theme_data['AuthorURI'];
        $version = $theme_data['Version'];
        $tags = $theme_data['Tags'];
     }
    
    $item_info = '<div class="squeen-opts-section-desc">';
    $item_info .= '<p class="squeen-opts-item-data description item-author">' . __('<strong>Author:</strong> ', 'kleo_framework') . ($author_uri ? '<a href="' . $author_uri . '" target="_blank">' . $author . '</a>' : $author) . '</p>';
    $item_info .= '<p class="squeen-opts-item-data description item-version">' . __('<strong>Version:</strong> ', 'kleo_framework') . $version . '</p>';
    $item_info .= '<p class="squeen-opts-item-data description item-description">' . $description . '</p>';
    $item_info .= '<p class="squeen-opts-item-data description item-tags">' . __('<strong>Tags:</strong> ', 'kleo_framework') . implode(', ', $tags) . '</p>';
    $item_info .= '</div>';

    $tabs['item_info'] = array(
		'icon' => 'info-sign',
		'icon_class' => 'icon-large',
        'title' => __('Theme Information', 'kleo_framework'),
        'content' => $item_info
    );
    
    if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
        $tabs['docs'] = array(
			'icon' => 'book',
			'icon_class' => 'icon-large',
            'title' => __('Documentation', 'kleo_framework'),
            'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
        );
    }

    global $Kleo_Options;
    $Kleo_Options = new Kleo_Options($sections, $args, $tabs);

}
add_action('init', 'setup_framework_options', 0);


function bp_customize_form($field, $value) 
{   
    if (!isset($value))
        $value = $field['std'];
    
    echo '<div style="width:45%;float:left"><h4>MAIN FORM</h4>';
    echo '<strong>'.__('Text before form', 'kleo_framework').'</strong>';
    echo '<textarea name="'.KLEO_DOMAIN.'['.$field['id'].'][before_form]" class="large-text" rows="4">'.(isset($value['before_form'])? $value['before_form']:'').'</textarea>';

    echo '<strong>'.__('Select your form fields', 'kleo_framework').'</strong><br>';
    kleo_selected_form_fields (KLEO_DOMAIN.'['.$field['id'].'][fields]', (isset($value['fields'])?$value['fields']:'' ));
    echo '</div>';
    
    echo '<div style="width:45%;float:left;margin-left:15px"><h4>HORIZONTAL FORM</h4>';
    echo '<strong>'.__('Text before form', 'kleo_framework').'</strong>';
    echo '<textarea name="'.KLEO_DOMAIN.'['.$field['id'].'][before_form_horizontal]" class="large-text" rows="4">'.(isset($value['before_form_horizontal'])? $value['before_form_horizontal']:'').'</textarea>';
 
    echo '<strong>'.__('Select your form fields', 'kleo_framework').'</strong><br>';
    kleo_selected_form_fields (KLEO_DOMAIN.'['.$field['id'].'][fields_horizontal]', (isset($value['fields_horizontal'])?$value['fields_horizontal']:'' ));
    echo '<br><label><input type="checkbox" name="'.KLEO_DOMAIN.'['.$field['id'].'][button_show]'.'" '.(isset($value['button_show']) && $value['button_show']==1?'checked="checked"':'').' value="1"> Display search button at end(if not checked then the form will autosubmit on field change)</label>';
    echo '</div>';

    echo '<div style="clear:both"></div>';
    echo '<hr style="border:none;border-bottom:1px solid #DFDFDF;" >';
    
    echo __('<h4>Select Age Range Field<span style="font-size:0.8em"> (optional)</span></h4>', 'kleo_framework');
    kleo_bp_agerange (KLEO_DOMAIN.'['.$field['id'].'][agerange]', (isset($value['agerange'])?$value['agerange']:'' ) );
    echo '<br>'.__('Age label', 'kleo_framework').'<br>';
    echo '<input type="text" name="'.KLEO_DOMAIN.'['.$field['id'].'][agelabel]" value="'.(isset($value['agelabel'])?$value['agelabel']:'' ).'">';
    echo '<hr style="border:none;border-bottom:1px solid #DFDFDF;" >';
    
    echo __('<h4>Select Numerical Field<span style="font-size:0.8em"> (optional)</span></h4>', 'kleo_framework');
    kleo_bp_numrange (KLEO_DOMAIN.'['.$field['id'].'][numrange]', (isset($value['numrange'])?$value['numrange']:'' ));
    echo '<hr style="border:none;border-bottom:1px solid #DFDFDF;" >';
    
    echo '<h4>Select Matching Fields<span style="font-size:0.8em"> (optional)</span></h4>When you search by first field it will look in the matching one. Example: I am a -> Looking for a<br>';
    kleo_bp_numrange (KLEO_DOMAIN.'['.$field['id'].'][match1][1]', (isset($value['match1'][1])?$value['match1'][1]:'' ));
    kleo_bp_numrange (KLEO_DOMAIN.'['.$field['id'].'][match1][2]', (isset($value['match1'][2])?$value['match1'][2]:'' ));
    echo '<hr style="border:none;border-bottom:1px solid #DFDFDF;" >';
       
    echo '<br>To show the form you have different options:<br>
        <strong>Shortcode</strong><br>[kleo_search_members] or [kleo_search_members_horizontal]<br> 
        <strong>Widget</strong><br>Go to Appearance -> Widgets to set it up<br>
        <strong>In PHP files</strong><br>Paste the following code where you want the forms to show:<br>
        <code>do_action(\'kleo_bp_search_form\'); </code><br>or<br><code>do_action(\'kleo_search_form_horizontal\');</code>'; 
}

//Profile fields callback
function bp_profile_field($field, $value) 
{
    if (!isset($value))
        $value = $field['std'];
    
    kleo_bp_numrange (KLEO_DOMAIN.'['.$field['id'].']', (isset($value)?$value:'' ));
}

//Profile fields callback
function bp_profile_date_field($field, $value) 
{
    if (!isset($value))
        $value = $field['std'];
    
    kleo_bp_agerange (KLEO_DOMAIN.'['.$field['id'].']', (isset($value)?$value:'' ));
}