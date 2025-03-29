<?php 

function ___mcd__register_fahrzeugart_taxonomy(){

    register_taxonomy(
        'fahrzeugart', ['fahrzeuge'],
        array(
            'labels' => array(
                'name' => 'Fahrzeugart',
                'menu_name' => 'Fahrzeugart'
            ),
            'public' => true,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
        )
    );

}

add_action( 'init', '___mcd__register_fahrzeugart_taxonomy' );
