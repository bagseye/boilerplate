<?php 

// GET THE NAV MENU
$menu_items = wp_get_nav_menu_items('header-navigation');

if($menu_items) {

    $menu = array();

    /**
     * CREATE AN ARRAY FOR EACH MENU ITEM
     * For each menu item in the array
     * Create a temp array item
    */
    foreach($menu_items as $menu_item) {
        $temp_menu_item = array(
            'ID'        => $menu_item->ID,
            'Text'      => $menu_item->title,
            'Link'      => $menu_item->url,
            'Parent'    => $menu_item->menu_item_parent,
            'ObjectID'  => $menu_item->object_id,
        );

        /**
         * GENERATE THE MENUS
         * For each $menu_item, run populateNav()
         * Pass the original $menu array and each $temp_menu_item
         * 
        */
        populateNav($menu, $temp_menu_item);
    }

    echo '<ul>';

    /**
     * PAINT THE NAV
     * Now the $menu array has been populated
     * Paint each menu item in $menu 
     * 
    */
    foreach($menu as $single_menu_item) {
        paintNav($single_menu_item);
    }

    echo '</ul>';

}

function paintNav($single_menu_item) {

    $children = $single_menu_item['Children'];
    $id = $single_menu_item['Item']['ID'];
    $link = $single_menu_item['Item']['Link'];
    $text = $single_menu_item['Item']['Text'];
    $object_id = $single_menu_item['Item']['ObjectID'];

    // CHECK FOR SUB MENUS
    if(isset($children) && is_array($children) && count($children) > 0) {
        /**
         * CREATE THE PARENT LINK
         * 
        */
        echo '<li class="pageid__' . $object_id . ' navigation__hasChildren">';
            echo '<a href="' . $link . '">' . $text . '</a><button>Sub Menu</button>';

            /**
             * SUB ITEMS
             * Run paintNav() for each $children array
            */
            echo '<div class="navigation__sub">
                    <ul>';
                    
                    foreach($children as $child_menu) {
                        paintNav($child_menu);
                    }

              echo '</ul>
              </div>
            </li>';
        
    } else {
        /**
         * NO CHILDREN
         * Just echo a standard menu item
         */
        echo '<li class="pageid__' . $object_id . '">
                <a href="' . $link . '">' . $text . '</a>
            </li>';
    }
}

function populateNav(&$menu, $temp_menu_item) {
    $parent_id = $temp_menu_item['Parent'];
    $item_id = $temp_menu_item['ID'];

    if($parent_id == 0) {
        /**
         * TOP LEVEL ITEM
         * Create an array made up of the menu items $temp_menu_item array values
        */
        $menu[$item_id] = array(
            'Item' => $temp_menu_item,
            // 'Children' => array()
        );
    } else {
        if(isset($menu[$parent_id])) {
            /**
             * IS A CHILD ITEM
             * Create another array using its $temp_menu_item and create another empty 'Children' array()
            */
            $menu[$parent_id]['Children'][$item_id] = array(
                'Item' => $temp_menu_item,
                'Children' => array()
            );
        } else {
            /**
             * LOWER LEVELS RECURSIVE
            */
            foreach($menu as $menu_item_key => $menu_item_value) {
                /**
                 * DOES MENU ITEM HAVE CHILDREN?
                 * If so, run the populateNav() function again
                 * Pass the 'Children' array as the $menu param
                */
                if(count($menu[$menu_item_key]['Children']) > 0) {
                    populateNav($menu[$menu_item_key]['Children'], $temp_menu_item);
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