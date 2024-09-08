<?php

	function postsBDD( $atts = [], $content = null, $tag = '' ) {
	
		$args = array(
			'category' => (int)$atts['category'],
			'numberposts' => -1,
			'orderby'    => 'post_date',
			'sort_order' => 'dsc'
		);
		$posts = get_posts($args);
		$html = '';
		foreach($posts as $post){
			$link = get_post_permalink( $post->ID,);
			$image = get_the_post_thumbnail( $post->ID, 'large' );
			$description = bddUtilities::getMetaDescription($post->ID);
			// get_post_meta($post->ID, 'seo_meta_description', true);
			$html .= '<div class="postSumation wp-block-media-text alignwide is-stacked-on-mobile">
					  <figure class="wp-block-media-text__media">'.$image.'</figure>
					  <div class="wp-block-media-text__content">
						<h3>'.$post->post_title.'</h3>
						<p>'.$description.'</p>
						<div class="wp-container-1 wp-block-buttons">
						  <div class="wp-block-button">
							<a class="wp-block-button__link" href="'.$link.'">Read More</a>
						  </div>
						</div>
					  </div>
					</div>';
		}
		return $html;
	}
	add_shortcode('postsBDD', 'postsBDD');

	function hostPlanSelector( $atts = [], $content = null, $tag = '' ) {

		if($atts['wp'] == 'true'){

			$filtercategories = array(152,205,177,188,174,359,146,180,183,191,239,269,253,273,266);
			$args = array(
				'category' => 146,
				'category__not_in' => array( 277 ),
				'numberposts' => -1,
				'orderby'    => 'post_date'
			);

		}else{
			$filtercategories = array(280,152,205,304,278,279,301,283,285,305);
			$args = array(
				'category' => 277,
				'numberposts' => -1,
				'orderby'    => 'post_date',
				// 'meta_key' => 'hostplandisplayorder'
			);
		}
		
		$posts = get_posts($args);
		return hostSelectorView::hostPlanSelector($posts,$filtercategories,$atts['wp']);
	}
	add_shortcode('hostPlanSelector', 'hostPlanSelector');
	
	// function individualHostInfo(){

	// 	$category = '';
	// 	// return in_category( 'bluehostcompany' );
	// 	bddUtilities::debug( is_object_in_term( get_the_id(), 'bluehost-company' ) );
	// 	if(in_category( 'bluehostcompany' )){
	// 		$category = 'bluehostcompany';
	// 	}

	// 	$parameters = array (
	// 		'category' => $category
	// 	);
	// 	$template = new Template( __DIR__ . '/templates/', $parameters);
	// 	$html = $template->render('individualHostInfo.php', array());
	// 	return $html;
	// }
	// add_shortcode('individualHostInfo', 'individualHostInfo');
	
	function getExpressLaneText( $atts = [], $content = null, $tag = '' ) {

		return 'You can use our <a href="https://betterdeveloperdocs.com/search-wordpress-hosting/">"Fast Lane Method"</a> to search and browse WordPress Hosting Plans and avoid price increases after the initial contract. Often hosting plans are offered at a lower price on a monthly, yearly or tri-yearly contract and then after this time they renew at a higher cost. The Fast Lane Method allows you to search through hosting plans by the renewal cost and avoid a surprise cost increase!';
	}
	add_shortcode('getExpressLaneText', 'getExpressLaneText');

	// hostPlanSelectorUltimate
	function hostPlanSelectorUltimate( $atts = [], $content = null, $tag = '' ) {

		$args = array(
			'category' => (int)$atts['category'],
			'numberposts' => -1,
			'orderby'    => 'post_date',
		);
		
		$posts = get_posts($args);
		$filtercategories = explode(',',$atts['filtercats']);
		return hostSelectorView::hostPlanSelectorUltimate($posts,$filtercategories,$atts['wp']);
	}
	add_shortcode('hostPlanSelectorUltimate', 'hostPlanSelectorUltimate');

	function getIndividualPlans( $atts = [], $content = null, $tag = '' ) {

		if($atts['monthly'] == 'true'){
			$args = array(
				'include' => array(10396,10393,10388,10353,10347,10339,9384,9382,9379,9375,9371,9291,9287,9273,9270,8906,8902,8897,8893,8876,8873,8866,8863,8859,9367,9364,9360,9356,9331,9330,9329),
				'orderby'    => 'post_date',
			);
		}elseif($atts['eig'] == 'true'){
			// 361 is no eig category
			$args = array(
				'category' => 361,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['freedomain'] == 'true'){
			// 240 is no eig category
			$args = array(
				'category' => 240,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['hostinger'] == 'true'){
			// 147 is hostinger category
			$args = array(
				'category' => 147,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}
		
		$posts = get_posts($args);

		$html = '';
			// $html .= hostSelectorView::getFiltersUltimate($filtercategories, 'all');
			$html .= '<div class="hostPlansWrapper">';
			// $html .= '<p class="error"></p>';
			foreach($posts as $post){

				$link = get_post_permalink($post->ID);
				$image = get_the_post_thumbnail( $post->ID, 'small' );
				$description = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
				$categories = wp_get_post_categories($post->ID, array('fields'=>'slugs'));
				$categoryClasses = implode(" ", $categories);
				
				$classes = '';
				foreach($categories as $category){
					$classes .= $category.' ';
				}
				
				if (function_exists('acf_get_field_groups')) {
					
					// Need to base this on the category it's in ie WP HostPlan or VPS HostPlan
					if ( in_category('isWPHostPlan', $post->ID) ) {
						$HostPlanMetaData = acf_get_fields('group_63a85de9dbdb9');
					}elseif( in_category('isVPSHostPlan', $post->ID) ){
						$HostPlanMetaData = acf_get_fields('group_63d29a1d09309');
					}
				    $HostPlanMetaString = '';
				    foreach($HostPlanMetaData as $data){
				    	$value = get_field($data['name'], $post->ID);
				    	$HostPlanMetaString .= '<b><p>'.$data['label'].'</b>: '.$value.'</p>';
				    }
				}

				$affiliateLink = get_field('affiliatelink', $post->ID);

				$parameters = array (
					'link' => $link,
					'image' => $image,
					'description' => $description,
					'title' => $post->post_title,
					'classes' => rtrim($classes,' '),
					'HostPlanMetaString' => $HostPlanMetaString,
					'affiliateLink' => $affiliateLink
				);
				$template = new Template( __DIR__ . '/templates/', $parameters);
				$html .= $template->render('hostCard.php', array());
			}
			$html .= '</div>';
			return $html;
	}
	add_shortcode('getIndividualPlans', 'getIndividualPlans');

	// givs posts with ALL of the categories tagged, ie AND relationship
	function postsByMultipleCategories( $atts = [], $content = null, $tag = '' ) {

		if($atts['managedwpunder20'] == 'true'){

			$args = array(
				'category__and' => array(236,189),
				'category__in' => array(206,207,208,209),
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);

		}elseif($atts['managedvpsunder20'] == 'true'){

			$args = array(
				'category__and' => array(277,281),
				'category__in' => array(206,207,208,209),
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);

		}elseif($atts['hostswitheurolocations'] == 'true'){

			$args = array(
				'category__in' => 267,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['unmeteredbandwidthplans'] == 'true'){

			$args = array(
				'category__in' => 254,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['unlimitedstorageplans'] == 'true'){

			$args = array(
				'category__in' => 199,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['freetransferplans'] == 'true'){

			$args = array(
				'category__in' => 270,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['vpsdedicatedip'] == 'true'){

			$args = array(
				'category__in' => 302,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['vpswithplesk'] == 'true'){

			$args = array(
				'category__in' => 323,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['vpswithmultiplecpanellicenses'] == 'true'){

			$args = array(
				'category__in' => 311,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['cloudey'] == 'true'){

			$args = array(
				'category__in' => 268,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['dreamhost'] == 'true'){

			$args = array(
				'category__in' => 218,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['vpswithwordpress'] == 'true'){

			$args = array(
				'category__in' => 226,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['northamericanplans'] == 'true'){

			$args = array(
				'category__in' => 365,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['vpswithdirectadmin'] == 'true'){

			$args = array(
				'category__in' => 324,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['vpswithcpanel'] == 'true'){

			$args = array(
				'category__in' => 284,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['allmanagedwordpressplans'] == 'true'){

			$args = array(
				'category__in' => 189,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['allunmanagedwordpressplans'] == 'true'){

			$args = array(
				'category__in' => 190,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['wpplanswithstaging'] == 'true'){

			$args = array(
				'category__in' => 367,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}elseif($atts['krystal'] == 'true'){

			$args = array(
				'category__in' => 237,
				'numberposts' => -1,
				'orderby'    => 'post_date',
			);
		}

		$posts = new WP_Query($args);

		$html = '';
		$html .= '<div class="hostPlansWrapper">';
		foreach($posts->posts as $post){

			$link = get_post_permalink($post->ID);
			$image = get_the_post_thumbnail( $post->ID, 'small' );
			$description = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
			$categories = wp_get_post_categories($post->ID, array('fields'=>'slugs'));
			$categoryClasses = implode(" ", $categories);
			
			$classes = '';
			foreach($categories as $category){
				$classes .= $category.' ';
			}
			
			if (function_exists('acf_get_field_groups')) {
				
				// Need to base this on the category it's in ie WP HostPlan or VPS HostPlan
				if ( in_category('isWPHostPlan', $post->ID) ) {
					$HostPlanMetaData = acf_get_fields('group_63a85de9dbdb9');
				}elseif( in_category('isVPSHostPlan', $post->ID) ){
					$HostPlanMetaData = acf_get_fields('group_63d29a1d09309');
				}
			    $HostPlanMetaString = '';
			    foreach($HostPlanMetaData as $data){
			    	$value = get_field($data['name'], $post->ID);
			    	$HostPlanMetaString .= '<b><p>'.$data['label'].'</b>: '.$value.'</p>';
			    }
			}

			$affiliateLink = get_field('affiliatelink', $post->ID);

			$parameters = array (
				'link' => $link,
				'image' => $image,
				'description' => $description,
				'title' => $post->post_title,
				'classes' => rtrim($classes,' '),
				'HostPlanMetaString' => $HostPlanMetaString,
				'affiliateLink' => $affiliateLink
			);
			$template = new Template( __DIR__ . '/templates/', $parameters);
			$html .= $template->render('hostCard.php', array());
		}
		$html .= '</div>';
		return $html;
	}
	add_shortcode('postsByMultipleCategories', 'postsByMultipleCategories');