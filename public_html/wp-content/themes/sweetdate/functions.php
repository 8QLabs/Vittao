<?php
/**
 * @package WordPress
 * @subpackage Sweetdate
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Sweetdate 1.0
 */
global $kleo_config;
$kleo_config['image_sizes'] = array('blog_carousel' => array('width' => 310, 'height' => 177));

// Profile fields to show on members loop, below the name
$kleo_config['bp_members_loop_meta'] = array(
    'I am a',
    'Marital status',
    'City'
);
//From which profile field to show member details on members directory page
$kleo_config['bp_members_details_field'] = 'About me';

/* 
 * Arrays with compatibility match fields. Customize these fields to change the match score
 */
$kleo_config['matching_fields']['starting_score'] = 1;
$kleo_config['matching_fields']['sex'] = 'I am a';
$kleo_config['matching_fields']['looking_for'] = 'Looking for a';
$kleo_config['matching_fields']['sex_percentage'] = 49;
//single value fields like select, textbox,radio
$kleo_config['matching_fields']['single_value'] = array (
    'Marital status' => 20,
    'Country' => 10
);
//multiple values fields like multiple select or checkbox
$kleo_config['matching_fields']['multiple_values'] = array (
    'Interests' => 10,
    'Looking for' => 10,
);

// Include theme constants
require_once('framework/constants.php');

//Include Buddypress functions
if (function_exists( 'bp_is_active' ))
{
    locate_template('custom_buddypress/bp-functions.php', true);
}

//Include Woocommerce functions
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
{
    locate_template( 'functions-woocommerce.php', true );
}

//Include our custom shortcodes for this theme
locate_template('functions-shortcodes.php', true);

//Include our Framework logic
require_once('framework/load.php');

if ( ! isset( $content_width ) )
	$content_width = 980;

/**
 * Sets up theme defaults and registers the various WordPress features
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Sweetdate 1.0
 */
function sweetdate_setup() {
    global $kleo_config;
	/*
	 * Makes Sweetdate available for translation.
	 * Translations can be added to the /languages/ directory.
	 */
	load_theme_textdomain( 'kleo_framework', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
    add_theme_support( 'structured-post-formats', array('link', 'video') );
    add_theme_support( 'post-formats', array('aside', 'audio', 'gallery', 'image', 'quote', 'status','link', 'video') );
        
    add_theme_support( 'bbpress' );
    add_theme_support( 'woocommerce' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'kleo_framework' ) );


	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 938, 9999 ); // Unlimited height, soft crop 
    add_image_size( 'blog_carousel', $kleo_config['image_sizes']['blog_carousel']['width'], $kleo_config['image_sizes']['blog_carousel']['height'], true ); // hard crop for articles carousel
}
add_action( 'after_setup_theme', 'sweetdate_setup' );


/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
if (!function_exists('sweetdate_wp_title')):
    
function sweetdate_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'kleo_framework' ), max( $paged, $page ) );

    return $title;
}
    
endif;
add_filter( 'wp_title', 'sweetdate_wp_title', 10, 2 );




if ( !function_exists( 'sweetdate_main_nav' ) ) :
/**
 * wp_nav_menu() callback from the main navigation in header.php
 *
 * Used when the custom menus haven't been configured.
 *
 * @param array Menu arguments from wp_nav_menu()
 * @see wp_nav_menu()
 * @since BuddyPress (1.5)
 */
function sweetdate_main_nav( $args ) {
	$pages_args = array(
		'depth'      => 0,
		'echo'       => false,
		'exclude'    => '',
		'title_li'   => ''
	);
	$menu = wp_page_menu( $pages_args );
	$menu = str_replace( array( '<div class="menu"><ul>', '</ul></div>' ), array( '<ul class="right"><li><a href="'.get_bloginfo('url').'"><i class="icon-home"></i> '.__("HOME", 'kleo_framework').'</a></li>', '</ul>' ), $menu );
	echo $menu;

	do_action( 'bp_nav_items' );
}
endif;

//------------------------------------------------------------------------------



/**
 * Modify some elements for the menu
 */
if (!class_exists('sweetdate_walker_nav_menu')): 
class sweetdate_walker_nav_menu extends Walker_Nav_Menu {

    // add classes to ul sub-menus
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // depth dependent classes
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'dropdown'
            );
        $class_names = implode( ' ', $classes );

        // build html
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
    {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
    
 
    
    // add main/sub classes to li's and links
     function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // depth dependent classes
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        // passed classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // build html
        //$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" '.($args->has_children > 0 ?'class="has-dropdown"': '').'>';
        
        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="'.( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
        
        if ($args->has_children)
        {
            $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
                $args->before,
                $attributes,
                $args->link_before,
                apply_filters( 'the_title', $item->title, $item->ID ),
                $args->link_after,
                $args->after
            );
        }
        else
        {
            $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
               $args->before,
               $attributes,
               $args->link_before,
               apply_filters( 'the_title', $item->title, $item->ID ),
               $args->link_after,
               $args->after
           );           
        }
        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
