<?php

function add_new_posts_template(){ 



	$labels = array(  
		'name' => 'Недвижимость', // Основное название типа записи  
		'singular_name' => 'Недвижимость', // отдельное название записи типа Book  
		'add_new' => 'Добавить новую',  
		'add_new_item' => 'Добавить новую недвижимость',  
		'edit_item' => 'Редактировать недвижимость',  
		'new_item' => 'Новая недвижимость',  
		'view_item' => 'Посмотреть недвижимость',  
		'search_items' => 'Найти недвижимость',  
		'not_found' =>  'Недвижимость не найдена',  
		'not_found_in_trash' => 'В корзине недвижимость не найдена',  
		'parent_item_colon' => '',  
		'menu_name' => 'Недвижимость'  
	);  
	$args = array(  
		'labels' => $labels,  
		'public' => true,  
		'publicly_queryable' => true,  
		'show_ui' => true,  
		'show_in_menu' => true,  
		'query_var' => true,  
		'rewrite' => true,  
		'capability_type' => 'post',  
		'has_archive' => true,  
		'hierarchical' => true,  
		'menu_position' => null,  
		'supports' => array('title', 'editor', 'thumbnail'),
		"menu_icon"=>"dashicons-admin-multisite"
	);  
	register_post_type('nedvij', $args);  

		$labels = array(  
		'name' => 'Агентство', // Основное название типа записи  
		'singular_name' => 'Агентство', // отдельное название записи типа Book  
		'add_new' => 'Добавить новое',  
		'add_new_item' => 'Добавить новое агентство',  
		'edit_item' => 'Редактировать агентство',  
		'new_item' => 'Новое агентство',  
		'view_item' => 'Посмотреть агентства',  
		'search_items' => 'Найти агентство',  
		'not_found' =>  'Агентство не найдена',  
		'not_found_in_trash' => 'В корзине агентство не найдена',  
		'parent_item_colon' => '',  
		'menu_name' => 'Агентство'  
	);  
	$args = array(  
		'labels' => $labels,  
		'public' => true,  
		'publicly_queryable' => true,  
		'show_ui' => true,  
		'show_in_menu' => true,  
		'query_var' => true,  
		'rewrite' => true,  
		'capability_type' => 'post',  
		'has_archive' => true,  
		'hierarchical' => false,  
		'menu_position' => null,  
		'supports' => array('title', 'editor', 'thumbnail'),
		"menu_icon"=>"dashicons-admin-users"
	);  
	register_post_type('agenstvo', $args);  

	// Добавляем новую таксономию, делаем ее иерархической вроде рубрик
// также задаем перевод для интерфейса

  $labels = array(
    'name' => _x( 'Тип недвижимости', 'taxonomy general name' ),
    'singular_name' => _x( 'Тип недвижимости', 'taxonomy singular name' ),
    'search_items' =>  __( 'Найти тип недвижимости' ),
    'all_items' => __( 'Вся недвижимость' ),
    'parent_item' => __( 'Родительский тип недвижимости' ),
    'parent_item_colon' => __( 'Родительский тип недвижимости:' ),
    'edit_item' => __( 'Редактировать тип недвижимости' ),
    'update_item' => __( 'Обновить тип недвижимости' ),
    'add_new_item' => __( 'Добавить тип недвижимости' ),
    'new_item_name' => __( 'Новый тип недвижимости' ),
    'menu_name' => __( 'Тип недвижимости' ),
  );

// Теперь регистрируем таксономию

  register_taxonomy('type_nedvij',array('nedvij'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type_nedvij' ),
  ));

}
add_action('init', 'add_new_posts_template');


// Подключаем библиотеку TLC Transients для лучшего кэширования
// API so you don't have to use "new"
if ( !function_exists( 'tlc_transient' ) ) {
	function tlc_transient( $key ) {
		$transient = new TLC_Transient( $key );
		return $transient;
	}
}

// Подключаем наши скрипты
function unite_ch_scripts() {
wp_register_script( 'unite_ch_functions_java', get_stylesheet_directory_uri()  . '/inc/js/my_js.js', array('jquery'));
wp_enqueue_script( "unite_ch_functions_java" );
}

function unite_ch_jquery() {
wp_deregister_script( 'jquery' );
wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
wp_enqueue_script( 'jquery' );
	}


