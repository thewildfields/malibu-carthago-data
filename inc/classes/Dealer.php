<?php 

class Dealer {

    public $title;
    public $city;
    public $country_code;
    public $location;
    public $formatted_address;
    public $models;
    public $models_intersect;
    public $distance;
    // public $dealer_categories;

    function __construct($dealer){

        $address = get_post_meta( $dealer->ID, 'haendler_adresse',true);
        $dealerModelsForProcessing = get_post_meta( $dealer->ID, 'haendler_fahrzeuge', true);
        
        $dealer_models = is_array($dealerModelsForProcessing) ? array_reduce(
            $dealerModelsForProcessing,
            function ($result, $item) {
                $result[$item] = get_the_title($item);
                return $result;
            },
            array()
        ) : [];

        $dealer_categories = is_array(get_the_terms( $dealer->ID, 'haendlertyp' )) ? array_reduce(
            get_the_terms( $dealer->ID, 'haendlertyp' ),
            function ($result, $item) {
                $result[$item->term_id] = ucfirst($item->name);
                return $result;
            },
            array()
        ) : [];

        $this->title = $dealer->post_title;
        $this->city = array_key_exists('city', $address) ? $address['city'] : 'no city';
        $this->country_code = array_key_exists('country_short', $address)
            ? $address['country_short']
            : 'no country code';
        $this->location = array_key_exists('lat', $address) && array_key_exists('lng', $address)
            ? [
                'lat' => $address['lat'],
                'lng' => $address['lng']
            ]
            : 'no location';
        $this->formatted_address = array_key_exists('address', $address)
            ? $address['address']
            : 'no formatted address';
        $this->models = $dealer_models;
        // $this->dealer_categories = $dealer_categories;
    }

}