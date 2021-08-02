<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
//define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {
	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'));
}
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

function custom_js(){
    wp_enqueue_script( 'custon_js', get_stylesheet_directory_uri() . '/js/custom_button.js', array ( 'jquery' ), 1.1, true);
    }
    add_action( 'wp_enqueue_scripts', 'custom_js');

/*
* Creating a function to create our CPT
*/
 
function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Products', 'Post Type General Name', 'Astra' ),
        'singular_name'       => _x( 'Product', 'Post Type Singular Name', 'Astra' ),
        'menu_name'           => __( 'Products', 'Astra' ),
        'parent_item_colon'   => __( 'Parent Product', 'Astra' ),
        'all_items'           => __( 'All Products', 'Astra' ),
        'view_item'           => __( 'View Product', 'Astra' ),
        'add_new_item'        => __( 'Add New Product', 'Astra' ),
        'add_new'             => __( 'Add New', 'Astra' ),
        'edit_item'           => __( 'Edit Product', 'Astra' ),
        'update_item'         => __( 'Update Product', 'Astra' ),
        'search_items'        => __( 'Search Product', 'Astra' ),
        'not_found'           => __( 'Not Found', 'Astra' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'Astra' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'products', 'Astra' ),
        'description'         => __( 'Product news and reviews', 'Astra' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'products', $args );
	
	//taxonomy
  register_taxonomy("post_cet", 
						
						array("products"), 
						array(
							"hierarchical" => true,   
							"label" => "Categories", 
							"singular_label" => "Type", 
							"rewrite" => true,
							'show_ui'             => true,
							// Allow automatic creation of taxonomy columns on associated post-types table?
							'show_admin_column'   => true,
							// Show in quick edit panel?
							'show_in_quick_edit'  => false,)
					);
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );


function get_productp(){
	ob_start();
	global $post;
	$args = array(  
        'post_type' => 'products',
        'post_status' => 'publish',
        'posts_per_page' => 6,  
    );

    $loop = new WP_Query( $args ); 
        
    while ( $loop->have_posts() ) : $loop->the_post(); 
        $featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );?>
		
		<div class="product_class">
		<div class="product_img">
		<img src="<?php echo $featured_img[0]; ?>" />
		</div>
		<div class="product_content">
		    <a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a>
		 </div>
		 </div>
    <?php    
    endwhile;

    wp_reset_postdata(); 
	
	return ob_get_clean();
}

add_shortcode('get_productp','get_productp');


function my_custom_class($output){
  if( is_shop() ) {
    $shopID = get_option( 'woocommerce_shop_page_id' );
    $custom_class = get_post_meta( $shopID, '_x_entry_body_css_class', true );
    $output[] = $custom_class;
  }

  return $output;
}
add_filter( 'body_class', 'my_custom_class' );



add_filter( 'post_class', 'filter_product_post_class', 10, 3 );
function filter_product_post_class( $classes, $class, $product_id ){
    // Only on shop page
    //if( is_shop() )
        $classes[] = 'product_custom';

    return $classes;
}

/// To change add to cart text on product archives(Collection) page
/*add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'View All Bettery Range', 'woocommerce' );
}
*/

function get_shop_featured_image() {
  if( is_shop() ) {
    $shop = get_option( 'woocommerce_shop_page_id' );
    if( has_post_thumbnail( $shop ) ) {
		?>
		<div class="feature_shop">
   <?php   echo get_the_post_thumbnail( $shop ); ?>
	  </div>
	  <div class="shop_button">
	  <div class="bt_back">
	  <a href="/new/about-maxlife/"><i class="fas fa-arrow-left"></i>Back</a>
	  </div>
	   <div class="bt_fav">
	  <a href="/new/maxlife-premimum/">Go to Application<i class="fas fa-arrow-right"></i></a>
	  </div>
	  <?php 
    }
  }
}
add_action('woocommerce_before_main_content', 'get_shop_featured_image');

//footer category 

function category_primum(){
$args = array(
    'posts_per_page' => 6,
    'product_cat' => 'maxulife-premimum',
    'post_type' => 'product',
    'orderby' => 'title',
);
$the_query = new WP_Query( $args );
// The Loop
?>
<ul>
<?php
while ( $the_query->have_posts() ) {
    $the_query->the_post();
	?>
	
	<li><a href="#"><?php echo  get_the_title(); ?></a></li>
	
	<?php 
    //echo '' . get_the_title();
}
?>
</ul>
<?php
wp_reset_postdata();
}
add_shortcode('max_primum','category_primum');

