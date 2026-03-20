<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_script( 'ywcfav_video' );

$aspect_ratio = '_' . $aspect_ratio;

$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );

$thumbnail_size = apply_filters( 'woocommerce_gallery_thumbnail_size', array(
	$gallery_thumbnail['width'],
	$gallery_thumbnail['height']
) );


$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size );

$thumbnail_url = isset( $thumbnail_url[0] ) ? $thumbnail_url[0] : '';
global $product;

$video_data = array(
	'volume'       => $volume,
	'loop'         => $loop,
	'is_stoppable' => $is_stoppable,
	'force_muted'  => isset( $force_muted ),
);

$video_data = htmlspecialchars( wp_json_encode( $video_data ) );

if ( 'youtube' == $host ) {
	$video_class = 'youtube';

	$query_args = array(
		'enablejsapi' => 1,
		'version'     => 3,
		'origin'      => get_site_url(),
		'controls'    => 'yes' == $show_controls ? 1 : 0,
		'color'       => $color,
		'loop'        => 'yes' == $loop ? 1 : 0,
		'rel'         => 'yes' == $show_rel ? 1 : 0,
		'autoplay'    => 'yes' == $autoplay && $featured_content_selected ? 1 : 0,
		'theme'       => $theme,
		'videoId'     => $video_id

	);

	$data = htmlspecialchars( wp_json_encode( $query_args ) );


} elseif ( 'vimeo' == $host ) {
	$video_class = 'vimeo';
	$url         = "//player.vimeo.com/video/" . $video_id;

	$query_args = array(
		'id' => $video_id,
        'loop' => 'yes' == $loop,
        'autoplay' => 'yes' == $autoplay && $featured_content_selected,
        'muted'   => isset( $force_muted ),
        'title' => 'yes' == $show_info,
        'color' => str_replace('#','',$color )
	);
	$data = htmlspecialchars( wp_json_encode( $query_args ) );
}elseif( 'host' == $host ){
	$video_class = 'host';
	$query_args = array(
		'loop' => 'yes' == $loop,
		'autoplay' => 'yes' == $autoplay && $featured_content_selected,
		'muted'   => 'yes' == $autoplay,
        'controls' => 'yes' == $show_controls,
        'poster'  => '',
		'volume'       => $volume,
		'is_stoppable' => $is_stoppable,
        'video_id' => $video_id

    );

}else{
    $video_class = 'embedded';
}


$gallery_item_class = ywcfav_get_gallery_item_class()
?>
<div class="<?php echo $gallery_item_class; ?> yith_featured_content <?php echo $browser; ?>"
     data-thumb="<?php echo $thumbnail_url; ?>">
    <div class="ywcfav-video-content <?php echo $video_class . ' ' . $aspect_ratio; ?>">
		<?php
		include( 'template_video_' . $video_class . '_player.php' );
		?>
    </div>
</div>