endif;
//------------------------------------------------------------------------------


if (!function_exists('sweetdate_widgets_init')):
/**
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function sweetdate_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'kleo_framework' ),
		'id' => 'sidebar-1',
		'description' => __( 'Default sidebar', 'kleo_framework' ),
		'before_widget' => '<div id="%1$s" class="widgets clearfix %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>',
	) );
	register_sidebar(array(
		'name' => 'Footer Widget 1',
        'id' => 'footer-1',
		'before_widget' => '<div id="%1$s" class="widgets clearfix %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>',
	));

	register_sidebar(array(
		'name' => 'Footer Widget 2',
        'id' => 'footer-2',
		'before_widget' => '<div id="%1$s" class="widgets clearfix %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>',
	));

	register_sidebar(array(
		'name' => 'Footer Widget 3',
        'id' => 'footer-3',
		'before_widget' => '<div id="%1$s" class="widgets clearfix %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>',
	));

	register_sidebar(array(
		'name' => 'Footer Widget 4',
        'id' => 'footer-4',
		'before_widget' => '<div id="%1$s" class="widgets clearfix %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>',
	));
        
	register_sidebar(array(
		'name' => 'Footer Level 1 - Widget 1',
        'id' => 'footer-level1-1',
		'before_widget' => '<div id="%1$s" class="widgets clearfix %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>',
	));
           
	register_sidebar(array(
		'name' => 'Footer Level 1 - Widget 2',
        'id' => 'footer-level1-2',
		'before_widget' => '<div id="%1$s" class="widgets clearfix %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>',
	));
        
	register_sidebar(array(
		'name' => 'Footer Level 2',
        'id' => 'footer-level-2',
		'before_widget' => '<div id="%1$s" class="widgets clearfix %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>',
	));
    register_sidebar(array(
         'name' => 'Shop Sidebar',
         'id' => 'shop-1',
         'before_widget' => '<div id="%1$s" class="widgets clearfix %2$s">',
         'after_widget' => '</div>',
         'before_title' => '<h5>',
         'after_title' => '</h5>',
     ));
    
}
endif;

add_action( 'widgets_init', 'sweetdate_widgets_init' );

//------------------------------------------------------------------------------



if ( ! function_exists( 'sweetdate_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own sweetdate_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Sweetdate 1.0
 */
function sweetdate_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'kleo_framework' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'kleo_framework' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		

            <?php
            echo '<div class="avatar">'.get_avatar( $comment, 94 ).'</div>';
            echo '<div class="comment-meta"><h5 class="author">'.get_comment_author_link().'</h5>';
            echo '<p class="date">'.sprintf( __( '%1$s at %2$s', 'kleo_framework' ), get_comment_date(), get_comment_time() ).'</p></div>';
            ?>
            <div class="comment-body">
                <?php comment_text(); ?>
                <?php edit_comment_link( __( 'Edit', 'kleo_framework' ), '<p class="edit-link">', '</p>' ); ?>
            </div>

            <div class="reply">
                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'kleo_framework' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
            <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'kleo_framework' ); ?></p>
            <?php endif; ?>
		
	<?php
		break;
	endswitch; // end comment_type check
}
endif;


//------------------------------------------------------------------------------


/**
 * Customize comment reply form 
 * 
 */
add_filter('comment_form_default_fields', 'kleo_comment_field_changes');
if (!function_exists('kleo_comment_field_changes')):
function kleo_comment_field_changes($arg) {

    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    
    $arg['author'] = '<div class="row"><div class="six columns">' . '<label for="author">' . __( 'Name', 'kleo_framework' ) . ( $req ? ' <span class="required"> ('.__("required", 'kleo_framework').')</span>' : '' ) . '</label> ' .
                    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . ( $req ? ' required' : '' ) . '></div>';

    $arg['email']  = '<div class="six columns"><label for="email">' . __( 'Email', 'kleo_framework' ) . ( $req ? ' <span class="required"> ('.__("required", 'kleo_framework').')</span>' : '' ) . '</label> ' .
                    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . ( $req ? ' required' : '' ) . '></div></div>';
    $arg['url'] = '';
    return $arg;
}
endif;