//footer all category get
 function all_cate_list(){
  $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 1;      // 1 for yes, 0 for no  
  $title        = '';  
  $empty        = 1;
  
  $arr =['products-range'];

  $args = array(
         'taxonomy'     => $taxonomy,
         'orderby'      => $orderby,
         'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
         'title_li'     => $title,
         'hide_empty'   => $empty
  );
 $all_categories = get_categories($args);
 
 
 
 //print_r($dis_categories);
 ?>
 <ul>
 <?php 
 foreach ($all_categories as $cat){	 
    if($cat->category_parent == 0) {
        $category_id = $cat->term_id; 
		}
   ?>
   <li>
   <a href="<?php echo  get_term_link($cat->slug, 'product_cat'); ?>" > <?php echo  $cat->name; ?> </a>
   </li>
   <?php 
 }
 }

add_shortcode('all_cate_list','all_cate_list');
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 30 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 30 );
add_action( 'woocommerce_single_product_summary', 'ad_button', 40 );
//add_action('woocommerce_single_product_summary','test_img',99);
add_action('woocommerce_after_single_product_summary' ,'test_img');
add_action('woocommerce_before_single_product_summary' ,'feature_img');

function test_img(){
	global $post;
	?>
	<div class="pro_img">
	
	<?php
	 
        if( have_rows('group') ){

        while( have_rows('group') ){
                 the_row();
              $group_heading = get_sub_field('heading');
              $group_img_one = get_sub_field('img1')['url'];
              $group_text_one = get_sub_field('text1');
              $group_img_two = get_sub_field('img2')['url'];
              $group_text_two = get_sub_field('text2');
              $group_img_three = get_sub_field('img3')['url'];
              $group_text_three = get_sub_field('text3');
               $group_img_four = get_sub_field('img4')['url'];
              $group_text_four = get_sub_field('text4');
              echo '<div class="group_main">';
              echo    '<h1>'.$group_heading.'</h1>';
              echo      '<div class="group_sub">'; 
              echo          '<div class="group_img">';
              echo              '<img src="'.$group_img_one .'">';
              echo          '</div>';
              echo          '<div class="group_text">';
              echo              $group_text_one;
              echo           '</div>';
              echo      '</div>';
              echo      '<div class="group_sub">';
              echo          '<div class="group_img">';
              echo              '<img src="'.  $group_img_two .'">';
              echo          '</div>';
              echo          '<div class="group_text">';
              echo               $group_text_two;
              echo          '</div>';
              echo      '</div>';

              echo      '<div class="group_sub">';
              echo          '<div class="group_img">';
              echo              '<img src="'.  $group_img_three .'">';
              echo          '</div>';
              echo          '<div class="group_text">';
              echo               $group_text_three;
              echo          '</div>';
              echo      '</div>';

              echo      '<div class="group_sub">';
              echo          '<div class="group_img">';
              echo              '<img src="'.  $group_img_four .'">';
              echo          '</div>';
              echo          '<div class="group_text">';
              echo               $group_text_four;
              echo          '</div>';
              echo      '</div>';

              echo '</div>';

        
        }
		
    
    //test end
    //tab

        
        echo '<div class="table_container">';
        echo '<ul class="nav nav-tabs">';
        echo '<li class="active"><a data-toggle="tab" href="#home">Automotive</a></li>';
        echo '<li><a data-toggle="tab" href="#menu1">Heavy Duty</a></li>';
        echo '<li><a data-toggle="tab" href="#menu2">Leisure</a></li>';
        echo '</ul>';
        echo '<div class="tab-content">';
        echo '<h2>'.get_field('table_heading') .'</h2>';
        echo '<div id="home" class="tab-pane fade in active">';
                      $table1 = get_field('table1');
                            if ( $table1 ) {
                                echo '<table border="0">';
                                    if ( $table1['header'] ) {
                                        echo '<thead>';
                                            echo '<tr>';
                                                foreach ( $table1['header'] as $th ) {
                                                    echo '<th>';
                                                        echo $th['c'];
                                                    echo '</th>';
                                                }
                                            echo '</tr>';
                                        echo '</thead>';
                                    }
                                    echo '<tbody>';
                                        foreach ( $table1['body'] as $tr ) {
                                            echo '<tr>';
                                                foreach ( $tr as $td ) {
                                                    echo '<td>';
                                                        echo $td['c'];
                                                    echo '</td>';
                                                }
                                            echo '</tr>';
                                        }
                                    echo '</tbody>';
                                echo '</table>';
                            }
        echo '</div>';
    echo '<div id="menu1" class="tab-pane fade">';
       $table2 = get_field( 'table2' );
                            if ( $table2 ) {
                                echo '<table border="0">';
                                    if ( $table2['header'] ) {
                                        echo '<thead>';
                                            echo '<tr>';
                                                foreach ( $table2['header'] as $th ) {
                                                    echo '<th>';
                                                        echo $th['c'];
                                                    echo '</th>';
                                                }
                                            echo '</tr>';
                                        echo '</thead>';
                                    }
                                    echo '<tbody>';
                                        foreach ( $table2['body'] as $tr ) {
                                            echo '<tr>';
                                                foreach ( $tr as $td ) {
                                                    echo '<td>';
                                                        echo $td['c'];
                                                    echo '</td>';
                                                }
                                            echo '</tr>';
                                        }
                                    echo '</tbody>';
                                echo '</table>';
                            }
    echo '</div>';
    echo '<div id="menu2" class="tab-pane fade">';
       $table3 = get_field( 'table3' );
	
                            if ( $table3 ) {
                                echo '<table border="0">';
                                    if ( $table3['header'] ) {
                                        echo '<thead>';
                                            echo '<tr>';
                                                foreach ( $table3['header'] as $th ) {
                                                    echo '<th>';
                                                        echo $th['c'];
                                                    echo '</th>';
                                                }
                                            echo '</tr>';
                                        echo '</thead>';
                                    }
                                    echo '<tbody>';
                                        foreach ( $table3['body'] as $tr ) {
                                            echo '<tr>';
                                                foreach ( $tr as $td ) {
                                                    echo '<td>';
                                                        echo $td['c'];
                                                    echo '</td>';
                                                }
                                            echo '</tr>';
                                        }
                                    echo '</tbody>';
                                echo '</table>';
                            }
    echo '</div>';
  echo '</div>';
  echo '</div>';
        //tabend


}  
	
}


