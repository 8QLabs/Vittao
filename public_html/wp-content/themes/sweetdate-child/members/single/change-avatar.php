<h4><?php _e( 'Change Picture', 'buddypress' ); ?></h4>

<?php do_action( 'bp_before_profile_avatar_upload_content' ); ?>

<?php if ( !(int)bp_get_option( 'bp-disable-avatar-uploads' ) ) : ?>

	<p><?php _e( 'Your picture will be used on your profile.', 'buddypress'); ?></p>

	<form action="" method="post" id="avatar-upload-form" class="standard-form" enctype="multipart/form-data">

		<?php if ( 'upload-image' == bp_get_avatar_admin_step() ) : ?>

			<?php wp_nonce_field( 'bp_avatar_upload' ); ?>
			<p><?php _e( 'Click below to select a JPG, GIF or PNG format photo from your computer and then click \'Upload Image\' to proceed.', 'buddypress' ); ?></p>

			<p id="avatar-upload">
				<input type="file" name="file" id="file" />
				<input type="submit" name="upload" class="button tiny radius" id="upload" value="<?php _e( 'Upload Image', 'buddypress' ); ?>" />
				<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
			</p>

			<?php if ( bp_get_user_has_avatar() ) : ?>
				<p><?php _e( "If you'd like to delete your current picture but not upload a new one, please use the Delete Picture button.", 'buddypress' ); ?></p>
				<p><a class="button small radius edit" href="<?php bp_avatar_delete_link(); ?>" title="<?php _e( 'Delete Picture', 'buddypress' ); ?>"><?php _e( 'Delete My Picture', 'buddypress' ); ?></a></p>
			<?php endif; ?>

		<?php endif; ?>

		<?php if ( 'crop-image' == bp_get_avatar_admin_step() ) : ?>

			<h5><?php _e( 'Crop Your New Picture', 'buddypress' ); ?></h5>

                        
			<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php _e( 'Picture to crop', 'buddypress' ); ?>" />

			<div id="avatar-crop-pane">
				<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php _e( 'Avatar preview', 'buddypress' ); ?>" />
			</div>

			<input type="submit" class="button smalll radius" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php _e( 'Crop Image', 'buddypress' ); ?>" />

			<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />

			<?php wp_nonce_field( 'bp_avatar_cropstore' ); ?>

		<?php endif; ?>

	</form>

<?php else : ?>

	<p><?php _e( 'Your picture will be used on your profile.', 'buddypress' ); ?></p>

<?php endif; ?>

<?php do_action( 'bp_after_profile_avatar_upload_content' ); ?>
