<?php 

function ___mcd__register_haendlertyp_taxonomy(){

    register_taxonomy(
        'haendlertyp', ['haendler'],
        array(
            'labels' => array(
                'name' => 'Handlertyp',
                'menu_name' => 'Handlertyp'
            ),
            'public' => true,
            'show_in_menu' => true,
            'show_admin_column' => true,
        )
    );

}

add_action( 'init', '___mcd__register_haendlertyp_taxonomy' );
