<?php 

function ___mcd__register_motorisierung_taxonomy(){

    register_taxonomy(
        'motorisierung', ['fahrzeuge'],
        array(
            'labels' => array(
                'name' => 'Motorisierung',
                'menu_name' => 'Motorisierung'
            ),
            'public' => true,
            'show_in_menu' => true,
            'show_admin_column' => true,
        )
    );

}

add_action( 'init', '___mcd__register_motorisierung_taxonomy' );
