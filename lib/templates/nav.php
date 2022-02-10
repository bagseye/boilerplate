<?php 

$menu_items = wp_get_nav_items('header-navigation');

if($menu_items) {

    $menu = array();

    foreach($menu_items as $menu_item) {
        $tmpItemArr = array(
            'Text' => $menu_item->title,
            'Link' => $menu_item->url,
            'ObjID' => $menu_item->object_id,
        );

        populateNav($menu, $menu_item->menu_item_parent, $menu_item->ID, $tmpItemArr);

        echo '<div>
                <div>
                <ul>';
                
                foreach($menu as $menu_item_block) {
                    paintNav($menu_item_block);
                }
                echo '</ul>
                
                </div>
        
        </div>';
    }
}

function paintNav($menu_item_block) {

}

function populateNav(&$menu, $parent_id, $item_id, $tmpItemArr) {

    if($parent_id == 0) {

        // Top level item
        $menu[$item_id] = array(
            'Item'      => $tmpItemArr, 
            'Children'  => array()
        );
    } else {
        if(isset($menu[$parent_id])) {
            // Next Level 
            $menu[$parent_id]['Children'][$item_id] = array(
                'Item'      => $tmpItemArr,
                'Children'  => array(),
            );
        } else {
            // Lower Levels 
            foreach($menu as $menu_item_key => $menu_item_value) {
                if(count($menu[$menu_item_key]['Children']) > 0) {
                    populateNav($menu[$menu_item_key]['Children'], $parent_id, $item_id, $tmpItemArr);
                }

            }
        }
    }

}

// $menu_items = wp_get_nav_menu_items( 'header-navigation' );
// $menu_markup = '';

// $count = 0;
// $submenu = false;

// $menu_markup = '
//     <nav>
//         <ul>';

// foreach($menu_items as $menu_item) {
//     $link = $menu_item->url;
//     $title = $menu_item->title;
//     $menu_id = $menu_item->object_id;

//     if(!$menu_item->menu_item_parent) {
//         $parent_id = $menu_item->ID;
        
//         $menu_markup .= '<li class="pageid__' . $menu_id . '">';
//         $menu_markup .= '<a href="' . $link . '">' . $title . '</a>' . "\n";
//     } 
    
//     // Top 
//     if($menu_item->$menu_item_parent === 0) {
//         $menu_markup .= '<li class="pageid__' . $menu_id .' haschildren">' . $title .'<button class="submenu__toggle" type="button" aria-expanded="false" aria-label="Toggle Submenu">Open Submenu</button>';
//     }

//     if($parent_id == $menu_item->menu_item_parent) {

//         if(!$submenu) {
//             $submenu = true;
//             $menu_markup .= '<ul class="submenu">' . "\n";
//         }

//         $menu_markup .= '<li><a href="' . $link . '">' . $title . '</a></li>' . "\n";

//         if($menu_items[$count + 1]->menu_item_parent != $parent_id && $submenu) {
//             $menu_markup .= '</ul>' . "\n";
//             $submenu = false;
//         }

//     }

//     if($menu_items[$count + 1]->menu_item_parent != $parent_id) {
//         $menu_markup .= '</li>' . "\n";
//         $submenu = false;
//     }

//     $count++;
// }

// $menu_markup .= '
//         </ul>
//     </nav>';

// echo $menu_markup;


?>