add_filter('comment_form_defaults', 'kleo_comment_changes');
if(!function_exists('kleo_comment_changes')):
function kleo_comment_changes($arg) {
    $arg['label_submit'] =  __( 'Send Message', 'kleo_framework' );
    $arg['comment_notes_before'] = '';
    $arg['comment_notes_after'] = '';
    $arg['comment_field'] = '<div class="row"><div class="twelve columns"><label for="comment">' . _x( 'Comment', 'noun', 'kleo_framework' ) . ' ('.__("required", 'kleo_framework').')</label><textarea id="comment" name="comment" cols="45" rows="8" required aria-required="true"></textarea></div></div>';
    return $arg;
}
endif;


//------------------------------------------------------------------------------

if (!function_exists('kleo_comment_form')):
/**
 * Outputs a complete commenting form for use within a template.
 * Most strings and form fields may be controlled through the $args array passed
 * into the function, while you may also choose to use the comment_form_default_fields
 * filter to modify the array of default fields if you'd just like to add a new
 * one or remove a single field. All fields are also individually passed through
 * a filter of the form comment_form_field_$name where $name is the key used
 * in the array of fields.
 *
 * @param array $args Options for strings, fields etc in the form
 * @param mixed $post_id Post ID to generate the form for, uses the current post if null
 * @return void
 */
function kleo_comment_form( $args = array(), $post_id = null ) {
	global $id;

	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'kleo_framework' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'kleo_framework' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'kleo_framework' ) . '</label>' .
		            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	$required_text = sprintf( ' ' . __('Required fields are marked %s', 'kleo_framework'), '<span class="required">*</span>' );
	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'kleo_framework' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'kleo_framework' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'kleo_framework' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'kleo_framework' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'kleo_framework' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Leave a Reply','kleo_framework' ),
		'title_reply_to'       => __( 'Leave a Reply to %s', 'kleo_framework' ),
		'cancel_reply_link'    => __( 'Cancel reply','kleo_framework' ),
		'label_submit'         => __( 'Post Comment','kleo_framework' ),
	);

	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	?>
		<?php if ( comments_open( $post_id ) ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
			<div id="respond">
				<h4 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h4><br>
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php do_action( 'comment_form_must_log_in_after' ); ?>
				<?php else : ?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="leave-comment clearfix">
						<?php do_action( 'comment_form_top' ); ?>
						<?php if ( is_user_logged_in() ) : ?>
							<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
							<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
						<?php else : ?>
							<?php echo $args['comment_notes_before']; ?>
							<?php
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
							}
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>
						<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
						<?php echo $args['comment_notes_after']; ?>
						
                                                <button type="submit" class="radius button right" name="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>"><?php echo esc_attr( $args['label_submit'] ); ?></button>
                                                <?php comment_id_fields( $post_id ); ?>
						
						<?php do_action( 'comment_form', $post_id ); ?>
					</form>
				<?php endif; ?>
			</div><!-- #respond -->
			<?php do_action( 'comment_form_after' ); ?>
		<?php else : ?>
			<?php do_action( 'comment_form_comments_closed' ); ?>
		<?php endif; ?>
	<?php
}
endif;

if ( ! function_exists( 'sweetdate_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own sweetdate_entry_meta() to override in a child theme.
 *
 * @since Sweetdate 1.0
 */
function sweetdate_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'kleo_framework' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'kleo_framework' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'kleo_framework' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $categories_list ) {
                echo '<li><i class="icon-calendar"></i> '.$date.'</li>';
                echo '<li><i class="icon-user"></i> '.$author.'</li>';
                echo '<li><i class="icon-heart"></i> '.$categories_list.'</li>';
                if ($tag_list) echo '<li><i class="icon-tags"></i> '.$tag_list.'</li>';
                echo '<li><i class="icon-comments"></i> <a href="'.get_permalink().'#comments">'.sprintf( _n( 'One comment', '%1$s comments', get_comments_number(), 'kleo_framework' ),number_format_i18n( get_comments_number() ) ).'</a></li>';
        }
        else {
                echo '<li><i class="icon-calendar"></i> '.$date.'</li>';
                echo '<li><i class="icon-user"></i> '.$author.'</li>';
                if ($tag_list) echo '<li><i class="icon-tags"></i> '.$tag_list.'</li>';
                echo '<li><i class="icon-comments"></i> <a href="'. get_permalink().'#comments">'.sprintf( _n( 'One comment', '%1$s comments', get_comments_number(), 'kleo_framework' ),number_format_i18n( get_comments_number() ) ).'</a></li>';
	}

}
endif;


// -----------------------------------------------------------------------------


