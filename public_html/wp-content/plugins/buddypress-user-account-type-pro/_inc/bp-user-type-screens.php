<?php

function buatp_directory_setup() {
    $buatp_general_settings = get_option('buatp_basic_setting',true);
    global $bp;
    if ( bp_is_buatp_component() && !$bp->current_action) {
        if($buatp_general_settings['buatp_default_type_selection'])
            bp_core_redirect(buatp_get_type_directory_url($buatp_general_settings['buatp_default_type_selection']));
        else
            bp_core_redirect(site_url());
    }else if(bp_is_buatp_component() && $bp->current_action){
        $slug = $bp->current_action;
        $types = buatp_get_all_types( buatp_get_field_id_by_name( $buatp_general_settings[buatp_type_field_selection] ));
        $found = 0;
        foreach( $types as $type ){
            if( $slug === buatp_text_to_slug($type['name']) )
                $found = 1;
        }
        if( $found == 1 ){
            do_action( 'buatp_directory_setup' );
            bp_core_load_template( apply_filters( 'buatp_directory_template', 'members/members-loop' ) );
        }
        else
            bp_core_redirect(site_url());
    }
}
add_action( 'bp_screens', 'buatp_directory_setup' );


?>