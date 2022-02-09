<?php 

$menu_items = wp_get_nav_menu_items( 'header-navigation' );
$menu_markup = '';

$count = 0;
$submenu = false;

$menu_markup = '
    <nav>
        <ul>';

foreach($menu_items as $menu_item) {
    $link = $menu_item->url;
    $title = $menu_item->title;
    $menu_id = $menu_item->object_id;

    if(!$menu_item->menu_item_parent) {
        $parent_id = $menu_item->ID;
        
        $menu_markup .= '<li class="pageid__' . $menu_id . '">';
        $menu_markup .= '<a href="' . $link . '">' . $title . '</a>' . "\n";
    } else {
        $menu_markup .= '<li class="pageid__' . $menu_id .' haschildren">' . $title .'<button class="submenu__toggle" type="button" aria-expanded="false" aria-label="Toggle Submenu">Open Submenu</button>';
    }

    if($parent_id == $menu_item->menu_item_parent) {

        if(!$submenu) {
            $submenu = true;
            $menu_markup .= '<ul class="submenu">' . "\n";
        }

        $menu_markup .= '<li><a href="' . $link . '">' . $title . '</a></li>' . "\n";

        if($menu_items[$count + 1]->menu_item_parent != $parent_id && $submenu) {
            $menu_markup .= '</ul>' . "\n";
            $submenu = false;
        }

    }

    if($menu_items[$count + 1]->menu_item_parent != $parent_id) {
        $menu_markup .= '</li>' . "\n";
        $submenu = false;
    }

    $count++;
}

$menu_markup .= '
        </ul>
    </nav>';

echo $menu_markup;


?>