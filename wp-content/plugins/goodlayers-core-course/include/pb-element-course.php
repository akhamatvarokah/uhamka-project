<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	add_action('plugins_loaded', 'gdlr_core_pb_element_course');
	if( !function_exists('gdlr_core_pb_element_course') ){
		function gdlr_core_pb_element_course(){
			if( class_exists('gdlr_core_page_builder_element') ){
				gdlr_core_page_builder_element::add_element('course', 'gdlr_core_pb_element_course'); 
			}
		}
	} 
	
	if( !class_exists('gdlr_core_pb_element_course') ){
		class gdlr_core_pb_element_course{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'icon_briefcase',
					'title' => esc_html__('Course List', 'goodlayers-core-course')
				);
			}
			
			// list all custom taxonomy
			static function get_tax_option_list(){
				
				$ret = array();

				$tax_fields = array();
				$tax_fields = $tax_fields + goodlayers_core_course_get_custom_tax_list();
				foreach( $tax_fields as $tax_field => $tax_title ){
					$ret[$tax_field] = array(
						'title' => $tax_title,
						'type' => 'multi-combobox',
						'options' => gdlr_core_get_term_list($tax_field),
					);
				}

				return $ret;
			}

			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core-course'),
						'options' => array(

							'course_category' => array(
								'title' => esc_html__('Category', 'goodlayers-core-course'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('course_category'),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'goodlayers-core-course'),
							),
							'course_tag' => array(
								'title' => esc_html__('Tag', 'goodlayers-core-course'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('course_tag')
							),
						) + self::get_tax_option_list() + array(
							'num-fetch' => array(
								'title' => esc_html__('Num Fetch', 'goodlayers-core-course'),
								'type' => 'text',
								'data-input-type' => 'number',
								'default' => 9,
								'description' => esc_html__('The number of posts showing on the blog item', 'goodlayers-core-course')
							),
							'orderby' => array(
								'title' => esc_html__('Order By', 'goodlayers-core-course'),
								'type' => 'combobox',
								'options' => array(
									'date' => esc_html__('Publish Date', 'goodlayers-core-course'), 
									'title' => esc_html__('Title', 'goodlayers-core-course'), 
									'rand' => esc_html__('Random', 'goodlayers-core-course'), 
									'menu_order' => esc_html__('Menu Order', 'goodlayers-core-course'), 
								)
							),
							'order' => array(
								'title' => esc_html__('Order', 'goodlayers-core-course'),
								'type' => 'combobox',
								'options' => array(
									'desc'=>esc_html__('Descending Order', 'goodlayers-core-course'), 
									'asc'=> esc_html__('Ascending Order', 'goodlayers-core-course'), 
								)
							),
							'pagination' => array(
								'title' => esc_html__('Pagination', 'goodlayers-core-course'),
								'type' => 'combobox',
								'options' => array(
									'none'=>esc_html__('None', 'goodlayers-core-course'), 
									'page'=>esc_html__('Page', 'goodlayers-core-course'), 
								),
							),
							'pagination-style' => array(
								'title' => esc_html__('Pagination Style', 'goodlayers-core-course'),
								'type' => 'combobox',
								'options' => array(
									'default' => esc_html__('Default', 'goodlayers-core-course'),
									'plain' => esc_html__('Plain', 'goodlayers-core-course'),
									'rectangle' => esc_html__('Rectangle', 'goodlayers-core-course'),
									'rectangle-border' => esc_html__('Rectangle Border', 'goodlayers-core-course'),
									'round' => esc_html__('Round', 'goodlayers-core-course'),
									'round-border' => esc_html__('Round Border', 'goodlayers-core-course'),
									'circle' => esc_html__('Circle', 'goodlayers-core-course'),
									'circle-border' => esc_html__('Circle Border', 'goodlayers-core-course'),
								),
								'default' => 'default',
								'condition' => array( 'pagination' => 'page' )
							),
							'pagination-align' => array(
								'title' => esc_html__('Pagination Alignment', 'goodlayers-core-course'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'with-default' => true,
								'default' => 'default',
								'condition' => array( 'pagination' => 'page' )
							),
						)
					), // general

					'style' => array(
						'title' => esc_html__('Style', 'goodlayers-core-course'),
						'options' => array(	
							'course-style' => array(
								'title' => esc_html__('Course Style', 'goodlayers-core-course'),
								'type' => 'combobox',
								'options' => array(
									'list' => esc_html__('List', 'goodlayers-core-course'),
									'list-info' => esc_html__('List With Info', 'goodlayers-core-course'),
								)
							),
							'course-info' => array(
								'title' => esc_html__('Course Info', 'goodlayers-core-course'),
								'type' => 'multi-combobox',
								'options' => goodlayers_core_course_get_custom_tax_list(),
								'condition' => array('course-style' => 'list-info')
							),
						)
					),

					'spacing' => array(
						'title' => esc_html__('Spacing', 'goodlayers-core-course'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'goodlayers-core-course'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							)
						)
					),

					'item-title' => array(
						'title' => esc_html__('Item Title', 'goodlayers-core-course'),
						'options' => gdlr_core_block_item_option()
					)
				);
			}
			
			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array() ){
				global $gdlr_core_item_pdb, $page_builder_post_id;
				
				// default variable
				if( empty($settings) ){
					$settings = array( 'padding-bottom' => $gdlr_core_item_pdb );
				}
				
				$settings['course-style'] = empty($settings['course-style'])? 'list': $settings['course-style'];
				
				// start printing item
				$ret  = '<div class="gdlr-core-course-item gdlr-core-item-pdlr gdlr-core-item-pdb gdlr-core-course-style-' . esc_attr($settings['course-style']) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				$title_settings = $settings;
				$title_settings['pdlr'] = false;
				$ret .= gdlr_core_block_item_title($title_settings);

				$query = self::query_course($settings);
				$settings['paged'] = empty($query->query['paged'])? 1: $query->query['paged'];

				gdlr_core_setup_admin_postdata();
				if( $query->have_posts() ){
					while($query->have_posts()){ $query->the_post();

						$course_id = get_post_meta(get_the_ID(), 'goodlayers-core-course-id', true);

						$ret .= '<div class="gdlr-core-course-item-list" >';
						if( $settings['course-style'] == 'list' ){
							$ret .= '<a class="gdlr-core-course-item-link" href="' . get_permalink() . '" >';
							if( !empty($course_id) ){
								$ret .= '<span class="gdlr-core-course-item-id gdlr-core-skin-caption" >' . gdlr_core_text_filter($course_id) . '</span>';
							}

							$ret .= '<span class="gdlr-core-course-item-title gdlr-core-skin-title" >' . get_the_title() . '</span>';

							$ret .= '<i class="gdlr-core-course-item-icon gdlr-core-skin-icon fa fa-long-arrow-right" ></i>';
							$ret .= '</a>';
						}else if( $settings['course-style'] == 'list-info' ){
							$ret .= '<h3 class="gdlr-core-course-item-title" >';
							if( !empty($course_id) ){
								$ret .= '<span class="gdlr-core-course-item-id gdlr-core-skin-caption" >' . gdlr_core_text_filter($course_id) . '</span>';
							}
							$ret .= get_the_title();
							$ret .= '</h3>';

							if( !empty($settings['course-info']) ){
								$ret .= self::get_course_info($settings['course-info'], get_the_ID());
							}

							$ret .= '<a href="' . get_permalink() . '" class="gdlr-core-course-item-button gdlr-core-button" >' . esc_html__('More Detail', 'goodlayers-core-course') . '</a>';
						}
						$ret .= '</div>';
					}
				}else{
					$ret .= '<div class="gdlr-core-course-not-found" >';
					$ret .= esc_html__('There\'re no item that match your search criteria. Please try again with different keywords.', 'goodlayers-core-course');
					$ret .= '</div>';
				}

				if( !empty($settings['pagination']) && $settings['pagination'] == 'page' ){
					$ret .= gdlr_core_get_pagination($query->max_num_pages, $settings);
				}

				wp_reset_postdata();
				gdlr_core_reset_admin_postdata();

				$ret .= '</div>';

				return $ret;
			}

			static function query_course( $settings = array() ){

				if( !empty($settings['query']) ){ return $settings['query']; }

				$args = array('post_type' => 'course', 'post_status' => 'publish', 'suppress_filters' => false);
				
				if( !empty($settings['keywords']) ){
					$args['s'] = $settings['keywords'];
				}
				if( !empty($settings['course-id']) ){
					$args['meta_query'] = array(array(
						'key' => 'goodlayers-core-course-id',
						'value' => $settings['course-id']
					));
				}	

				// category - tag selection
				$args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['course_category']) ){
					if( !is_array($settings['course_category']) ){
						$settings['course_category'] = array_map('trim', explode(',', $settings['course_category']));
					}
					array_push($args['tax_query'], array('terms'=>$settings['course_category'], 'taxonomy'=>'course_category', 'field'=>'slug'));
				}
				if( !empty($settings['course_tag']) ){
					if( !is_array($settings['course_tag']) ){
						$settings['course_tag'] = array_map('trim', explode(',', $settings['course_tag']));
					}
					array_push($args['tax_query'], array('terms'=>$settings['course_tag'], 'taxonomy'=>'course_tag', 'field'=>'slug'));
				}

				$tax_fields = goodlayers_core_course_get_custom_tax_list();
				foreach( $tax_fields as $tax_field => $tax_title ){
					if( !empty($settings[$tax_field]) ){
						if( !is_array($settings[$tax_field]) ){
							$settings[$tax_field] = array_map('trim', explode(',', $settings[$tax_field]));
						}
						$args['tax_query'][] = array(
							array('terms'=>$settings[$tax_field], 'taxonomy'=>$tax_field, 'field'=>'slug')
						);
					}
				}

				// order
				$args['order'] = empty($settings['order'])? 'desc': $settings['order'];
				$args['orderby'] = empty($settings['orderby'])? 'date': $settings['orderby'];
				
				$args['posts_per_page'] = empty($settings['num-fetch'])? 9: $settings['num-fetch'];

				$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
				$args['paged'] = empty($args['paged'])? 1: $args['paged'];

				return new WP_Query( $args );
			}

			// course item info
			static function get_course_info( $infos = array(), $post_id = '' ){
				$taxs = goodlayers_core_course_get_custom_tax_list();	

				$ret = '';
				foreach( $infos as $tax_slug ){
					$terms = get_the_terms($post_id, $tax_slug);
					$term_name = '';
					if( !empty($terms) ){
						foreach( $terms as $term ){
							$term_name .= empty($term_name)? '': ', ';
							$term_name .= $term->name; 
						}
					}
					

					if( !empty($term_name) ){
						$ret .= '<div class="gdlr-core-course-item-info" >';
						$ret .= '<span class="gdlr-core-head" >' . $taxs[$tax_slug] . ' : </span>';
						$ret .= '<span class="gdlr-core-tail" >' . gdlr_core_text_filter($term_name) . '</span>';
						$ret .= '</div>';
					}
				}

				if( !empty($ret) ){
					$ret = '<div class="gdlr-core-course-item-info-wrap" >' . $ret . '</div>';
				}

				return $ret;
			}
			
		} // gdlr_core_pb_element_course
	} // class_exists	