if ( ! function_exists( 'add_video_wmode_transparent' ) ) :
    /**
     * Automatically add wmode=transparent to embeded media
     * Automatically add showinfo=0 for youtube
     * @param type $html
     * @param type $url
     * @param type $attr
     * @return type
     */
    function add_video_wmode_transparent($html, $url, $attr) {
      
    if (strpos($html, "youtube.com") !== NULL || strpos($html, "youtu.be") !== NULL) {
        $info = "&amp;showinfo=0";
    }
    else {
        $info = "";
    }
    //add specific classes so the video will fit the container 
    if (strpos($html, "youtube.com") !== NULL || strpos($html, "youtu.be") !== NULL || strpos($html, "vimeo.com") !== NULL ) {
        $html = '<div class="flex-video widescreen vimeo">'.$html.'</div>';
    }
    
    if ( strpos( $html, "<embed src=" ) !== false )
       { return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $html); }
    elseif ( strpos ( $html, 'feature=oembed' ) !== false )
       { return str_replace( 'feature=oembed', 'feature=oembed&amp;wmode=opaque'.$info, $html ); }
    else
       { return $html; }
    }
endif;

add_filter( 'oembed_result', 'add_video_wmode_transparent', 10, 3);

if (!function_exists('kleo_oembed_filter')):
function kleo_oembed_filter( $return, $data, $url ) {
 	$return = str_replace('frameborder="0"', 'style="border: none"', $return);
	return $return;
}
endif;
add_filter('oembed_dataparse', 'kleo_oembed_filter', 90, 3 );



/***************************************************
 * Lost password function - used in Ajax action
 **************************************************/
if (!function_exists('kleo_lost_password_ajax')) : 
function kleo_lost_password_ajax()
{
    global $wpdb;
    $errors = array();
    if ( isset($_POST) ) {

        if ( empty( $_POST['email'] ) )
        {
           _e('<strong>ERROR</strong>: The e-mail field is empty.', 'kleo_framework');
           die();
        }
        else {
            do_action('lostpassword_post');
            // redefining user_login ensures we return the right case in the email
            $user_data = get_user_by('email',trim($_POST['email']));
      
            if (!isset($user_data->user_email) || $user_data->user_email != $_POST['email']) {
                 _e('<strong>ERROR</strong>: Invalid  e-mail.', 'kleo_framework');
                 die();
            } else {
                $user_login = $user_data->user_email;
                do_action('retrieve_password', $user_login);

                //key manipulation
                $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_email = %s", $user_login));
                if(empty($key)) {
                    //generate reset key
                    $key = wp_generate_password(20, false);
                    $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_email' => $user_login));
                }
                
                $message = __('Someone has asked to reset the password for the following site and username.', 'kleo_framework') . "\r\n\r\n";
                $message .= get_option('siteurl') . "\r\n\r\n";
                $message .= sprintf(__('Username: %s', 'kleo_framework'), $user_data->user_login) . "\r\n\r\n";
                $message .= __('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.', 'kleo_framework') . "\r\n\r\n";
                $message .= get_option('siteurl') . "/wp-login.php?action=rp&login=".$user_data->user_login."&key=$key\r\n";

                if (FALSE == wp_mail($user_login, sprintf(__('[%s] Password Reset', 'kleo_framework'), get_option('blogname')), $message)) {
                    echo "<span style='color:red'>".__("Failure! ", 'kleo_framework');
                    echo __("The e-mail could not be sent.", 'kleo_framework');
                    echo "</span>";
                    die();
                } else {
                   echo "<span style='color:green'>". __("Email successfully sent!", 'kleo_framework')."</span>";
                    die();
                }
            }
        }
    }
    die();
}
endif;
add_action("wp_ajax_kleo_lost_password","kleo_lost_password_ajax");
add_action('wp_ajax_nopriv_kleo_lost_password', 'kleo_lost_password_ajax');

function kleo_lost_password_js()
{
?>
<script type="text/javascript">
/* Lost password ajax */
jQuery(document).ready(function(){
    jQuery("#forgot_form #recover").live("click",function(){
        jQuery.ajax({
               url: ajaxurl,
               type: 'POST',
               data: {
                       action: 'kleo_lost_password',
                       email: jQuery("#forgot-email").val(),
               },
               success: function(data){
                       jQuery('#lost_result').html("<p>"+data+"</p>");
               },
               error: function() {
                       jQuery('#lost_result').html('Sorry, an error occurred.').css('color', 'red');
               }

        });
        return false;
	});
});
</script>
    
<?php 
}
add_action('wp_footer', 'kleo_lost_password_js');

/* -----------------------------------------------------------------------------
 * END Lost password section
 */


/**
 *  ACTIONS section
 */

//GLOBAL SIDEBAR

if (sq_option('global_sidebar') == 'left')
{
   add_action('kleo_before_content', 'kleo_sidebar');
}
elseif (sq_option('global_sidebar') == 'right')
{
   add_action('kleo_after_content', 'kleo_sidebar');
}

