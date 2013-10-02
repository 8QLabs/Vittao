<div class="entry-summary">
<?php the_excerpt( sprintf(__( 'continue reading %s', 'groundwork' ), '<span class="meta-nav">&rarr;</span>' )  ); ?>
<?php if(is_search()) {
wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'groundwork' ) . '&after=</div>');
}
?>
</div> 