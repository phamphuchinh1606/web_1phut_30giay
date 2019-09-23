<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquents\ScreenRepository;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    protected $screenRepository;

    public function __construct(ScreenRepository $screenRepository)
    {
        $this->screenRepository = $screenRepository;
    }

    public function index(){
        $screens = $this->screenRepository->selectAll();
        return $this->viewAdmin('screen.index',[
            'screens' => $screens
        ]);
    }

    public function showCreate(){
        $screens = $this->screenRepository->getScreenByRole();
        $screenMap = [];
        foreach ($screens as $screen){
            $screenMap[$screen->screen_type][] = $screen;
        }
        return $this->viewAdmin('screen.create',[
            'screenMap' => $screenMap
        ]);
    }

    public function create(Request $request){
        $values = $request->all();
        $this->screenRepository->create($values);
        return redirect()->route('admin.setting.screen')->with('message','Thêm màn hình thành công');
    }

    public function showUpdate($id){
        $screen = $this->screenRepository->find($id);
        $screens = $this->screenRepository->getScreenByRole();
        $screenMap = [];
        foreach ($screens as $screenItem){
            $screenMap[$screenItem->screen_type][] = $screenItem;
        }
        return $this->viewAdmin('screen.update',[
            'screenMap' => $screenMap,
            'screen' => $screen
        ]);
    }

    public function update($id , Request $request){
        $values = $request->all();
        $values['id'] = $id;
        $this->screenRepository->update($values);
        return redirect()->route('admin.setting.screen')->with('message','Cập nhật màn hình thành công');
    }

    public function delete(Request $request){
        $this->screenRepository->deleteLogic(['screen_id' => $request->id]);
        return redirect()->route('admin.setting.screen')->with('message','Xóa màn hình thành công');
    }
}
