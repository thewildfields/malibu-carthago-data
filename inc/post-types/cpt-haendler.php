<?php 

function ___mcd__register_dealer_post_type(){

    register_post_type(
        'haendler',
        array(
            'label'  => null,
            'labels' => [
                'name'               => __('Dealers', 'malibu-carthago-data'),
                'singular_name'      => __('Dealer', 'malibu-carthago-data'),
                'add_new'            => __('Add new', 'malibu-carthago-data'),
                'add_new_item'       => __('Add new dealer', 'malibu-carthago-data'),
                'edit_item'          => __('Edit dealer', 'malibu-carthago-data'),
                'new_item'           => __('New dealer', 'malibu-carthago-data'),
                'view_item'          => __('View dealer', 'malibu-carthago-data'),
                'search_items'       => __('Search dealers', 'malibu-carthago-data'),
                'not_found'          => __('Not found', 'malibu-carthago-data'),
                'not_found_in_trash' => __('Not found in trash', 'malibu-carthago-data'),
                'parent_item_colon'  => __('Parent dealer', 'malibu-carthago-data'),
                'menu_name'          => __('Dealers', 'malibu-carthago-data'),
            ],
            'public' => true,
            'show_in_menu' => true
        )
    );

}

add_action( 'init', '___mcd__register_dealer_post_type' );