//get the global sidebar
if (!function_exists('kleo_sidebar')):
function kleo_sidebar()
{
    get_sidebar();
}
endif;

//Buddypress SIDEBAR ACTION
if (sq_option('buddypress_sidebar','right') == 'left')
{
    add_action('kleo_buddypress_before_content', 'kleo_buddypress_sidebar');
}
elseif (sq_option('buddypress_sidebar','right') == 'right')
{
    add_action('kleo_buddypress_after_content', 'kleo_buddypress_sidebar');
}

//get buddypress sidebar
if (!function_exists('kleo_buddypress_sidebar')):
function kleo_buddypress_sidebar()
{
    get_sidebar('buddypress');
}
endif;

// -----------------------------------------------------------------------------

/* Render search form horizontal on members page */
add_action ('bp_before_directory_members_page', 'kleo_members_filter');
if ( !function_exists('kleo_members_filter')):
    function kleo_members_filter()
    {
        global $bp_search_fields;
        
        if ( function_exists('kleo_bp_search_form_horizontal') && bp_is_active ('xprofile') )
        {
        $mode = (isset($bp_search_fields['button_show']) && $bp_search_fields['button_show'] == 1) ? true : false;
        kleo_bp_search_form_horizontal($mode);
        }
    }
endif;


/* If we are on the home page here it will render the search form */
if ( sq_option('home_search',1) == 1) {
    add_action('after_header_content','render_user_search');
}
/* If we are on the home page here it will render the register form */
elseif (sq_option('home_search',1) == 2) {
    add_action('after_header_content','render_user_register');
}
/* If we are on the home page here it will render the mixed form */
elseif (sq_option('home_search',1) == 3) {
	add_action('after_setup_theme', 'kleo_home_form');
}

if ( ! function_exists( 'kleo_home_form' ) ) :
function kleo_home_form()
{
    if (is_user_logged_in()) {
        add_action('after_header_content','render_user_search');
    }
    else {
        add_action('after_header_content','render_user_register');
    }
}
endif;

if ( ! function_exists( 'render_user_search' ) ) :
/**
 * Prints HTML on homepage search form
 *
 * Create your own render_user_search() to override in a child theme.
 *
 * @since Sweetdate 1.0
 */

function render_user_search() 
{
    if (is_page_template('page-templates/front-page.php'))
        get_template_part('page-parts/home-search-form');
}

endif;


if ( ! function_exists( 'render_user_register' ) ) :
/**
 * Prints Register form
 *
 * Create your own render_user_register() to override in a child theme.
 *
 * @since Sweetdate 1.5
 */

function render_user_register() 
{
    if (is_page_template('page-templates/front-page.php'))
        get_template_part('page-parts/home-register-form');
}

endif;

// -----------------------------------------------------------------------------


/* Add Home page Image */
add_action('wp_head', 'kleo_home_page_image', 9);

if (!function_exists('kleo_home_page_image')):
    function kleo_home_page_image()
    {
        global $kleo_sweetdate;
        //HOME PAGE IMAGE
        if(is_page_template('page-templates/front-page.php'))
        {
            //backward compatibile theme check
            if (count(sq_option('home_pic_background')) > 0)
                $kleo_sweetdate->add_bg_css('home_pic_background','#header');
            else
                $kleo_sweetdate->add_css('#header { background-image: url("'.sq_option('home_pic_background_image').'"); background-position: '.sq_option('home_pic_background_image_horizontal').' '.sq_option('home_pic_background_image_vertical').'; background-repeat: '.sq_option('home_pic_background_image_repeat').'; }');

            if ((sq_option('responsive_design') == 1))
            {
                $kleo_sweetdate->add_css('@media only screen and (max-width: 767px) {#header { background-image: none;}}');
            }
        }
    }
endif;
// -----------------------------------------------------------------------------

/* If WPML is active add the language switcher */
add_action('kleo_before_top_links', 'kleo_language_selector');

function kleo_language_selector()
{
    if(defined('ICL_LANGUAGE_CODE')) do_action('icl_language_selector');
}

/*Change RTMedia default template */
add_filter('rtmedia_media_template_include', 'kleo_rtmedia_tpl' );

if (!function_exists('kleo_rtmedia_tpl')): 
    function kleo_rtmedia_tpl()
    {
        if (file_exists(STYLESHEETPATH.'/rtmedia/main.php'))
            return STYLESHEETPATH.'/rtmedia/main.php';
        else 
            return TEMPLATEPATH.'/rtmedia/main.php';
    }
endif;


if (sq_option('ajax_search', 1))
{
    add_filter( 'wp_nav_menu_items', 'kleo_search_menu_item', 10, 2 );
}

