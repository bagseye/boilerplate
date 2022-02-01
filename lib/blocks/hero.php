<?php 

/**
 * Block: Hero
 * 
*/

$id = get_sub_field('id');
$title = get_sub_field('title');

$modifiers = array();

if(is_404()) {

    $title = get_field('404_title', 'options');

    $modifiers[] = 'hero-error';

}

if(isset($no_content)) : 

    if($no_content === true) :

        $title = get_field('no_content_title', 'options');

        $modifiers[] = 'hero-error';

    endif;

else : 

    $no_content = false;

endif;

?>

<section <?php if($id) : ?>id="<?php echo $id; ?>"<?php endif; ?> class="hero <?php echo implode(" ", $modifiers); ?> ">
    <h1><?php echo $title ?></h1>
</section>