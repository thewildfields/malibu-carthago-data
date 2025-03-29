<?php 

function ___mcd__register_fahrzeugklasse_taxonomy(){

    register_taxonomy(
        'fahrzeugklasse', ['fahrzeuge'],
        array(
            'labels' => array(
                'name' => 'Fahrzeugklasse',
                'menu_name' => 'Fahrzeugklasse'
            ),
            'public' => true,
            'show_in_menu' => true,
            'show_admin_column' => true,
        )
    );

}

add_action( 'init', '___mcd__register_fahrzeugklasse_taxonomy' );
