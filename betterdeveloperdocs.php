<?php
/*
Plugin Name:  Bdd
Plugin URI:   https://betterdeveloperdocs.com 
Description:  Custom Functionality for https://betterdeveloperdocs.com 
Version:      1.0
Author:       https://betterdeveloperdocs.com  
Author URI:   https://betterdeveloperdocs.com 
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  custom
Domain Path:  /languages
*/

define('BDD_PLUGIN_DIR', plugin_dir_path(realpath(__FILE__)));
include_once(BDD_PLUGIN_DIR . 'bddClasses.php');
include_once(BDD_PLUGIN_DIR . 'bddShortCodes.php');

function bddScripts(){
	
	// if(class_exists('hostSelectorView')){
		
		// if(is_page('home')){	
			// wp_enqueue_script( 'homeSchema', '/wp-content/plugins/bddPlugin/scripts/homeSchema.js', array( 'jquery' ), '1.0', true );

		// }else{
			// wp_enqueue_script( 'hostPlan', plugins_url( 'scripts/blogSchema.js', __FILE__ ), array( 'jquery' ), '1.0', true );
		// }
	// }

	wp_enqueue_style( 'hostPlan', plugins_url( 'scripts/hostPlanSelector.css', __FILE__ ), '1.0' );
	wp_enqueue_script( 'jqueryFromFilterBucks', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js', array('jquery'), '1.0', false );
	wp_enqueue_script( 'filterBucks', plugins_url( 'scripts/vendor/user-selection-filter-bucks/js/filterbucks.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'hostPlanSelector', plugins_url( 'scripts/hostPlanSelector.js', __FILE__ ), array(), '1.0', true );
}

add_action( 'wp_enqueue_scripts', 'bddScripts', 10 );

// moving some data around in the DB for SEO reasons
// add_action('rest_api_init', function () {

// 	register_rest_route( 'custombdd/v1', 'move-seo-data/',array(
// 		'methods'  => 'GET',
// 		'callback' => 'get_latest_posts_by_category',
// 		'permission_callback' => function() {
// 		    return current_user_can('edit_posts');
// 		}
// 	));

// });

// function get_latest_posts_by_category($request) {

//     $args = array(
//         'numberposts' => -1
//     );

//     $posts = get_posts($args);
//     $updateArray = array();
//     foreach($posts as $post){
//     	$oldmetaData = get_post_meta($post->ID, 'field_63aaaa58f5eae', true);

//     	if(!empty($oldmetaData)){

//     		$update = update_metadata( 'post',$post->ID, '_yoast_wpseo_metadesc', $oldmetaData );
//     		array_push($updateArray, $update);
//     	}
    	
//     }
//     if (empty($posts)) {
//     	return new WP_Error( 'empty_category', 'no bueno', array('status' => 404) );
//     }

//     $response = new WP_REST_Response($updateArray);
//     $response->set_status(200);
 
//     return $response;
// }

function exclude_pages_from_front($query) {
      if ( $query->is_home() && $query->is_main_query() ) {
      $query->set( 'cat', '-146,-277' );
    }
}
add_action('pre_get_posts','exclude_pages_from_front');

// redirects post pages is they have the isHostPlanPost category applied to it
function hostPlanRedirects() {
    global $post;
    // this array can contain category names, slugs or even IDs.
    $catArray = ['isHostPlanPost'];
    if (is_single($post->ID) && has_category($catArray, $post)) {
        $new_url = "https://betterdeveloperdocs.com/search-wordpress-hosting/";  
        wp_redirect($new_url, 302);
        exit;
    }
}

// redirects archive pages (eg/category/x/y/z/) of hostplan related archive pages
function hostPlanArchiveRedirects() {
	
	$simpleArray = array(236);
    $createArchiveArray = hostSelectorEngine::getChildrenCategories(236);
    foreach( $createArchiveArray as $archive ){

    	// this adds the direct children of cat 236 aka 'isHostPlanPost'
    	array_push($simpleArray, $archive->cat_ID);
    	$grandChildren = hostSelectorEngine::getChildrenCategories($archive->cat_ID);
    	foreach($grandChildren as $children){
    		array_push($simpleArray, $children->cat_ID);
    	}
    }

    foreach($simpleArray as $key => $value){

    	if( is_category(236) ){
			$new_url = "https://betterdeveloperdocs.com/search-wordpress-hosting/";  
	        wp_redirect($new_url, 302);
	        exit;
		}
		// if( is_category(277) ){
		// 	$new_url = "https://betterdeveloperdocs.com/search-wordpress-hosting/";  
	 //        wp_redirect($new_url, 302);
	 //        exit;
		// }
    }
}

add_action( 'template_redirect', 'hostPlanArchiveRedirects' );
add_action( 'template_redirect', 'hostPlanRedirects' );

add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', function () {

	$args = array(
        'category' => '236,277',
        'fields' => 'ids',
        'numberposts' => -1
    );

    $postsByCat = get_posts($args);
	// $post_ids = wp_list_pluck( $postsByCat->posts, 'ID' );
	// echo '<pre>';
 	// print_r($postsByCat->posts);
 	// echo '</pre>';
	return $postsByCat;
} );
