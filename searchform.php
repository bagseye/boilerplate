<form role="search" method="get" class="searchform" action="<?php echo home_url('/') ?>">
    <label for="">
        <span class="sr__only"><?php echo _x('Search for:', 'boilerplate') ?></span>
        <input type="search" class="searchform__input" placeholder="<?php echo esc_attr_x('Search for...', 'boilerplate') ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x('What can we help you with?', 'boilerplate') ?>" />
    </label>
    <button type="submit"><?php echo esc_attr_x('Search', 'boilerplate') ?></button>
</form>