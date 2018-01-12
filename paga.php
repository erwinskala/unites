<?php
/*
Template Name: Мой шаблон страницы
*/
wp_reset_query(); 

$sel=esc_attr($_POST['agent']);
$sel="all";

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
	'orderby' => 'meta_value_num',
    'order' => 'DESC',
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
	'orderby' => 'meta_value_num',
    'order' => 'DESC',
);

}

// $sel=39;
$UidAgentId=0;

$args=array(
'post_type' => 'agenstvo',
'posts_per_page' => -1,
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