function ad_button(){
	$h_ref =  get_theme_mod( 'title_text_block');
	$pdf=get_field('file_pdf');
	echo "<a href='".$h_ref."' class='ask_btton'>Send inquiry</a>";
	echo "<a href='".$pdf['url']."' target='_blank' class='ask_btton download_class'>Download Flyer</a>";
	 
}
function theme_name_register_theme_customizer( $wp_customize ) {
    // Create custom panel.
    /*$wp_customize->add_panel( 'text_blocks', array(
        'priority'       => 10,
        'theme_supports' => '',
        'title'          => __( 'Ask Quotation', 'astra' ),
        'description'    => __( 'Set editable text for certain content.', 'astra' ),
    ) );*/
    // Add section.
    $wp_customize->add_section( 'custom_title_text' , array(
        'title'    => __('Ask Quotation','theme-name'),
       // 'panel'    => 'text_blocks',
        'priority' => 10
    ) );
    // Add setting
    $wp_customize->add_setting( 'title_text_block', array(
         'default'           => __( 'Default text', 'astra' ),
         'sanitize_callback' => 'sanitize_text'
    ) );
    // Add control
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'custom_title_text',
            array(
                'label'    => __( 'Custom Text', 'astra' ),
                'section'  => 'custom_title_text',
                'settings' => 'title_text_block',
                'type'     => 'text'
            )
        )
    );
	
	$wp_customize->add_section(
			'woocommerce_product_img',
			array(
				'title'    => __( 'Features Image', 'astra' ),
				'priority' =>30,
				'panel'    => 'woocommerce',
			)
		);
		  $wp_customize->add_setting( 'title_text_block1', array(
          //default value
    ) );
	$wp_customize->add_control( new  WP_Customize_Image_Control(
        $wp_customize,
        'custom_title_text1',
            array(
                'label'    => __( 'Select Product Title Image', 'astra' ),
                'section'  => 'woocommerce_product_img',
                'settings' => 'title_text_block1',
               
            )
        )
    );
  
    // Sanitize text
	 
}
add_action( 'customize_register', 'theme_name_register_theme_customizer' );

function  feature_img(){
	
	$prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
	global $post, $product;
    $categ = wc_get_product_category_list($post->ID);
	$my_img = get_theme_mod('title_text_block1');
    echo  '<div class="Single_product_box">';
	echo '<div class="img_box">';
	echo '<img src="'.$my_img.'"/>';
	echo 	'<div class="text_box">';
	echo       $categ;
	echo    '</div>';
	
	echo  '</div>';
	echo  '<div class="shop_button">';
    echo '<div class="bt_back">';
    echo '<a href="'.$prev_url.'"> <i class="fas fa-arrow-left"></i>Back</a>';
    echo '</div>';
	echo '</div>';
	echo '<div/>';
	
}
add_shortcode('feature_img','feature_img');

?>