/* Ajax search in header */
if(!function_exists('kleo_search_menu_item'))
{
	function kleo_search_menu_item ( $items, $args )
	{
	    if ($args->theme_location == 'primary')
	    {
	        ob_start();
	        get_template_part('page-parts/header-ajaxsearch');
	        $form = ob_get_clean();

	        $items .= '<li id="nav-menu-item-search" class="menu-item kleo-menu-item-search"><a class="search-trigger" href="#"><i class="icon icon-search"></i></a>'.$form.'</li>';
	    }
	    return $items;
	}
}

//Catch ajax requests
add_action( 'wp_ajax_kleo_ajax_search', 'kleo_ajax_search' );
add_action( 'wp_ajax_nopriv_kleo_ajax_search', 'kleo_ajax_search' );
if(!function_exists('kleo_ajax_search'))
{
	function kleo_ajax_search()
	{
        //if "s" input is missing exit
	    if(empty($_REQUEST['s'])) die();
        
        $output = "";
	    $defaults = array('numberposts' => 4, 'post_type' => 'any', 'post_status' => 'publish', 'post_password' => '', 'suppress_filters' => false);
	    $defaults =  apply_filters( 'kleo_ajax_query_args', $defaults);

	    $query = array_merge($defaults, $_REQUEST);
	    $query = http_build_query($query);
	    $posts = get_posts( $query );

        //if there are no posts
	    if(empty($posts))
	    {
	        $output  = "<div class='kleo_ajax_entry ajax_not_found'>";
	        $output .= "<div class='ajax_search_content'>";
            $output .= "<i class='icon icon-exclamation-sign'></i> ";
	        $output .=       __("Sorry, no pages matched your criteria.", 'kleo_framework');
            $output .= "<br>";
	        $output .=      __("Please try searching by different terms.", 'kleo_framework');
	        $output .= "</div>";
	        $output .= "</div>";
	        echo $output;
	        die();
	    }

	    //if there are posts
	    $post_types = array();
	    $post_type_obj = array();
	    foreach($posts as $post)
	    {

	        $post_types[$post->post_type][] = $post;
	        if(empty($post_type_obj[$post->post_type]))
	        {
	            $post_type_obj[$post->post_type] = get_post_type_object($post->post_type);
	        }
	    }

	    foreach($post_types as $ptype => $post_type)
	    {
	        if(isset($post_type_obj[$ptype]->labels->name))
	        {
	            $output .= "<h4>".$post_type_obj[$ptype]->labels->name."</h4>";
	        }
	        else
	        {
	            $output .= "<hr>";
	        }
	        foreach($post_type as $post)
	        {
                $format = get_post_format($post->ID);
                if (get_the_post_thumbnail( $post->ID, 'thumbnail' ))
                {
                    $image = get_the_post_thumbnail( $post->ID, 'thumbnail' );
                }
                else
                {
                    if ($format == 'video')
                        $image = "<i class='icon icon-film'></i>";
                    elseif ($format == 'image' || $format == 'gallery')
                        $image = "<i class='icon icon-picture'></i>";
                    else
                        $image = "<i class='icon-info-sign'></i>";
                }

	            $excerpt = "";
                
	            if(!empty($post->post_content))
	            {
	                $excerpt =  "<br>".char_trim(trim(strip_tags(strip_shortcodes($post->post_content))),40,"...");
	            }
	            $link = apply_filters('kleo_custom_url', get_permalink($post->ID));
                $classes = "format-".$format;
	            $output .= "<div class ='kleo_ajax_entry $classes'>";
                    $output .= "<div class='ajax_search_image'>$image</div>";
                    $output .= "<div class='ajax_search_content'>";
                        $output .= "<a href='$link' class='search_title'>";
                        $output .= get_the_title($post->ID);
                        $output .= "</a>";
                        $output .= "<span class='search_excerpt'>";
                        $output .= $excerpt;
                        $output .= "</span>";
                    $output .= "</div>";
	            $output .= "</div>";
	        }
	    }

	    $output .= "<a class='ajax_view_all' href='".home_url('?s='.$_REQUEST['s'] )."'>".__('View all results','kleo_framework')."</a>";

	    echo $output;
	    die();
	}
}


//add mp4, webm and ogv mimes for uploads
add_filter('upload_mimes','kleo_add_upload_mimes');
if(!function_exists('kleo_add_upload_mimes'))
{
	function kleo_add_upload_mimes($mimes){ return array_merge($mimes, array ('mp4' => 'video/mp4', 'ogv' => 'video/ogg', 'webm' => 'video/webm')); }
}


/*
 * Display breadcrumb
 */
