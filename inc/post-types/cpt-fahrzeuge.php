<?php 

function ___mcd__register_vehicle_post_type(){

    register_post_type(
        'fahrzeuge',
        array(
            'label'  => null,
            'labels' => [
                'name'               => __('Vehicles', 'malibu-carthago-data'),
                'singular_name'      => __('Vehicle', 'malibu-carthago-data'),
                'add_new'            => __('Add new', 'malibu-carthago-data'),
                'add_new_item'       => __('Add new vehicle', 'malibu-carthago-data'),
                'edit_item'          => __('Edit vehicle', 'malibu-carthago-data'),
                'new_item'           => __('New vehicle', 'malibu-carthago-data'),
                'view_item'          => __('View vehicle', 'malibu-carthago-data'),
                'search_items'       => __('Search vehicles', 'malibu-carthago-data'),
                'not_found'          => __('Not found', 'malibu-carthago-data'),
                'not_found_in_trash' => __('Not found in trash', 'malibu-carthago-data'),
                'parent_item_colon'  => __('Parent vehicle', 'malibu-carthago-data'),
                'menu_name'          => __('Vehicles', 'malibu-carthago-data'),
            ],
            'public' => true,
            'show_in_menu' => true
        )
    );

}

add_action( 'init', '___mcd__register_vehicle_post_type' );
