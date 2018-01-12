<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package unite
 */

// header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
// header('Cache-Control: no-store, no-cache, must-revalidate');
// header('Cache-Control: post-check=0, pre-check=0', FALSE);
// header('Pragma: no-cache');

get_header(); ?>

	<div id="primary" class="content-area col-sm-12 col-md-8">
		<main id="main" class="site-main" role="main">

<?php

// wp_reset_query(); 
$sel='Агенство "Пчела"';

$args=array(
		'post_type' => 'agenstvo',
        'posts_per_page' => 1,
        // 'order'=>'DESC',
    'meta_query' => array(
		 array(
		 	'meta_key'   => "post_title",
		 	'meta_value'=>$sel,
		 	// 'compare' => '=',
		 ),

		)
                   );
$query = new WP_Query( $args );



if ( $query->have_posts() ){

while ( $query->have_posts()) {

$query->the_post(); 

if($post->post_title==$sel){

$myAgent=array();
echo get_the_title();
// echo get_the_ID();
$ob = get_field('объект_агенства');
// print_r(get_field('объект_агенства'));
foreach($ob as $key => $item){
$myAgent[$key]=$item->ID;
// echo "<br>".$item->ID;
	}
	}
}}
// print_r($myAgent);
// wp_die();

// $myAgent=array_values($myAgent);
// print_r($myAgent);
// wp_reset_query();



$args=array(
		'post_type' => 'nedvij',
		'posts_per_page' => -1,
   //  	'meta_query' => array(
		 // array(
		 // 	'meta_key'   => "test",
		 // 	'meta_value'=>32,
		 // 	'compare' => '=',
		 // )),
                   );
$query = new WP_Query( $args );

// print_r($query);







//Эта функция возвращает отдельно взятый блок, подготовленный для библиотеки кэширования
function get_block($tt){

$cached = get_transient( "block_feeds_{$tt}" );
    if ( $cached !== false )
        return $cached;
if(get_post_type()!="agenstvo"){

$str="";

$str.='<div class="block">';
$str.="<a href='".get_the_permalink()."'>".get_the_title()."</a>";  
if(get_the_post_thumbnail_url(null, array(150,150)))
$str.="<img src='".get_the_post_thumbnail_url(null, array(150,150))."' alt=''>";
   
$str.="<h5>Площадь</h5><p>".get_field('flache')."/м²</p>";
if(get_field('fprice')){
$str.="<h5>Стоимость</h5>";
$str.="<p>".get_field('fprice')." $</p>";
}

if(get_field('fadress')){
$str.="<h5>Адрес</h5>";
$str.="<p>".get_field('fadress')."/м²</p>";
}
if(get_field('fjflache')){
$str.="<h5>Жилая площадь</h5>";
$str.="<p>".get_field('fjflache')."/м²</p>";
}
if(get_field('fetaj') and get_field('fetaj')!="Нет"){
$str.="<h5>Этаж</h5>";
$str.="<p>".get_field('fetaj')."</p>";
}
$str.="</div>";
}

set_transient( "block_feeds_{$tt}", $str, 1 * MINUTE_IN_SECONDS );

//( 1 * MINUTE_IN_SECONDS )
// Не забыть у константы MINUTE_IN_SECONDS поставить умножение на 60 *
return $str;
}




$tt=1;
$arr=array();
?>
<div class="all_blocks">
<?php if ( $query->have_posts() ) : ?>

<?php while ( $query->have_posts()) : $query->the_post();  ?>
<?php 
// $id=get_the_ID();
// echo get_the_title();



$ob=$query->get_field('объект_агенства');

// echo $ob->ID;

// if(get_post_type()=="agenstvo" and $post->post_title=='Агенство "Пчела"'){
// $myAgent=array();
// echo get_the_title();
// // echo get_the_ID();
// $ob = get_field('объект_агенства');
// // print_r(get_field('объект_агенства'));
// foreach($ob as $key => $item){
// $myAgent[$key]=$item->ID;
// echo "<br>".$item->ID;
// 	}
// 	}






echo get_block($tt);
$tt++;
?>

			<?php endwhile; 
// print_r($arr);
			?>
</div>

			<?php unite_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>



		</main><!-- #main -->
	</div><!-- #primary -->





<?php get_sidebar(); ?>

<?php get_footer(); ?>
