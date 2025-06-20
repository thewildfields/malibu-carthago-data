<?php 

class Dealer {

    public $id;
    public $title;
    public $city;
    public $country_code;
    public $location;
    public $formatted_address;
    public $models;
    public $models_intersect;
    public $distance;
    public $phone;
    public $email;
    public $url;
    public $categories;
    public $tax_marker = null;
    public $dealerModels = null;

    function __construct($dealer){

        $address = get_post_meta( $dealer->ID, 'haendler_adresse',true);
        $dealerModelsForProcessing = [];

        $modelsData = get_field('fahrzeugbestand', $dealer->ID);

        if($modelsData){
            foreach ($modelsData as $modelData) {
                $modelObject = $modelData['modell'];
                $modelID = $modelObject->ID;
                $motorisierung = $modelData['motorisierung'];
                if($motorisierung){
                    $modelTitlePostFix = $modelData['modelljahr'].', '.$modelData['motorisierung'];
                } else {
                    $modelTitlePostFix = $modelData['modelljahr'];
                }
                $modelTitle = $modelObject->post_title.'('.$modelTitlePostFix.')';
                $dealerModelsForProcessing[$modelID] = $modelTitle;
            }
        }

        $dealer_models = $dealerModelsForProcessing;

        $categories = is_array(get_the_terms( $dealer->ID, 'haendlertyp' )) ? array_reduce(
            get_the_terms( $dealer->ID, 'haendlertyp' ),
            function ($result, $item) {
                $result[$item->term_id] = ucfirst($item->name);
                return $result;
            },
            array()
        ) : [];

        $dealer_meta = get_post_meta($dealer->ID);

        $this->id = $dealer->ID;
        $this->title = $dealer->post_title;
        if( !empty($address) && is_array($address) ){
            $this->city = array_key_exists('city', $address) ? $address['city'] : null;
            $this->country_code = array_key_exists('country_short', $address)
                ? strtolower($address['country_short'])
                : null;
            $this->location = array_key_exists('lat', $address) && array_key_exists('lng', $address)
                ? [
                    'lat' => $address['lat'],
                    'lng' => $address['lng']
                ]
                : 'no location';
            $this->formatted_address = array_key_exists('address', $address)
                ? $address['address']
                : 'no formatted address';
        }
        $this->models = $dealer_models;
        $this->phone = $dealer_meta['phone'][0];
        $this->email = $dealer_meta['email'][0];
        $this->url = $dealer_meta['url'][0];
        $this->categories = $categories;
    }

}