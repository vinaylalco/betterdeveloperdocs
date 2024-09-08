<?php
	class bddUtilities{
		public static function debug($stuff){
			echo '<pre>';
			print_r($stuff);
			echo '</pre>';
		}

		public static function getMetaDescription($id){

			// $description = get_post_meta($post->ID, 'field_63aaaa58f5eae', true);
			$description = get_post_meta($id, '_yoast_wpseo_metadesc', true);
			// $description = get_post_meta($id, '_yoast_wpseo_metadesc', true);
			if(!empty($description)){

				return $description;
			}else{
				// unsure this is working but cant see how to get the scf value. tried get_field as well.
				$description = get_post_meta($post->ID, 'field_63aaaa58f5eae', true);
			}
			return $description;
		}
	}
	class hostSelectorEngine {

		// @param $parentCategory int parent category to get children of
		// @return WP_Term Object in array 
		public static function getChildrenCategories($parentCategory){
			$cats = get_categories( array(
				'orderby' => 'name',
				'order'   => 'ASC',
				'parent' => $parentCategory
			) );

			return $cats;
			
		}

		public static function countCatPost($category) {
			
			if(is_string($category)) {
			    $catID = get_cat_ID($category);
			}
			elseif(is_numeric($category)) {
			    $catID = $category;
			} else {
			    return 0;
			}
			$cat = get_category($catID);
			return $cat->count;
		}

		public static function countCatPostUltimate($categories) {
			
			$catCount = 0;
			foreach($categories as $key => $value){

				if(is_string($value)) {
				    $catID = get_cat_ID($value);

				}
				elseif(is_numeric($value)) {
				    $catID = $value;
				} else {
				    return 0;
				}
				$cat = get_category($catID);

				$catCount += $cat->count;
			}
			return $catCount;
		}

		public static function countChildCat($parentCategory) {

			$cats = get_categories( array(
				'count' => true,
				'child_of' => $parentCategory
			) );
			$number = 0;
			foreach($cats as $cat){
				$number++;
			}
			return $number;
		}

		public static function countChildCatUltimate($parentCategories) {

			$number = 0;
			foreach($parentCategories as $key => $value){

				$cats = get_categories( array(
					'count' => true,
					'child_of' => $value
				) );
				
				foreach($cats as $cat){
					$number++;
				}
			}
			return $number;
		}
	}
	
	class hostSelectorView {
		
		public static function hostPlanSelectorUltimate($posts,$filtercategories,$isWP){

			$testWP = $isWP === 'true'? true: false;
			$html = '';
			$html .= hostSelectorView::getFiltersUltimate($filtercategories, 'all');
			$html .= '<div class="hostPlansWrapper">';
			$html .= '<p class="error"></p>';
			
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
					// 'link' => $link,
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

		public static function hostPlanSelector($posts,$filtercategories,$isWP){

			$testWP = $isWP === 'true'? true: false;
			$html = '';
			$html .= hostSelectorView::getFilters($filtercategories, $isWP);
			$html .= '<div class="hostPlansWrapper">';
			$html .= '<p class="error"></p>';
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
					
					if($testWP){
						$HostPlanMetaData = acf_get_fields('group_63a85de9dbdb9');
					}else{
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
		
		public static function getFilters($filtercategories, $isWP){
			
			$categoriryIDs = $filtercategories;
			$filterableCategoryData = array();
			$testWP = $isWP === 'true'? true: false;

			foreach($categoriryIDs as $ID){
				array_push($filterableCategoryData, hostSelectorEngine::getChildrenCategories($ID));
			}

			$html = '<div class="hostFiltersWrapper">';
			
			if($testWP){
				$countHostPlans = hostSelectorEngine::countCatPost('isWPHostPlan');
				$countHostCompanies = hostSelectorEngine::countChildCat(146);
				$html .= '<p><b>'.$countHostPlans.'</b> plans across <b>'.$countHostCompanies.' hosting companies</b> made searchable.</p>';
			}else{
				$countHostPlans = hostSelectorEngine::countCatPost('isVPSHostPlan');
				$countHostCompanies = hostSelectorEngine::countChildCat(277);
				$html .= '<p><b>'.$countHostPlans.'</b> plans across various hosting companies made searchable.</p>';
			}

			$html .= '<div class="hostFiltersInner">';
			
			foreach($filterableCategoryData as $category){
				
				// echo '<pre>';
				// print_r($category);
				// echo '</pre>';
				
				$parent = '';
				$options = '';
				$description = '';
				$html .= '<select class="dropdown">';
				foreach($category as $filter){
					
				    $parent = '<option value="">'.get_cat_name($filter->parent).'</option>';
				    $options .='<option value="'.$filter->slug.'">'.$filter->name.'</option>';
				    $description = '<div class="tooltip"> ?
							<span class="tooltiptext">'.category_description($filter->parent).'</span>
						 </div>';
				}
				$html .= $parent; 
				$html .= $options;
				$html .= '</select>';
				$html .= $description;
			}

			$html .= '<button class="clearFilters">Clear Filters</button>';
			$html .= '</div>';
			if($testWP){
				$html .= '<p><a href="https://betterdeveloperdocs.com/search-compare-vps-hosting/">Search and Compare VPS Hosting also</a></p>';
			}else{
				$html .= '<p><a href="https://betterdeveloperdocs.com/search-wordpress-hosting/">Search and Compare WordPress Hosting also</a></p>';
			}
			
			$html .= '<p>There are <b>NO</b> affilliate links on this page. Read more about the inspiration for this page and the <a href="https://betterdeveloperdocs.com/fast-lane-method-description/">The Fast Lane Method.</a></p>';
			$html .= '</div>';

			return $html;
		}

		public static function getFiltersUltimate($filtercategories, $isWP){
			
			$categoriryIDs = $filtercategories;
			$filterableCategoryData = array();
			// $testWP = $isWP === 'true'? true: false;

			foreach($categoriryIDs as $ID){
				array_push($filterableCategoryData, hostSelectorEngine::getChildrenCategories($ID));
			}

			$html = '<div class="hostFiltersWrapper">';
			$countHostPlans = hostSelectorEngine::countCatPostUltimate(array('isWPHostPlan','isVPSHostPlan'));
			$countHostCompanies = hostSelectorEngine::countChildCatUltimate(array(146));
			$html .= '<p><b>'.$countHostPlans.'</b> plans across <b>'.$countHostCompanies.' hosting companies</b> made searchable.</p>';

			$html .= '<div class="hostFiltersInner">';
			foreach($filterableCategoryData as $category){
				$parent = '';
				$options = '';
				$description = '';
				$html .= '<select class="dropdown">';
				foreach($category as $filter){
					
				    $parent = '<option value="">'.get_cat_name($filter->parent).'</option>';
				    $options .='<option value="'.$filter->slug.'">'.$filter->name.'</option>';
				    $description = '<div class="tooltip"> ?
							<span class="tooltiptext">'.category_description($filter->parent).'</span>
						 </div>';
				}
				$html .= $parent; 
				$html .= $options;
				$html .= '</select>';
				$html .= $description;
			}
			$html .= '<button class="clearFilters">Clear Filters</button>';
			$html .= '</div>';
			$html .= '<p>There are <b>NO</b> affilliate links on this page. Read more about the inspiration for this page and the <a href="https://betterdeveloperdocs.com/fast-lane-method-description/">The Fast Lane Method.</a></p>';
			$html .= '</div>';

			return $html;
		}
	}

	/**
	 * Class Template
	 */
	class Template
	{
		/**
		 * @var string
		 */
		private $path;

		/**
		 * @var array
		 */
		private $parameters = [];

		/**
		 * Template constructor.
		 * @param string $path
		 * @param array $parameters
		 */
		public function __construct(string $path, array $parameters = []){
			$this->path = rtrim($path, '/').'/';
			$this->parameters = $parameters;
		}

		/**
		 * @param string $view
		 * @param array $context
		 * @return string
		 * @throws \Exception
		 */
		public function render(string $view, array $context = []): string{
			if (!file_exists($file = $this->path.$view)) {
				throw new \Exception(sprintf('The file %s could not be found.', $view));
			}
			extract(array_merge($context, ['template' => $this]));
			ob_start();
			include ($file);
			return ob_get_clean();
		}

		/**
		 * @param string $key
		 * @return mixed
		 */
		public function get(string $key){
			return $this->parameters[$key] ?? null;
		}
	}