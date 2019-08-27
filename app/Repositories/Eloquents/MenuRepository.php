<?php

namespace App\Repositories\Eloquents;

use App\Common\Constant;
use App\Common\RoleConstant;
use App\Models\Menu;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class MenuRepository extends BaseRepository
{
    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    public function selectAll($menuType = null)
    {
        $query = $this->model::orderBy('sort_num')->orderBy('child_sort_num');
        if(isset($menuType)){
            $query->where('menu_type',$menuType);
        }
        $listMenu = $query->get();
        $menus = [];
        foreach ($listMenu as $menu){
            if(isset($menu->parent_menu_id) && !empty($menu->parent_menu_id)){
                if(isset($menus[$menu->parent_menu_id])){
                    if(isset($menus[$menu->parent_menu_id]->child_menus)){
                        $menuItem = $menus[$menu->parent_menu_id];
                        $arrayChildMenu = $menuItem->child_menus;
                        $arrayChildMenu[] = $menu;
                        $menus[$menu->parent_menu_id]->child_menus = $arrayChildMenu;
                    }else{
                        $menus[$menu->parent_menu_id]->child_menus = [$menu];
                    }
                }
            }else{
                $menus[$menu->menu_id] = $menu;
            }
        }
        return $menus;
    }

}
