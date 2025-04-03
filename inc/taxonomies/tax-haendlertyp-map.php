<?php 

function ___mcd__register_haendlertyp_map_taxonomy(){

    register_taxonomy(
        'haendlertyp-map', ['haendler'],
        array(
            'labels' => array(
                'name' => 'Karten Pins',
                'menu_name' => 'Karten Pins'
            ),
            'public' => true,
            'show_in_menu' => true,
            'show_admin_column' => true,
        )
    );

}

add_action( 'init', '___mcd__register_haendlertyp_map_taxonomy' );
