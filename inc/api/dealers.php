<?php 

require_once ___MCD__PLUGIN_DIR_PATH . 'inc/classes/Dealer.php';
require_once ___MCD__PLUGIN_DIR_PATH . 'inc/functions/calc-distance.php';

function ___mc__api(){
    register_rest_route(
        'malibu-carthago/v1',
        '/dealers',
        array(
            'methods' => 'GET',
            'callback' => '___mc__api_get_dealers',
            'premission_callback' => '__return_true'
        )
    );
}

add_action( 'rest_api_init', '___mc__api' );

function ___mc__api_get_dealers( WP_REST_Request $request){

    global $post;
    
    $dealersQueryArgs = array(
        'post_type' => 'haendler',
        'posts_per_page' => -1
    );

    $dealersResponse = array();

    $dealers = array();

    $dealersQuery = new WP_Query($dealersQueryArgs);

    if( $dealersQuery->have_posts() ) : while( $dealersQuery->have_posts() ) : $dealersQuery->the_post();
    
        $dealer = new Dealer($post);

        // Name Filtering

        if( $request->has_param('dealerName') && strlen($request['dealerName']) > 0){
            if( !str_contains( strtolower($dealer->title) , strtolower($request['dealerName']))){
                continue;
            }
        }

        // Country filtering

        if(
            !$request['loadAll'] &&
            (!$request->has_param('includeNeighbors') || !$request->has_param('includeNeighbors'))
        ){
            if($request['countryCode'] !== $dealer->country_code){
                continue;
            }
        }

        // Models Filtering
        if( $request['model'] ){
            if( !is_array($dealer->models) || !sizeof($dealer->models) ){ continue; }
            $requestModels = explode('+', $request['model']);
            $dealerModelKeys = array_keys($dealer->models);
            $dealerModelValues = array_values($dealer->models);
            $modelsIntersect = array_intersect($requestModels, $dealerModelKeys);
            $outputListNew = array();
            if( $modelsIntersect ){
                foreach ($dealerModelValues as $index => $title) {
                    if( in_array($dealerModelKeys[$index], $requestModels) ){
                        array_push($outputListNew, '<strong>'.$title.'</strong>');
                    } else {
                        array_push($outputListNew, $title);
                    }
                }
                $dealer->models_intersect = implode(', ', $outputListNew);
            } else {
                continue;
            }
        }
        unset($dealer->models);



        // Dealer Category Filtering
        if( $request->has_param('haendlertyp') && sizeof( explode('+', $request['haendlertyp'])) > 0 ){
            if( !array_intersect(explode('+', $request['haendlertyp']), array_keys($dealer->categories) )){
                continue;
            }
        }

        // Distance Filtering

        if( $request['lat'] && $request['lng'] ){
            $calculatedDistance = ___mc__calc_distance(
                $request['lat'], $request['lng'],
                $dealer->location['lat'], $dealer->location['lng']
            );
            if( $request['radius'] && $request['radius'] < $calculatedDistance){
                continue;
            } else {
                $dealer->distance = $calculatedDistance;
            }
        }

        // Marker Icons

        if( $request['taxMarker'] ){
            $terms = get_the_terms( $dealer->id, $request['taxMarker'] );
            if( $terms ){
                $termId = $terms[0]->term_id;
                $markerField = get_field('map_marker', $request['taxMarker'].'_'.$termId);
                if($markerField){
                    $dealer->tax_marker = $markerField;
                }
            } else {
                continue;
            }
        }

        $dealers[] = $dealer;

    endwhile; wp_reset_postdata(); endif;
    
    // Sort and Limit

    usort($dealers, function ($a, $b){
        return $a->distance <=> $b->distance;
    });
    $dealersResponse['resultsCount'] = sizeof($dealers);
    if( $request['limit'] ){
        $dealers = array_slice($dealers, 0, $request['limit']);
    }

    $dealersResponse['totalCount'] = sizeof($dealersQuery->posts);
    $dealersResponse['items'] = $dealers;

    return new WP_REST_Response($dealersResponse);

}