// add_action( 'wp_footer', 'unite_ch_scripts' );
add_action( 'wp_enqueue_scripts', 'unite_ch_jquery', null, true );
add_action( 'wp_enqueue_scripts', 'unite_ch_scripts', null, true);


add_action('wp_ajax_sel_option', 'my_sel_option');
add_action('wp_ajax_nopriv_sel_option', 'my_sel_option');

function my_sel_option()
{


wp_reset_query(); 

$sel=esc_attr($_POST['agent']);
// $sel="all";

$selArray=array();
$selArray2=array();

if($sel!='all'){
$selArray=array(
		 	'type' => "NUMERIC",
		 	'meta_key'   => "ID",
		 	'meta_value'=>$sel,
		 	'compare' => '=',
		 );
$selArray2= array(
	'post_type' => 'nedvij',
	'posts_per_page' => -1,
	'post__in' => $myAgent,
	'order' => 'DESC',
	'orderby' => 'ID',
	// 'meta_query' => array(
	// 	array(
	// 		// 'type' => "NUMERIC",
	// 	 	   'post_id'   => array(34,33),
	// 	 	// 'meta_key'=>array(34,33),
	// 	 	// 'meta_value'=>array(34,33),
	// 	 	'compare' => 'IN',
	// 	),)
);
}else{
$selArray2= array(
	'post_type' => 'nedvij',
	'posts_per_page' => -1,
	'order' => 'DESC',
	'orderby' => 'ID',
);

}

// $sel=39;
$UidAgentId=0;

$args=array(
'post_type' => 'agenstvo',
'posts_per_page' => -1,
// 'orderby' => 'ID',
// 'order' => 'DESC',
'meta_query' => array(
		 $selArray,

		)
                   );
$query = new WP_Query( $args );

if ( $query->have_posts() ) {
$t=0;
$UidAgent=array();
while ( $query->have_posts()) {
$query->the_post();

// echo the_title()."<br>";
// echo get_field('flache')."<br>";

$UidAgent[]=get_the_ID();
$t++;

if($post->ID==$sel){

$UidAgentId=get_the_ID();
$myAgent=array();

$ob = get_field('fagent');

foreach($ob as $key => $item){
$myAgent[$key]=$item->ID;

	}
	}

}
}

// print_r($myAgent);
// print_r($UidAgent);


wp_reset_query();



$query = new WP_Query( $selArray2 );

// print_r($query);



if ( $query->have_posts() ) {

$bkey=0;
while ( $query->have_posts()) {
$query->the_post();

$hid=get_the_ID();

// echo the_title()." title<br>";
// echo $hid." hid<br>";


if($sel!="all"){
$ob=get_field('fagent',$sel);


foreach($ob as $key => $item){
$id=$item->ID;

// echo "ID>".$id."<br>";

$arr[$id][$key]["id"]=$id;
$arr[$id][$key]["thumbnail_url"]= get_the_post_thumbnail_url($id, array(150,150));
$arr[$id][$key]["permalink"]= get_the_permalink();
$arr[$id][$key]["post_title"]=$item->post_title;
$arr[$id][$key]["post_content"]=$item->post_content;
$arr[$id][$key]["guid"]=$item->guid;
$arr[$id][$key]["flache"]=get_field('flache',$id);
$arr[$id][$key]["fprice"]=get_field('fprice',$id);
$arr[$id][$key]["fadress"]=get_field('fadress',$id);
$arr[$id][$key]["fjflache"]=get_field('fjflache',$id);
$arr[$id][$key]["fetaj"]=get_field('fetaj',$id);

}



}else{


$id=$hid;

$arr[$id][$bkey]["id"]=$id;
$arr[$id][$bkey]["thumbnail_url"]= get_the_post_thumbnail_url($id, array(150,150));
$arr[$id][$bkey]["permalink"]= get_the_permalink();
$arr[$id][$bkey]["post_title"]=get_the_title();
$arr[$id][$bkey]["post_content"]=get_the_content();
$arr[$id][$bkey]["guid"]=get_the_guid();
$arr[$id][$bkey]["flache"]=get_field('flache',$id);
$arr[$id][$bkey]["fprice"]=get_field('fprice',$id);
$arr[$id][$bkey]["fadress"]=get_field('fadress',$id);
$arr[$id][$bkey]["fjflache"]=get_field('fjflache',$id);
$arr[$id][$bkey]["fetaj"]=get_field('fetaj',$id);

$bkey++;
}








}





echo json_encode($arr);
}



wp_die();













}
?>