add_action('kleo_before_page','kleo_show_breadcrumb',9);

if (! function_exists('kleo_show_breadcrumb')):
    
/**
 * Renders the breadcrumb
 */
function kleo_show_breadcrumb()
{
    if (sq_option('breadcrumb_status') == 1) 
    {
        if(!is_page_template('page-templates/front-page.php')) { ?>
        <!-- BREADCRUMBS SECTION
        ================================================ -->
        <section>
          <div id="breadcrumbs-wrapp">
            <div class="row">
              <div class="nine columns">
                    <?php kleo_breadcrumb(array('container_class' => 'breadcrumbs hide-for-small')); ?>
              </div>

            <?php do_action('kleo_after_breadcrumb'); ?>

            </div><!--end row-->
          </div><!--end breadcrumbs-wrapp-->
        </section>
        <!--END BREADCRUMBS SECTION-->
        <?php 
        }
    }
}
endif;

/**
 * Text content of widgets is parsed for shortcodes and those shortcodes are ran
 * @since 1.5
 */
add_filter('widget_text', 'do_shortcode');


/**
 * Membership functions
 * @since 2.0
 */

//options array for restrictions: kleo_restrict_sweetdate
global $kleo_pay_settings;
$kleo_pay_settings = array (
    array(
        'title' => __('Restrict members directory','kleo_framework'),
        'front' => __('View members directory','kleo_framework'),
        'name' => 'members_dir'
    ),
    array(
        'title' => __('Restrict viewing other profiles','kleo_framework'),
        'front' => __('View members profile','kleo_framework'),
        'name' => 'view_profiles'
    ),
    array(
        'title' => __('Restrict access to groups directory','kleo_framework'),
        'front' => __('Access group directory','kleo_framework'),
        'name' => 'groups_dir'
    ),
    array(
        'title' => __('Restrict access to single group page','kleo_framework'),
        'front' => __('Access to groups','kleo_framework'),
        'name' => 'view_groups'
    ),
    array(
        'title' => __('Restrict users from viewing site activity','kleo_framework'),
        'front' => __('View site activity','kleo_framework'),
        'name' => 'show_activity'
    ),
    /*array(
        'title' => __('Restrict users from posting status updates','kleo_framework'),
        'front' => __('Post status updates','kleo_framework'),
        'name' => 'post_updates'
    ),*/
    array(
        'title' => __('Restrict users from sending private messages','kleo_framework'),
        'front' => __('Send Private messages','kleo_framework'),
        'name' => 'pm'
    ),
    array(
        'title' => __('Restrict users from adding media to their profile using rtMedia or bpAlbum','kleo_framework'),
        'front' => __('Add media to your profile','kleo_framework'),
        'name' => 'add_media'
    )
);

/**
 * Get saved membership settings
 * @return array
 * @since 2.0
 */
function kleo_memberships($theme='sweetdate')
{
    $restrict_options = get_option('kleo_restrict_'.$theme);
    
    return $restrict_options;
}

if (!function_exists('kleo_pmpro_restrict_rules')):
/**
 * Applies restrictions based on the PMPRO -> Advanced settings
 * @return void
 * @since 2.0
 */
