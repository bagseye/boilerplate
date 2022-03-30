<?php

/**
 * Video Block Template.
 *
 */

// Create id attribute allowing for custom "anchor" value.
$id = null;

$section_name = get_field('section_name');
if(!empty($section_name)) {
    $id = str_replace(' ', '', $section_name);
} else {
    $id = 'videoblock-' . $block['id'];
    if( !empty($block['anchor']) ) {
        $id = $block['anchor'];
    }
}



// Create class attribute allowing for custom "className" and "align" values.
$block_class = 'videoblock';
$modifiers = null;

if( !empty($block['className']) ) {
    $modifiers .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $modifiers .= ' align' . $block['align'];
}

$video_embed = get_field('video_embed', false, false);
$video_placeholder = get_field('video_placeholder');
$video_markup = null;
$video_iframe = "<iframe class='{$block_class}__video' loading='lazy' src='{$video_embed}'></iframe>";


$yt_regex = '~(https?\:\/\/)?((www\.)?youtube\.?(com)?|youtu\.be)\/.+$~';

// If it matches a Youtube URL, use an iframe
if (preg_match($yt_regex, $video_embed)) {
    $video_markup = $video_iframe;
}

?>

<div id="<?php echo $id ?>" class="<?php echo $block_class ?> <?php echo $modifiers ?>">
    <div class="<?php echo $block_class ?>__container">
        <div class="<?php echo $block_class ?>__embed">
            <?php echo $video_markup ?>
            <div class="<?php echo $block_class ?>__placeholder">
                <picture>
                    <?php echo wp_filter_content_tags('<img class="wp-image-' . $video_placeholder['ID'] . '" src="' . $video_placeholder['sizes']['full'] . '" alt="' . $video_placeholder['alt'] . '" />'); ?>
                </picture>
            </div>
        </div>
    </div>
</div>