<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( wp_is_block_theme() ){
    wp_head();
    block_header_area();
}else{
    get_header();
}

$width = apply_filters( 'woolentor_builder_template_width', 1200 );
?>
<div class="woolentor-template-container" style="margin:0 auto; max-width:<?php echo $width ? $width.'px; padding: 0 15px;' : '100%;'; ?>">
	<?php
    	while ( have_posts() ) { 
			the_post();
			do_action('woolentor/builder/content');
    	}
	?>
</div>
<?php
if( wp_is_block_theme() ){
    wp_footer();
    block_footer_area();
 }else{
    get_footer();
 }