function kleo_pmpro_restrict_rules()
{
  
  if (!function_exists('bp_is_active')) {
    return;
  }
    //full current url
    $actual_link = kleo_full_url();
    //our request uri
    $uri = str_replace(untrailingslashit(home_url()),"",$actual_link);
    
    //restriction match array
    $final = array();
    
    $allowed_chars = apply_filters('kleo_pmpro_allowed_chars', "a-z 0-9~%.:_\-");
    $restrict_options = kleo_memberships();
 
    /* Preg match rules */
    //members directory
    $final["/^\/".bp_get_members_root_slug()."\/?$/"] = array('name' => 'members_dir', 'type' => $restrict_options['members_dir']['type'], 'levels' => isset($restrict_options['members_dir']['levels'])?$restrict_options['members_dir']['levels']:array());
    //members single profile
    $final["/^\/".bp_get_members_root_slug()."\/[".$allowed_chars."\/]+\/?$/"] = array('name' => 'view_profiles', 'type' => $restrict_options['view_profiles']['type'], 'levels' => isset($restrict_options['view_profiles']['levels'])?$restrict_options['view_profiles']['levels']:array());
   
    if (function_exists('bp_get_groups_root_slug'))
    {
      //groups directory
      $final["/^\/".bp_get_groups_root_slug()."\/?$/"] = array('name' => 'groups_dir', 'type' => $restrict_options['groups_dir']['type'], 'levels' => isset($restrict_options['groups_dir']['levels'])?$restrict_options['groups_dir']['levels']:array());
      //groups single page
      $final["/^\/".bp_get_groups_root_slug()."\/[".$allowed_chars."\/]+\/?$/"] = array('name' => 'view_groups', 'type' => $restrict_options['view_groups']['type'], 'levels' => isset($restrict_options['view_groups']['levels'])?$restrict_options['view_groups']['levels']:array());
    }
    
    if (function_exists('bp_get_activity_root_slug'))
    {
      //activity page
      $final["/^\/".bp_get_activity_root_slug()."\/?$/"] = array('name' => 'show_activity', 'type' => $restrict_options['show_activity']['type'], 'levels' => isset($restrict_options['show_activity']['levels'])?$restrict_options['show_activity']['levels']:array());
    }
    
    $final = apply_filters('kleo_pmpro_match_rules',$final);
    
    //no redirection for super-admin
    if (is_super_admin())
    {
        return false;
    }
    
    //restrict media
    if(preg_match("/^\/".bp_get_members_root_slug()."\/". bp_get_loggedin_user_username()."\/media\/?/", $uri) 
          || preg_match("/^\/".bp_get_members_root_slug()."\/". bp_get_loggedin_user_username()."\/album\/?/", $uri)
      )
    {
      kleo_check_access('add_media', $restrict_options);
    }
    //restrict private messages
    elseif(preg_match("/^\/".bp_get_members_root_slug()."\/". bp_get_loggedin_user_username()."\/messages\/compose\/?/", $uri))
    {
       kleo_check_access('pm', $restrict_options);
    }
    
    //allow me to view other parts of my profile
    if (bp_is_my_profile())
    { 
      return false;
    }
    
    //loop trought remaining restrictions
    foreach($final as $rk => $rv)
    {
        if(preg_match($rk, $uri))
        {
            kleo_check_access($rv['name'], $restrict_options);
        }
    }
    
    do_action('kleo_pmro_extra_restriction_rules',$restrict_options);
}
endif;
add_action("init", "kleo_pmpro_restrict_rules");


if (!function_exists('kleo_check_access')) : 
/**
 * Checks $area for applied restrictions based on user status(logged in, membership level)
 * and does the proper redirect
 * @global object $current_user
 * @param string $area
 * @param array $restrict_options
 * @since 2.0
 */
function kleo_check_access($area, $restrict_options=null)
{
  global $current_user;
  if (!$restrict_options) {
    $restrict_options = kleo_memberships();
  }
  //restrict all members
  if ($restrict_options[$area]['type'] == 1) 
  {
      wp_redirect(apply_filters('kleo_pmpro_home_redirect',home_url()));
      exit;
  }

  //is a member
  if ($current_user->membership_level->ID) {

    //if restrict my level
    if ($restrict_options[$area]['type'] == 2 && is_array($restrict_options[$area]['levels']) && !empty($restrict_options[$area]['levels']) && pmpro_hasMembershipLevel($restrict_options[$area]['levels']) )
    {
      wp_redirect(pmpro_url("levels"));
      exit;
    }
    
  //logged in but not a member
  } else if (is_user_logged_in()) {
    if ($restrict_options[$area]['type'] == 2 && $restrict_options[$area]['not_member'] == 1)
    {
      wp_redirect(pmpro_url("levels"));
      exit;
    }
  }
  //guest
  else {
    if ($restrict_options[$area]['type'] == 2 && $restrict_options[$area]['guest'] == 1)
    {
      wp_redirect(pmpro_url("levels"));
      exit;
    }
  }
}
endif;

if (!function_exists('kleo_membership_info')) : 
/**
 * Add membership info next to profile page username
 * @since 2.0
 */
function kleo_membership_info()
{
  global $membership_levels,$current_user;
  if (! $membership_levels) {
    return;
  }
  
  if (bp_is_my_profile())
  {
    if (isset($current_user->membership_level) && $current_user->membership_level->ID)
    {
      echo '<a href="'.pmpro_url("account").'"><span class="label radius pmpro_label">'.$current_user->membership_level->name.'</span></a>';
    }
    else
    {
      echo '<a href="'.pmpro_url("levels").'"><span class="label radius pmpro_label">Upgrade account</span></a>';
    }
  }
}
endif;
add_action('kleo_bp_after_profile_name', 'kleo_membership_info');


if(!function_exists('kleo_copyright_text')):
/**
 * Add footer text
 */
function kleo_copyright_text()
{
  echo '<p>'. __("Copyright", 'kleo_framework').' &copy; '.date("Y").' '. get_bloginfo('name').'. <br class="hide-for-large show-for-small"/>'. get_bloginfo( 'description' ).'</p>';        
}
endif;
add_action('kleo_footer_text','kleo_copyright_text');

?>
