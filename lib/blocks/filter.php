<?php 
$cats = get_categories();
?>
<select name="categoryDropdown" id="" onchange="document.location.pathname='/category/' + this.options[this.selectedIndex].value">
    <option value=""><?php esc_attr('Select Category', THEME_NAME) ?></option>
    <?php foreach($cats as $cat) : ?>
        <option value="<?php echo $cat->slug ?>"><?php echo $cat->name ?></option>
    <?php endforeach; ?>
</select>

<select name="archiveDropdown" id="" onchange="document.location.href=this.options[this.selectedIndex].value">
    <option value=""><?php esc_attr('Select Month', THEME_NAME); ?></option>
    <?php 
    wp_get_archives(
        array(
            'type'              => 'monthly',
            'format'            => 'option',
            'show_post_count'   => 1
        )
        );
    ?>
</select>

<?php $authors = get_users(); ?>
<select name="authorDropdown" id="" onchange="document.location.pathname='/author/' + this.options[this.selectedIndex].value">
        <option value=""><?php esc_attr('Select Author', THEME_NAME ); ?></option>
        <?php foreach($authors as $author) : ?>
            <option value="<?php echo $author->user_nicename ?>"><?php echo $author->display_name; ?></option>
        <?php endforeach; ?>
</select>