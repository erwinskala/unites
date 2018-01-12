<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package unite
 */
?>
	<div id="secondary" class="widget-area col-sm-12 col-md-4" role="complementary">

<!-- Здесь идёт наш блок фильтров -->
<div class="filter">
				<form action="#" method="GET">
				<div class="tab2">Агенства</div>
				<div class="selfil">
					<table>
						<tr>

							<td class="vmark" colspan="2">
								<div class="sel">
									<p></p>
<?php
$args=array(
		'post_type' => 'agenstvo',
        'posts_per_page' => -1,
        'order'=>'ASC'

                   );
$query = new WP_Query( $args );

$mark = array();
$ids = array();

if ( $query->have_posts() ){

while ( $query->have_posts() ){ 
$query->the_post();
                

$mark[] = get_the_title();
$ids[] = get_the_ID();


}}
// print_r($mark);
?>
									<select name='mark'>


<?php
$mark = array_unique($mark);
echo "<option value='all'>Все агенства</option>";
for($i=0; $i<count($mark); $i++){
	if($mark[$i]!="") echo "<option value='".$ids[$i]."'>".$mark[$i]."</option>";
}
?>
									</select>
								</div>
							</td>
						</tr>
					</table>
				</div>

				</form>
	</div>



		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h1 class="widget-title"><?php _e( 'Archives', 'unite' ); ?></h1>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget">
				<h1 class="widget-title"><?php _e( 'Meta', 'unite' ); ?></h1>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
