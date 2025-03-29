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

        // Models Filtering
        if( $request['model'] ){
            if( !is_array($dealer->models) || !sizeof($dealer->models) ){ continue; }
            $requestModels = explode('+', $request['model']);
            $dealerModels = array_keys($dealer->models);
            $modelsIntersect = array_intersect($requestModels, $dealerModels);
            if( $modelsIntersect ){
                $dealer->models_intersect = implode(', ', array_values( array_intersect_key($dealer->models, array_flip($modelsIntersect))));
            } else {
                continue;
            }
        }
        unset($dealer->models);

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

        $dealers[] = $dealer;

    endwhile; wp_reset_postdata(); endif;
    
    // Sort and Limit

    usort($dealers, function ($a, $b){
        return $a->distance <=> $b->distance;
    });
    $dealersResponse['resultsCount'] = sizeof($dealers);
    $dealers = array_slice($dealers, 0, 5);

    $dealersResponse['totalCount'] = sizeof($dealersQuery->posts);
    $dealersResponse['items'] = $dealers;

    return new WP_REST_Response($dealersResponse);

}