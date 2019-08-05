<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        $blogs = $this->blogService->getAll();
        return $this->viewAdmin('blog.index',[
            'blogs' => $blogs
        ]);
    }

    public function showCreate(){
        return $this->viewAdmin('blog.create');
    }

    public function store(Request $request){
        $this->blogService->create($request);
        return redirect()->route('admin.blog.index');
    }

    public function showUpdate($id){
        $blog = $this->blogService->findId($id);
        return $this->viewAdmin('blog.update',[
            'blog' => $blog
        ]);
    }

    public function update($id, Request $request){
        $this->blogService->update($id, $request);
        return redirect()->route('admin.blog.index');
    }
}
