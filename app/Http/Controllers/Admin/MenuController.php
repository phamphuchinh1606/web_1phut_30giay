<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquents\MenuRepository;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function index(){
        $listMenu = $this->menuRepository->getAllMenu();
        return $this->viewAdmin('menu.index',[
            'listMenu' => $listMenu
        ]);
    }

    public function showCreate(){
        $menus = $this->menuRepository->getMenuParentIsNull();
        $menuMap = [];
        foreach ($menus as $menu){
            $menuMap[$menu->menu_type][] = $menu;
        }
        return $this->viewAdmin('menu.create',[
            'menuMap' => $menuMap
        ]);
    }

    public function create(Request $request){
        $values = $request->all();
        $this->menuRepository->create($values);
        return redirect()->route('admin.setting.menu')->with('message','Thêm menu thành công');
    }

    public function showUpdate($id){
        $menu = $this->menuRepository->find($id);
        $menus = $this->menuRepository->getMenuParentIsNull();
        $menuMap = [];
        foreach ($menus as $menuItem){
            $menuMap[$menuItem->menu_type][] = $menuItem;
        }
        return $this->viewAdmin('menu.update',[
            'menuMap' => $menuMap,
            'menu' => $menu
        ]);
    }

    public function update($id , Request $request){
        $values = $request->all();
        $this->menuRepository->update($values);
        return redirect()->route('admin.setting.menu')->with('message','Cập nhật menu thành công');
    }

    public function delete($id,Request $request){
        $this->menuRepository->deleteLogic(['menu_id' => $id]);
        return redirect()->route('admin.setting.menu')->with('message','Xóa menu thành công');
    }
}
