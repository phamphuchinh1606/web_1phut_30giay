<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function albumList(){
        $albums = $this->albumService->getAll();
        return $this->viewAdmin('album.album',[
            'albums' => $albums
        ]);
    }

    public function albumCreate(Request $request){
        $this->albumService->create($request);
        return redirect()->route('admin.album.album');
    }

    public function albumUpdate(Request $request){
        $this->albumService->update($request->id,$request);
        return redirect()->route('admin.album.album');
    }

    public function albumDestroy($id){
        $this->albumService->delete($id);
        return redirect()->route('admin.album.album');
    }
}
